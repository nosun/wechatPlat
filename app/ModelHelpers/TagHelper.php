<?php

namespace Share\ModelHelpers;

use Share\BusinessModels\Tag;

class TagHelper{
    private static $_instance = [];

    public static function find($tagid){
        if(!isset(self::$_instance[$tagid])){
            $tag =  new Tag($tagid);
            if(!$tag->isEmpty()){
                self::$_instance[$tagid] = $tag;
            }
        }
        return isset(self::$_instance[$tagid]) ? self::$_instance[$tagid] : null;
    }
}