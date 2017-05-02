<?php

namespace Share\Searches;

use Share\ModelHelpers\ArticleHelper;
use Share\BusinessModels\Topic;
use DB;
use Cache;

class ArticleSearch extends Search{

    private static $_instance;

    public static function instance(){
        if(!self::$_instance){
            self::$_instance = new ArticleSearch('ecms_article as a');
        }else{
            self::$_instance->resetDb();
        }
        return self::$_instance;
    }

    public function get(){
        $ids = $this->getIds();
        $return = [];
        foreach($ids as $id){
            $article = ArticleHelper::find($id);
            if($article){
                $return[] = $article;
            }
        }
        return $return;
    }

    public function getByMood($mood, $limit = 10){
        $cacheId = 'search-article-ids-by-moods-'.$mood.'-'.$limit;
        $ids = Cache::remember($cacheId, SHORT_CACHE_TIME, function()use($mood, $limit){
            $dbPre = config('cwzg.edbPrefix');
            return DB::table($dbPre.'ecmsextend_mood as m')
                ->join($dbPre.'ecms_article as a', 'a.id', '=', 'm.id')
                ->where('newstime', '>', strtotime('-2 day'))
                ->orderBy('m.'.$mood,'desc')
                ->orderBy('newstime', 'desc')
                ->limit($limit)
                ->select('a.id')
                ->get()
                ->keyBy('id')
                ->keys()
                ->toArray();
        });

        $return = [];
        foreach($ids as $id){
            $article = ArticleHelper::find($id);
            if($article){
                $return[] = $article;
            }
        }
        return $return;
    }

    public function first(){
        $this->limit(1);
        $ids = $this->getIds();
        if(!empty($ids)){
            return ArticleHelper::find($ids[0]);
        }else{
            return null;
        }
    }

    public function author($author){
        $this->attribute['author'] = $author;
        $this->db->where(function($query)use($author){
            $query->orWhere('author', $author)->orWhere('author', 'like', '%$'.$author.'%')->orWhere('author', 'like', '%'.$author.'$%');
        });
        return $this;
    }

    public function topic(Topic $topic){
        $this->filter(['id in'=>$topic->getArticleIds()]);
        return $this;
    }
}