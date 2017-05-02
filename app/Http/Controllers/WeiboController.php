<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;
use Share\Services\WeiboFactory;

use Illuminate\Pagination\LengthAwarePaginator;
use Share\Searches\ArticleIndexSearch;
use Share\ModelHelpers\ArticleHelper;
use Share\Exceptions\OAuthException;
use Cache;
use GuzzleHttp\Client;
use DB;

class WeiboController extends Controller
{
    public function __construct(){
        $this->user = is_login();
        $this->hash = hReturnEcmsHashStrAll();
    }

    public function callback(Request $request){
        if(!isset($request->code)){
            $auth = WeiboFactory::getWeiboAuth();
            $authUrl = $auth->getAuthorizeURL(config('weibo.WB_CALLBACK_URL').$this->hash['whehref']);

            $error = '<p>Error : No authorization code, please reauthorize.</p>';
            $error .= "<p>Please click&nbsp;&nbsp;<a href='$authUrl' class='alert-link'>here</a>&nbsp;&nbsp;for authorization.</p>";

            return redirect('weibo/send')->with('error', $error);
        }

        $auth = WeiboFactory::getWeiboAuth();
        $keys = [
            'code' => $request->code,
            'redirect_uri' => config('weibo.WB_CALLBACK_URL').$this->hash['whehref'],
        ];

        try {
            $token = $auth->getAccessToken( 'code', $keys ) ;
        } catch (OAuthException $e) {
            $authUrl = $auth->getAuthorizeURL(config('weibo.WB_CALLBACK_URL').$this->hash['whehref']);

            $error = '<p>Error : '.$e->getMessage().'</p>';
            $error .= "<p>Please click&nbsp;&nbsp;<a href='$authUrl' class='alert-link'>here</a>&nbsp;&nbsp;for authorization.</p>";

            return redirect('weibo/send')->with('error', $error);
        }

        Cache::put('weibo_access_token', $token['access_token'], $token['expires_in']/60);
        return redirect(url('weibo/send'))->with('success', 'Authorized success!');
    }

    public function articleList(Request $request){
        $post = $request->all();
        $path = '/e/extend/share/public/weibo/list';
        unset($post['_token']);
        unset($post['page']);

        foreach($post as $key => $val){
            if(strpos($key,'ehash') === 0){
                unset($post[$key]);
            }
        }

        $search = DB::table('cwcms_ecms_article_index as i')->select(['i.id', 'checked']);
        if(isset($post['keywords']) && $post['keywords'] && isset($post['field']) && $post['field']){
            $search->join('cwcms_ecms_article as a', 'i.id', '=', 'a.id', 'left')
                ->join('cwcms_ecms_article_check as c', 'i.id', '=', 'c.id', 'left')
                ->where(function($query)use($post){
                    $query->where('a.'.$post['field'], 'like', '%'.$post['keywords'].'%')->orWhere('c.'.$post['field'], 'like', '%'.$post['keywords'].'%');
                });
            $query = http_build_query($post);
            $path .= '?'.$query;
        }
        $num = $search->count('*');

        $pageRow = 30;
        $page  = isset($request->page) ? $request->page : 1;
        $search->limit($pageRow)->skip(($page-1)*$pageRow)->orderBy('i.newstime', 'desc');

        $ids = $search->get();
        $articles = ArticleIndexSearch::instance()->getByIds($ids);

        $pagination = new LengthAwarePaginator($articles, $num, $pageRow);
        $pagination->setPath($path.$this->hash['whehref']);

        return view('weibo.list',[
            'post' => $post,
            'articles' => $articles,
            'pagination' => $pagination,
            'hash' => $this->hash
        ]);
    }

    public function send($id = 0, Request $request){

        $article = null;
        $newstextPic = null;
        if($id){
            $article = ArticleHelper::find($id);
        }
        $post = $request->old();
        $error = session('error', null);
        $success = session('success', null);

        return view('weibo.form',[
            'article' => $article,
            'post' => $post,
            'error' => $error,
            'success' => $success,
            'hash' => $this->hash
        ]);
    }

    public function save(Request $request){
        $post = $request->all();
        if(!$post['content']){
            return redirect()->back()->with('error', 'Weibo content can not be empty')->withInput();
        }

        $client = WeiboFactory::getWeiboClient();

        if(!$client){
            $auth = WeiboFactory::getWeiboAuth();
            $authUrl = $auth->getAuthorizeURL(config('weibo.WB_CALLBACK_URL').$this->hash['whehref']);
            $error = '<p>Error : If you have not already done so, please click on the link below for authorization</p>';
            $error .= "<p><a href='$authUrl' class='alert-link'>Authorize</a></p>";
            return redirect()->back()->with('error', $error)->withInput();
        }

        if($post['id']){
            $article = ArticleHelper::find($post['id']);

            $imageSelect = isset($post['select-image']) ? $post['select-image'] : 'titlepic';
            $image = null;
            if($imageSelect == 'titlepic'){
                $image = $article->titlepic;
            }else{
                $image = $article->getNewstextImageUrl();
            }

            $guzzle = new Client();
            $contentLength = $guzzle->head($image)->getHeader('Content-Length');
            if($contentLength/(1024*1024)>=5){
                $error = '<p>Error : Your uploaded image exceeds size limit (5M), please modify and re-upload</p>';
                return redirect()->back()->with('error', $error)->withInput();
            }

            $result = $client->upload($post['content'], $image);
        }else{
            $file = $request->file('upload-image');
            if($file->getClientSize()/(1024*1014) >= 5){
                $error = '<p>Error : Your uploaded image exceeds size limit (5M), please modify and re-upload</p>';
                return redirect()->back()->with('error', $error)->withInput();
            }
            $ext  = strtolower($file->getClientOriginalExtension());
            $fileName = md5($file->getClientOriginalName().time()) . '.' . $ext;
            $filePath = 'uploads';
            $file = $file ->move($filePath, $fileName);

            $result = $client->upload($post['content'], $file->getRealPath());
            unlink($file->getRealPath());
        }

        $result = \GuzzleHttp\json_decode($result);
        if(isset($result->error_code) && isset($result->error)){
            $auth = WeiboFactory::getWeiboAuth();
            $authUrl = $auth->getAuthorizeURL(config('weibo.WB_CALLBACK_URL').$this->hash['whehref']);
            $error = '<p>Error : '.$result->error.'</p>';
            $error .= '<p>If it is a licensing issue, you can also try clicking on the link below to authorize it.</p>';
            $error .= "<p><a href='$authUrl' class='alert-link'>Authorize</a></p>";

            return redirect()->back()->with('error', $error)->withInput();
        }else{
            return redirect(url('/weibo/send/').$this->hash['whehref'])->with('success', '<p>Push to weibo success</p>');
        }
    }
}
