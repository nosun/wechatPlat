<?php

namespace Share\Searches;

use Share\BusinessModels\Copyfrom;

class CopyfromSearch extends Search{

    private static $_instance;

    public static function instance(){
        if(!self::$_instance){
            self::$_instance = new CopyfromSearch('ecms_copyfrom', 'id');
        }else{
            self::$_instance->resetDb();
        }
        return self::$_instance;
    }

    public function get(){
        $ztids =$this->getIds();
        $return = [];
        foreach($ztids as $ztid){
            $topic = $this->find($ztid);
            if($topic){
                $return[] = $topic;
            }
        }
        return $return;
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

    public function find($id){
        return new Copyfrom($id);
    }
}