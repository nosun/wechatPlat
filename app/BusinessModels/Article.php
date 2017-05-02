<?php

namespace Share\BusinessModels;

use Share\ModelHelpers\TopicHelper;
use Share\Models\Article as DbArticle;
use Share\ModelHelpers\ArticleHelper;
use Share\ModelHelpers\TagHelper;

use Share\ModelHelpers\EnewsclassHelper;
use Share\Searches\AuthorSearch;
use Share\Searches\ArticleSearch;
use Share\Services\WeiboFactory;


use Cookie;
use Cache;
use DB;

class Article extends Model{
    protected $id = null;
    protected $dbPre = null;

    public function __construct($id)
    {
        $this->id = $id;
        $this->dbPre = config('cwzg.edbPrefix');
        $cacheId = 'article-model-'.$id;
        $this->model = Cache::remember($cacheId, CACHE_TIME, function()use($id){
            return DbArticle::find($id);
        });

        if($this->model){
            $this->model->title = stripslashes($this->model->title);
            $this->model->ftitle = stripslashes($this->model->ftitle);
            $this->model->author = $this->model->author ? $this->model->author : '佚名';
            $enewsclass = $this->getArticleClass();
            $url = '/'.$enewsclass->classpath.'/'. $this->model->newspath.'/'. $this->model->filename.$enewsclass->filetype;
            $this->attributes['url'] = url($url);
        }
    }

    protected function asynLoad1(){
        $this->attributes = array_merge($this->attributes, $this->getArticleData(), $this->getArticleMood());
        $enewsclass = $this->getArticleClass();
        $this->attributes['classname'] = $enewsclass->classname;
        $this->attributes['usermood'] = $this->getUserMood();
    }

    protected function asynLoad2(){
        $this->attributes['titlepicbase64'] = $this->getTitlePicBase64();
    }

    protected function getArticleData()
    {
        $cacheId = 'article-data-'.$this->id;
        return Cache::remember($cacheId, CACHE_TIME, function(){
            $result = [];
            if($this->model){
                $sideTable = $this->dbPre.'ecms_article_data_'.$this->model->stb;
                $result = (array) DB::table($sideTable)->where('id', $this->id)->get()->toArray()[0];
                $result['newstext'] = stripslashes($result['newstext']);
            }
            return $result;
        });
    }

    public function getTextImageList(){
        $cacheId = 'article-text-image-list-'.$this->id;
        return Cache::remember($cacheId, LONG_CACHE_TIME, function(){
            $pattern = '/<img.+?src=([\'|\"])(.+?)\1/i';
            if(preg_match_all($pattern, stripslashes($this->originnewstext), $match)){
                return $match[2];
            }else{
                return [];
            }
        });
    }

    public function getArticleImageList(){
        $images = [];
        if($this->isgood >= 3){
            $imageList = $this->getTextImageList();
            foreach($imageList as $item){
                $list = explode('/', $item);
                if(isset($list[2]) && $list[2] == 'static.cwzg.cn'){
                    $images[] = $item;
                }

                if(count($images) >= 3){
                    break;
                }
            }
        }
        return $images;
    }

    public function getArticleMood(){
        $cacheId = 'article-mood-'.$this->id;
        $id = $this->id;
        return Cache::remember($cacheId, CACHE_TIME, function()use($id){
            $results = DB::table($this->dbPre.'ecmsextend_mood')->where('id', $id)->get();
            return [
                'mood1'=>$results->sum('mood1'),
                'mood2'=>$results->sum('mood2'),
                'mood3'=>$results->sum('mood3'),
                'mood4'=>$results->sum('mood4'),
                'mood5'=>$results->sum('mood5'),
                'mood6'=>$results->sum('mood6'),
                'mood7'=>$results->sum('mood7'),
                'mood8'=>$results->sum('mood8'),
                'mood9'=>$results->sum('mood9'),
                'mood10'=>$results->sum('mood10'),
                'mood11'=>$results->sum('mood11'),
                'mood12'=>$results->sum('mood12'),
            ];
        });
    }

    public function clearArticleMoodCache(){
        Cache::forget('article-mood-'.$this->id);
    }

    public function getArticleTags(){
        $cacheId = 'article-tag-id-'.$this->id;
        $tagIds = Cache::remember($cacheId, CACHE_TIME, function(){
            return DB::table($this->dbPre.'enewstagsdata')
                ->where('id',$this->id)
                ->select('tagid')
                ->distinct()
                ->get()
                ->keyBy('tagid')
                ->keys()
                ->toArray();
        });

        $tags = [];
        foreach($tagIds as $tagId){
            $tag = TagHelper::find($tagId);
            if($tag){
                $tags[$tagId] = $tag;
            }
        }
        return $tags;
    }

    public function getArticleClass(){
        return EnewsclassHelper::find($this->classid);
    }

    public function getArticleAuthors(){
        $authorNames = explode('$', $this->author);
        $authors = [];
        foreach($authorNames as $authorName){
            if($authorName){
                $author = AuthorSearch::instance()->where('title',$authorName)->first();
                if($author){
                    $authors[] = $author;
                }
            }
        }
        return $authors;
    }

    public function author(){
        $authors = $this->getArticleAuthors();
        return !empty($authors) ? $authors[0] : null;
    }

    public function authorRender(){
        $authorNames = explode('$', $this->author);
        $str = '';
        foreach($authorNames as $authorName){
            if($authorName){
                $author = AuthorSearch::instance()->where('title',$authorName)->first();
                if($author){
                    $str .= "<a class='author' href='{$author->url}' title='{$author->url}' target='_self'>{$author->title}</a>&nbsp;";
                }else{
                    $str .= "<span class='span-author'>{$authorName}</span>&nbsp;";
                }
            }
        }
        return substr($str, 0, -6);
    }

    //获取文章所属专题
    public function getArticleTopics(){
        $cacheId = 'article-topic-id-'.$this->id;
        $ztids = Cache::remember($cacheId, CACHE_TIME, function(){
            return DB::table($this->dbPre.'enewsztinfo')->where('id', $this->id)->select('ztid')->distinct()->get()->keyBy('ztid')->keys()->toArray();
        });

        $topics = [];
        foreach($ztids as $ztid){
            $topics[$ztid] = TopicHelper::getTopic($ztid);
        }

        return $topics;
    }

    public function getArticleTopic(){
        $topics = $this->getArticleTopics();
        return !empty($topics) ? $topics[0] : null;
    }

    public function getRelatedArticle($limit = 10){
        $search = ArticleSearch::instance();
        if($this->keyid){
            $ids = explode(',', $this->keyid);
            return $search->filter(['id in'=>$ids])->limit($limit)->orderBy('newstime desc')->get();
        }else{
            $tags = $this->getArticleTags();
            if(!empty($tags)){
                $ids = [];
                foreach($tags as $tag){
                    $ids =  array_merge($ids, $tag->getArticleIds());
                }
                return $search->filter(['id in'=>$ids])->limit($limit)->orderBy('newstime desc')->get();
            }else{
                return ArticleHelper::getRandomArticle($limit);
            }
        }
    }

    public function getUserMood(){
        $userMood = Cookie::has('usermood') ? (object) \GuzzleHttp\json_decode(Cookie::get('usermood')) : new \stdClass();
        return isset($userMood->{$this->id}) ? $userMood->{$this->id} : null;
    }

    public function getWeiboText(){
        return $text = trim('【'.$this->title.'】'.$this->titleurl.strip_tags($this->smalltext));
    }

    public function getTitlePicBase64(){
        $cacheId = 'article-titlepic-base64-'.$this->id;
        return Cache::remember($cacheId, LONG_CACHE_TIME, function(){
            if($this->titlepic){
                $image_info = getimagesize($this->titlepic);
                $image_data = @file_get_contents($this->titlepic);
                $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
                return $base64_image;
            }else{
                return null;
            }
        });
    }

    public function getNewstextImageUrl(){
        $cacheId = 'article-newstext-pic-'.$this->id;
        return Cache::remember($cacheId, LONG_CACHE_TIME, function(){
            $url = config('cwzg.mobileUrl').'/image/'.$this->id.'.html';
            $staticUri = config('cwzg.staticUrl');
            $result = null;
            if($staticUri){
                $auth = WeiboFactory::getWeiboAuth();
                $result = $auth->post($staticUri, ['url'=>$url]);
                if($result){
                    $result = \GuzzleHttp\json_decode($result);
                }
            }
            return $result ? $result->path : null;
        });

    }
}