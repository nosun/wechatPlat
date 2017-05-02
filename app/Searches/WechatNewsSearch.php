<?php

namespace Share\Searches;

use Share\Models\WechatNews;

class WechatNewsSearch extends Search{

    private static $_instance;
    protected $cache = false;

    public static function instance(){
        if(!self::$_instance){
            self::$_instance = new WechatNewsSearch('wx_news', 'id', false);
        }else{
            self::$_instance->resetDb();
        }
        return self::$_instance;
    }

    public function get(){
        $ids =$this->getIds();
        $return = [];
        foreach($ids as $id){
            $news = WechatNews::find($id);
            if($news){
                $return[] = $news;
            }
        }
        return $return;
    }

    public function first(){
        $this->limit(1);
        $ids = $this->getIds();
        if(!empty($ids)){
            return WechatNews::find($ids[0]);
        }else{
            return null;
        }
    }

    public function getNewsByMediaId($media_id){
        return $this->db->where('id',$media_id)->orWhere('media_id',$media_id)->first();
    }
}