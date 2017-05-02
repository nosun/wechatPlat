<?php

namespace Share\ModelHelpers;

use Share\BusinessModels\Enewsclass;

class EnewsclassHelper{

    private static $_instance = [];

    public static function find($classid){
        if( !isset(self::$_instance[$classid]) ){
            $enewsclass = new Enewsclass($classid);
            if(!$enewsclass->isEmpty()){
                self::$_instance[$classid] = $enewsclass;
            }
        }

        return isset(self::$_instance[$classid]) ? self::$_instance[$classid] : null;
    }

}