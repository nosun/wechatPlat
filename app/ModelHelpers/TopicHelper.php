<?php

namespace Share\ModelHelpers;

use Share\BusinessModels\Topic;

class TopicHelper{
    private static $_instance = [];

    public static function find($ztid){
        if(!isset(self::$_instance[$ztid])){
            $topic = new Topic($ztid);
            if(!$topic->isEmpty()){
                self::$_instance[$ztid] = $topic;
            }
        }
        return isset(self::$_instance[$ztid]) ? self::$_instance[$ztid] : null;
    }

}