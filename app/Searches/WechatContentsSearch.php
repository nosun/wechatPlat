<?php

namespace Share\Searches;

use Share\Models\WechatContent;
use Share\Models\WechatImage;
use Share\Models\WechatNews;
use Config;

class WechatContentsSearch extends Search{

    private static $_instance;
    protected $cache = false;

    public static function instance(){
        if(!self::$_instance){
            self::$_instance = new WechatContentsSearch('wx_contents', 'id', false);
        }else{
            self::$_instance->resetDb();
        }
        return self::$_instance;
    }

    public function get(){
        $ids =$this->getIds();
        $return = [];
        foreach($ids as $id){
            $news  = WechatContent::find($id);
            $thumb = WechatImage::where('media_id',$news->thumb_media_id)->first();
            if($thumb && !empty($thumb->path)){
                $news->thumb_url = Config::get('cwzg.imageUrl').'/'.$thumb->path;
            }
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
            return WechatContent::find($ids[0]);
        }else{
            return null;
        }
    }

    public function news(WechatNews $news){
        $this->attribute['news'] = $news->id;
        $this->db->where('media_id', $news->media_id)->orWhere('media_id',$news->id);
        return $this;
    }
}