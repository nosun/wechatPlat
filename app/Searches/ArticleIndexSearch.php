<?php

namespace Share\Searches;

use Share\ModelHelpers\ArticleHelper;
use Cache;

class ArticleIndexSearch extends Search{

    private static $_instance;

    public static function instance(){
        if(!self::$_instance){
            self::$_instance = new ArticleIndexSearch('ecms_article_index');
        }else{
            self::$_instance->resetDb();
        }
        return self::$_instance;
    }

    public function get(){
        $ids = $this->getIds();
        $return = [];
        foreach($ids as $id){
            $article = $this->find($id);
            if($article){
                $return[] = $article;
            }
        }
        return $return;
    }


    public function getIds(){
        if($this->cache){
            $cacheId = 'search-get-ids-'.md5(json_encode($this->attribute));
            $ids = Cache::remember($cacheId, SHORT_CACHE_TIME, function(){
                return $this->db->select([$this->attribute['primaryKey'], 'checked'])->get();
            });
        }else{
            $ids = $this->db->select([$this->attribute['primaryKey'], 'checked'])->get();
        }
        $this->resetDb();
        return $ids;
    }

    public function getByIds($ids){
        $items = [];
        if(!empty($ids)){
            foreach($ids as $id){
                $item = $this->find($id);
                if($item){
                    $items[] = $item;
                }
            }
        }
        return $items;
    }

    public function first(){
        $this->limit(1);
        $ids = $this->getIds();
        if(!empty($ids)){
            return $this->find($ids[0]);
        }else{
            return null;
        }
    }

    public function find($index){
        if($index->checked){
            return ArticleHelper::find($index->id);
        }else{
            return ArticleHelper::findCheck($index->id);
        }
    }
}