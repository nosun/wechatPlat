<?php

namespace Share\Searches;

use Share\ModelHelpers\TopicHelper;

class TopicSearch extends Search{

    private static $_instance;

    public static function instance(){
        if(!self::$_instance){
            self::$_instance = new TopicSearch('enewszt', 'ztid');
        }else{
            self::$_instance->resetDb();
        }
        return self::$_instance;
    }

    public function get(){
        $ztids =$this->getIds();
        $return = [];
        foreach($ztids as $ztid){
            $topic = TopicHelper::find($ztid);
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
            return TopicHelper::find($ids[0]);
        }else{
            return null;
        }
    }
}