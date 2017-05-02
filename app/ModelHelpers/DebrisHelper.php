<?php

namespace Share\ModelHelpers;

use Share\BusinessModels\Debris;

class DebrisHelper{
    private static $_instance = [];

    public static function find($spid){
        if(!isset(self::$_instance[$spid])){
            $debris = new Debris($spid);
            if(!$debris->isEmpty()){
                self::$_instance[$spid] = $debris;
            }
        }
        return isset(self::$_instance[$spid]) ? self::$_instance[$spid] : null;
    }
}