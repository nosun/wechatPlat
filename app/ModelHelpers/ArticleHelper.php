<?php

namespace Share\ModelHelpers;

use Share\BusinessModels\Article;
use Share\BusinessModels\ArticleCheck;

use DB;
use Cache;

class ArticleHelper{
    private static $_instance = [];

    /**
     * @param $id
     */
    public static function find($id)
    {
        if( !isset(self::$_instance[$id]) ){
            $article = new Article($id);
            if(!$article->isEmpty()){
                self::$_instance[$id] = $article;
            }
        }

        return isset(self::$_instance[$id]) ? self::$_instance[$id] : null;
    }

    public static function findCheck($id){
        $key = 'check-'.$id;
        if( !isset(self::$_instance[$key]) ){
            $article = new ArticleCheck($id);
            if(!$article->isEmpty()){
                self::$_instance[$key] = $article;
            }
        }

        return isset(self::$_instance[$key]) ? self::$_instance[$key] : null;
    }

    public static function clearArticleCache($articleId){
        $article = 'article-model-'.$articleId;
        $articleData = 'article-data-'.$articleId;
        $articleMood = 'article-mood-'.$articleId;
        Cache::forget($article);
        Cache::forget($articleData);
        Cache::forget($articleMood);
    }

    public static function getRandomArticle($limit = 10){
        $cacheId = 'article-200-id';
        $ids = Cache::remember($cacheId, LONG_CACHE_TIME, function(){
            return DB::table(config('cwzg.edbPrefix').'ecms_article')
                ->orderByRaw('onclick desc, newstime desc')
                ->where('newstime', '>', strtotime('-2 week'))
                ->limit('200')
                ->select('id')
                ->get()
                ->keyBy('id')
                ->keys()
                ->toArray();
        });

        $idsKeys = array_rand($ids, $limit);

        $articles = array();
        foreach($idsKeys as $key){
            $articles[] = self::find($ids[$key]);
        }

        return $articles;
    }
}