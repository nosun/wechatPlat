<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;
use Share\Models\Article;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Session;
use Share\Models\WechatSite;
use Share\Tools\Ajax;
use Sunra\PhpSimple\HtmlDomParser;
use DB;

class ArticleController extends Controller
{

    public function index(Request $request){

        $path = '/articles';
        $arguments = $request->all();

        $page = isset($arguments['page']) ? $arguments['page'] : 1;

        unset($arguments['_token']);
        unset($arguments['page']);

        $article = new Article();
        $article = $article->where('status','=','1');

        foreach($arguments as $key => $val){
            if($val == -1){
                continue;
            }

            if($key == "key"){
                $searchKey = $val;
                continue;
            }

            if(isset($searchKey) && $key == "keywords"){
                $article = $article->where($searchKey,'like',"%$val%");
            }else{
                $article = $article->where($key, '=',$val);
            }

        }

        $query = http_build_query($arguments);
        $path .= '?'.$query;

        $pageSize = 15;

        $count  = $article->count();
        $articles = $article->orderBy('used','desc') // 待用: 1; 已用 = -1; 默认 = 0
                        ->orderBy('date','desc')
                        ->skip(($page-1) * $pageSize)->take($pageSize)->get();

        $paginator = new LengthAwarePaginator($articles, $count, $pageSize, $page);
        $paginator->setPath(url($path));

        return view("article.list")
                ->with('articles',$articles)
                ->with('page',$paginator)
                ->with('option',$arguments);
    }

    public function show($id){
        $article = Article::find($id);
        $content = $article->content->content;
        $content = str_replace("<br/>","",$content);
        $content = str_replace("<p></p>","",$content);
        $dom = HtmlDomParser::str_get_html($content);
        $images = $dom->find('img');

        foreach($images as $image){
            //if($src = $image->getAttribute('data-src')){
            //    $image->setAttribute('src', $src);
            //}
            $image->clear();
        }

//        $ps = $dom->find('p');
//
//        foreach($ps as $p){
//            $p->removeAttribute('style');
//        }

        $videos = $dom->find('.video_iframe');
        foreach($videos as $video){
            if($src = $video->getAttribute('data-src')){
                $_arr= explode(';',$src);
                $video->setAttribute('src',$_arr[0]);
                $video->setAttribute('width',500);
                $video->setAttribute('height',375);
            }
        }

        $article->content = (string)$dom;
        return view("article.show")->with('article',$article);
    }

    public function updateArticle($id,Request $request){
        $arguments = $request->all();

        if(empty($id) || empty($arguments)){
            return Ajax::argumentsError();
        }

        $article = Article::find($id);

        if(empty($article)){
            return Ajax::dataEmpty();
        }

        $article->fill($arguments)->save();

        return Ajax::success();
    }
}
