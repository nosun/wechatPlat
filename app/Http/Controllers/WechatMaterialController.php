<?php

namespace Share\Http\Controllers;

use EasyWeChat\Material\Material;
use EasyWeChat\Message\Article;
use EasyWeChat\Message\Image;
use Mockery\CountValidator\Exception;
use Share\ModelHelpers\ArticleHelper;
use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use Log;
use DB;
use Share\ModelHelpers\WechatContentModelHelper;
use Share\Models\WechatContent;
use Share\Models\WechatImage;
use Share\Models\WechatNews;
use Share\Searches\WechatContentsSearch;
use Share\Searches\WechatNewsSearch;
use Share\Searches\ArticleIndexSearch;
use Illuminate\Pagination\LengthAwarePaginator;
use Share\Tools\Ajax;
use EasyWeChat\Core\Exceptions\HttpException;
use Sunra\PhpSimple\HtmlDomParser;


class WechatMaterialController extends Controller
{

    public function __construct(){
        $this->user = is_login();
        $this->hash = hReturnEcmsHashStrAll();
    }

    public function newsList(Request $request){
        $pageRow = config('cwzg.wxListPageRow',3);
        $page = isset($request->page) ? $request->page : 1;
        $search = WechatNewsSearch::instance();
        $count = $search->count();
        $news = $search->orderBy('created_at desc')->page($page, $pageRow)->get();
        $paginator = new LengthAwarePaginator($news, $count, $pageRow, $page);
        $paginator->setPath(url('/wechat/newsList').$this->hash['whehref']);
        return view('wechat.news-list', [
            'hash' => $this->hash,
            'user' => $this->user,
            'paginator' => $paginator,
            'success' => session('success', null),
            'error' => session('error', null),
        ]);
    }

    public function testPushUploadNews($id){
        try{
            throw (new HttpException);
        } catch( HttpException $e) {
            Log::error($e->getMessage());
            return redirect(url('wechat/newsList' . $this->hash['whehref']))
                ->with('error', '素材中有异常字符，素材推送失败！');
        }
    }

    public function pushUploadNews($id,Application $wechat){
        $material = $wechat->material;

        $news = WechatNews::find($id);

        if(empty($news)){
            return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('error', '素材不存在！');
        }

        $contents = WechatContent::where('media_id',$news->id)->get();

        if(empty($contents)){
            return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('error', '素材内容为空！');
        }

        $articles = [];
        foreach($contents as $content){
            $content  = $this->formatArticleThumb($content,$material);

            if(isset($content['result']) && $content['result'] == false){
                return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('success', $content['message']);
            }

            $content  = $this->formatArticleContent($content,$material);
            $articles[] = $this->formatArticle($content);
        }

        try{
            $result = $material->uploadArticle($articles);
            if($result && $result['errcode'] == 0 ){
                // 更新素材media_id
                $news->media_id = $result['media_id'];
                $news->save();

                // 更新素材内容的 media_id
                $contents = $news->getContents();

                foreach($contents as $content){
                    $content->media_id = $news->media_id;
                    $content->save();
                }
                return redirect(url('wechat/newsList'.$this->hash['whehref']))
                           ->with('success', '素材添加成功！');
            }else{
                return redirect(url('wechat/newsList'.$this->hash['whehref']))
                           ->with('error', '素材推送失败！错误信息为：'.$result['errmsg']);
            }
        } catch( HttpException $e){
            Log::error($e->getMessage());
            return redirect(url('wechat/newsList'.$this->hash['whehref']))
                        ->with('error', $e->getMessage().',素材推送失败！');
        }
    }


    public function pushUpdateNews($id,Application $wechat){
        $material = $wechat->material;

        $news = WechatNews::find($id);

        if(empty($news)){
            return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('success', '素材不存在！');
        }

        $contents = WechatContent::where('media_id',$news->media_id)->get();

        if(empty($contents)){
            return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('success', '素材无内容！');
        }

        $result = [];

        foreach($contents as $content){
            $content  = $this->formatArticleThumb($content,$material);

            if(isset($content['result']) && $content['result'] == false){
                return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('success', $content['message']);
            }

            $content  = $this->formatArticleContent($content,$material);
            $article  = $this->formatArticle($content)->toArray();

            try{
                $result[] = $material->updateArticle($content->media_id,$article,($content->idx - 1));
                Log::debug('success push article'.$content->id);
            } catch( HttpException $e){
                Log::error($e->getMessage());
                return redirect(url('wechat/newsList'.$this->hash['whehref']))
                    ->with('error', $e->getMessage().',素材推送失败！');
            }
        }

        Log::info(json_encode($result));

        return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('success', '素材更新成功！');
    }

    protected function formatArticleThumb(WechatContent $content,Material $material){

        if(empty($content['thumb_media_id'])){ // 说明该 content 没有成功上传缩略图.

            $thumb = file_get_contents($content['thumb_url']);

            if(empty($thumb)){
                return ['result' => false, 'message' => '未能获取到缩略图'];
            }

            $tmp  = explode("/", image_type_to_mime_type(exif_imagetype($content['thumb_url'])));
            $ext  = end($tmp);
            $path = WechatContentModelHelper::saveFile($thumb,$ext);

            // 上传到 微信 server
            $result = $material->uploadImage($path['real_path']);

            if(!$result){
                return ['result' => false, 'message' => '上传缩略图到微信服务器出错'];
            }

            $content->thumb_url = $result['url'];
            $content->thumb_media_id  = $result['media_id'];
            $content->save();

            $image = WechatImage::firstOrNew(['media_id' => $result['media_id']]);
            $image->url  = $content->thumb_url;
            $image->path = $path['path'];
            $image->save();
        }

        return $content;
    }

    protected function formatArticleContent(WechatContent $content,Material $material){
        $cont = HtmlDomParser::str_get_html($content->content);
        $images = $cont->find('img');

        foreach($images as $image){
            $image_src  = $image->getAttribute('src');

            // 已经是微信的图片了
            if(strpos($image_src,'mmbiz.qpic.cn')){
                continue;
            }

            $image_file = '';

            try{
                $image_file = file_get_contents($image_src);
            } catch (\ErrorException $e){
                //
            }

            // 未能获取到图片
            if(!$image_file){
                continue;
            }

            $tmp  = explode("/", image_type_to_mime_type(exif_imagetype($content['thumb_url'])));
            $ext  = end($tmp);


            $path   = "/tmp/".time().rand(1111,9999).'.'.$ext;

            file_put_contents($path,$image_file);

            $result = $material->uploadArticleImage($path);

            // 上传微信异常
            if(empty($result)){
                continue;
            }

            $image->setAttribute('src',$result->url);
        }

        $content->content = (string) $cont;

        $content->save();

        return $content;
    }


    protected function formatArticle(WechatContent $content){
        $article = new Article();

        $article['title']          = $content->title;
        $article['thumb_media_id'] = $content->thumb_media_id;
        $article['author']         = $content->author;
        $article['digest']         = $content->digest;
        $article['show_cover_pic'] = $content->show_cover_pic;
        $article['content']        = $content->content;
        $article['content_source_url'] = $content->content_source_url;

        return $article;
    }

    // 删除素材
    public function delete($id,Application $wechat){

        $news = WechatNews::find($id);
        $material = $wechat->material;

        if($news){
            $news->deleteContents();
            $news->delete();

            try{
                $material->delete($news->media_id);
            }catch (HttpException $e){
                // do nothing
            }

            return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('success', '素材删除成功！');
        }

        return redirect(url('wechat/newsList'.$this->hash['whehref']))->with('error', '素材不存在！');
    }

    // 添加
    public function create(){
        $title = '文章添加';
        $templates = ['default'];
        return view('wechat.newsEdit')
            ->with('hash', $this->hash)
            ->with('user', $this->user)
            ->with('title',$title)
            ->with('templates',$templates);
    }

    // 预览
    public function contentShow($id){

        $title = '文章预览';
        $content  = WechatContent::find($id);
        $template = !empty($content->template) ? $content->template : 'default';

        return view('wechat.news-show-'.$template)
            ->with('title',$title)
            ->with('content', $content)       // 素材的中的一个 item
            ->with('hash',$this->hash);
    }

    public function edit($id){

        $news = WechatNews::find($id);
        if(!$news){
            return redirect(url('/wechat/news'));
        }

        if(empty($news->media_id)){
            $news->media_id = $news->id;
        }

        $contents = $news->getContents();
        $articles = [];
        foreach($contents as $content){
            $article = $content->convertArticle();
            $articles[$article['fid']] = $article;
        }

        $content = !empty($contents) ? $contents[0] : null;

        $templates = ['default'];
        $title = '文章编辑';
        return view('wechat.newsEdit', [
            'hash' => $this->hash,
            'user' => $this->user,
            'title' => $title,
            'news' => $news,
            'templates' => $templates,
            'content' => $content,
            'contents' => $contents,
            'articles' => $articles,
        ]);
    }


    public function articleList(Request $request){
        $post = $request->all();
        $path = '/wechat/article/list';

        $search = DB::table('cwcms_ecms_article_index as i')->select(['i.id', 'checked']);
        if(isset($post['keywords']) && $post['keywords'] && isset($post['field']) && $post['field']){
            $search->join('cwcms_ecms_article as a', 'i.id', '=', 'a.id', 'left')
                ->join('cwcms_ecms_article_check as c', 'i.id', '=', 'c.id', 'left')
                ->where(function($query)use($post){
                    $query->where('a.'.$post['field'], 'like', '%'.$post['keywords'].'%')->orWhere('c.'.$post['field'], 'like', '%'.$post['keywords'].'%');
                });
            unset($post['_token']);
            unset($post['page']);
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
        $pagination->setPath(url($path).$this->hash['whehref']);

        return view('wechat.article-list',[
            'hash' => $this->hash,
            'user' => $this->user,
            'post' => $post,
            'pagination' => $pagination,
        ]);
    }

    // get article from the article list by id
    public function ajaxGetArticle(Request $request){

        if(!isset($request->id)){
            return Ajax::argumentsError('Id is required!');
        }
        
        // clear cache
        ArticleHelper::clearArticleCache($request->id);

        $article = ArticleIndexSearch::instance()->where('id', $request->id)->first();
        if($article){
            $article = [
                'id' => $article->id,
                'title' => $article->ftitle ? $article->ftitle : $article->title,
                'titlepic' => $article->titlepic,
                'titleurl' => $article->titleurl,
                'author' => $article->author,
                'smalltext' => $article->smalltext,
                'newstext' => $article->newstext
            ];
        }

        return Ajax::success($article);
    }

    // save wx media content
    public function ajaxContentSave(Request $request){

        if(!isset($request->article)){
            return Ajax::argumentsError('Article data is required!');
        }

        $article = $request->article;
        $segId = 0;

        if($article['type'] == 'content'){
            $fidSeg = explode('-', $article['fid']);

            if($fidSeg[0] == 'content' && isset($fidSeg[1])){
                $segId = $fidSeg[1];
            }
        }

        $contentData = [
            'idx' => $article['idx'],
            'title' => $article['title'],
            'author' => $article['author'],
            'template' => $article['template'],
            'digest'  => $article['smalltext'],
            'content' => $article['newstext'],
            'note'    => $article['note'],
            'content_source_url' => $article['titleurl'],
        ];

        if(isset($article['titlepic'])){
            $contentData['thumb_url'] = $article['titlepic'];
        }

        // get news
        $news = WechatNewsSearch::instance()->getNewsByMediaId($article['mediaId']);

        if(!($news)){
            $news = new WechatNews();
            $news->save();
        }

        // get contents
        $content = WechatContent::find($segId);
        if(empty($content)){
            $content = new WechatContent();
            $content->media_id = $news->media_id ? $news->media_id : $news->id;
        }

        $content->fill($contentData);
        $content->save();

        return Ajax::success(['article'=>$content->convertArticle()]);
    }

    public function ajaxTitlePicSave(Request $request){
        return Ajax::success($request->file('image')->getRealPath());
    }

    // 本地删除，素材，的某篇文章
    public function ajaxContentDelete(Request $request){
        if(!isset($request->id)){
            return Ajax::argumentsError('Id is required!');
        }

        $content = WechatContent::find($request->id);

        if($content){
            $content->delete();
        }

        return Ajax::success('Delete content success!');
    }


    public function testStatus(Application $wechat){
        $material = $wechat->material;
        $stats = $material->stats();
        return $stats;
    }

    public function testGetList(Application $wechat){
        $material = $wechat->material;
        $lists = $material->lists('news',1,5);
        return $lists;
    }

    public function testGetNews($id, Application $wechat){
        $material = $wechat->material;
        $news     = WechatNews::find($id);

        if(empty($news)){
            return Ajax::dataEmpty();
        }

        $result = $material->get($news->media_id);

        return $result;
    }

    public function testDeleteNews($id, Application $wechat){
        $material = $wechat->material;
        $news     = WechatNews::find($id);

        if(empty($news)){
            return Ajax::dataEmpty();
        }

        $result = $material->delete($news->media_id);

        return $result;
    }

    public function testCreateNews($id,Application $wechat){
        $material = $wechat->material;

        $news = WechatNews::find($id);

        if(empty($news)){
            return Ajax::dataEmpty();
        }


        $contents = WechatContent::where('media_id',$news->media_id)->get();
        $articles = [];
        foreach($contents as $content){
            $articles[] = $this->formatArticle($content);
        }

        $result = $material->uploadArticle($articles);

        return $result;
    }

    public function testUpdateContent($id,Application $wechat){
        $material = $wechat->material;

        $content = WechatContent::find($id);

        if(empty($content)){
            return Ajax::dataEmpty();
        }

        $content->title = $content->title.'test';
        $article = $this->formatArticle($content)->toArray();

        $result = $material->updateArticle($content->media_id,$article,($content->idx - 1));

        return $result;
    }

    public function testUpdateContentAll($id,Application $wechat){
        $material = $wechat->material;

        $news = WechatNews::find($id);

        if(empty($news)){
            return Ajax::dataEmpty();
        }

        $contents = WechatContent::where('media_id',$news->media_id)->get();

        $result = [];

        foreach($contents as $content){
            $content->title = $content->title.'test';
            $article = $this->formatArticle($content)->toArray();
            $result[] = $material->updateArticle($content->media_id,$article,($content->idx - 1));
        }

        return $result;
    }

    public function testdeleteContent($id,Application $wechat){
        $material = $wechat->material;

        $content = WechatContent::find($id);

        if(empty($content)){
            return Ajax::dataEmpty();
        }

        // 行不通
        $result = $material->updateArticle($content->media_id,[],($content->idx - 1));

        return $result;
    }

    // 拉取
    public function download(Application $wechat,Request $request){

        $type  = $request->input('type','news');
        $max   = (int) $request->input('max', 10);
        $days  = (int) $request->input('days',7);
        $page  = (int) $request->input('page',1);
        $pageNum  = (int) $request->input('pageNum',10);

        $material = $wechat->material;

        $stats = json_decode($material->stats());
        $count = $stats->{$type.'_count'};

        if($max !== 'all'){
            $count = $max > $count ? $count : $max;
        }

        $pageTotal = (int) floor($count / $pageNum) + 1;

        while($page < (int) $pageTotal ){
            $offset  = $pageNum * ( $page -1 );
            $lists = $material->lists($type,$offset,$pageNum);
            foreach($lists['item'] as $item){
                switch($type){
                    case 'news': // only download news
                        $itemTime  = WechatContentModelHelper::getItemTime($item);
                        $beginTime =  time() - 86400 * $days;

                        if( $itemTime < $beginTime) {
                            return 'finished';
                        }

                        WechatContentModelHelper::saveNews($item);
                        break;
                    default:
                        return 'no this type';
                }
            }

            $log = [
                'type' => $type,
                'page' => $page,
                'max'  => $max,
                'days' => $days,
                'pageNum' => $pageNum,
                'time' => time()
            ];
            Log::info(json_encode($log));

            $page ++;
        }
        return 'finished';
    }

}
