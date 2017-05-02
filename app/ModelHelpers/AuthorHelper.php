<?php

namespace Share\ModelHelpers;

use Share\BusinessModels\Author;

use Cache;
use Share\Searches\AuthorSearch;

class AuthorHelper{
    private static $_instance = [];

    /**
     * @param $id
     * @return mixed
     */
    public static function find($id)
    {
        if( !isset(self::$_instance[$id]) ){
            $author =  new Author($id);
            if(!$author->isEmpty()){
                self::$_instance[$id] = $author;
            }
        }

        return isset(self::$_instance[$id]) ? self::$_instance[$id] : null;
    }

    public static function getAuthorColumnList($column = 'title'){
        $cacheId = 'author-name-list-'.$column;
        return Cache::remember($cacheId, LONG_CACHE_TIME, function()use($column){
            return array_column_list(AuthorSearch::instance()->get(), $column);
        });
    }
}