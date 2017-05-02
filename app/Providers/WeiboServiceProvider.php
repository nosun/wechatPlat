<?php

namespace Share\Providers;

use Illuminate\Support\ServiceProvider;

use Share\Services\Weibo\WeiboAuth;
use Share\Services\Weibo\WeiboClient;
use Session;
use Cookie;

class WeiboServiceProvider extends ServiceProvider
{




    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('Share\Services\Weibo\WeiboAuth', function(){
            $auth = new WeiboAuth(config('weibo.WB_AKEY'), config('weibo.WB_SKEY'));
            if(!Session::has('weibo_access_token')){

            }
            return $auth;
        });

//        $this->app->singleton('Share\Services\Weibo\WeiboClient', function(){
//            $access_token = Session::has('weibo_access_token') ? Session::get('weibo_access_token') :
//                (Cookie::hasQueued('weibo_access_token') ? Cookie::getQueuedCookies() : null) ;
//            return new WeiboClient(config('weibo.WB_AKEY'),config('weibo.WB_SKEY'), $access_token);
//        });
    }
}
