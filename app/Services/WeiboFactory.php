<?php

namespace Share\Services;
use Illuminate\Support\Facades\Session;
use Share\Services\Weibo\WeiboAuth;
use Share\Services\Weibo\WeiboClient;
use Cache;

class WeiboFactory{
    private static $_instance = [];

    public static function getWeiboAuth(){
        if(!isset(self::$_instance['auth'])){
            self::$_instance['auth'] = new WeiboAuth(config('weibo.WB_AKEY'), config('weibo.WB_SKEY'));
        }
        return self::$_instance['auth'];
    }

    public static function getWeiboClient(){
        if(!isset(self::$_instance['client'])){
            if(Cache::has('weibo_access_token')){
                $token = Cache::get('weibo_access_token');
                self::$_instance['client'] = new WeiboClient(config('weibo.WB_AKEY'), config('weibo.WB_SKEY'), $token);
            }
        }
        return isset(self::$_instance['client']) ? self::$_instance['client'] : null;
    }
}