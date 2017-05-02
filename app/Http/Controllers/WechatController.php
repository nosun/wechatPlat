<?php

namespace Share\Http\Controllers;

use Illuminate\Http\Request;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Menu;
use EasyWechat\User;
use EasyWeChat\Message;
use Config;
use Log;

define('WC_MSG_1','test');

class WechatController extends Controller
{

    public function serve(Application $wechat)
    {
        Log::info('request arrived.');

        $server = $wechat->server;

        $server->setMessageHandler(function ($message) {
            switch ($message->MsgType) {
                case 'event':
                    switch($message->Event){
                        case 'subscribe': // 订阅
                            return "欢迎关注察网中国！察网将用犀利的目光，与您一起观察社会百态。";
                            break;
                        case 'unsubscribe': // 取消订阅
                            return '';
                            break;
                        case 'CLICK': // 点击菜单事件
                            return 'click';
                            break;
                        case 'SCAN':  // 扫描二维码
                            return 'scan';
                            break;
                        case 'VIEW':  // 点击菜单链接跳转
                            return 'view';
                            break;
                        case 'LOCATION': // 上报地理位置
                            return 'location';
                            break;
                        default:
                            return '';
                            break;
                    }
                    break;
                case 'text':
                    return '';
                    break;
                case 'image':
                    return '';
                    break;
                case 'voice':
                    return '';
                    break;
                case 'video':
                    return '';
                    break;
                case 'location':
                    return '';
                    break;
                case 'link':
                    return '';
                    break;
                default:
                    return '';
                    break;
            }
        });

        Log::info('return response.');

        try {
            $result = $server->serve();// 请求微信服务器
        } catch (\Exception $e) {
            return '';
        }

        return $result;
    }

    public function setMenu(Application $wechat){

        $buttons = [
            [
                "type" => "view",
                "name" => "察网中国",
                "url"  => "http://m.cwzg.cn/"
            ],
            [
                "name"       => "精华推荐",
                "sub_button" => [
                    [
                        "type" => "view",
                        "name" => "雷洋案",
                        "url"  => "http://mp.weixin.qq.com/s?src=3&timestamp=1486709880&ver=1&signature=b8qp*Zwlm9*gDxdQSSfe4fAN-rUTTU9uCMip85qjt3UV*FnzAiFQAcG9ExGervdi6lLmGQszxVa5JV0L1xpziLMPRS6NmlI8lec6fEHk5e*xQddF*S2o1IbHThCQfB-mQ8Zvc*TiM34Pxj*k9YZA*bVNO-fOABJ2s2iPz1hczLM="
                    ],
                    [
                        "type" => "view",
                        "name" => "“傅莹讲话”",
                        "url"  => "http://mp.weixin.qq.com/s?src=3&timestamp=1486709719&ver=1&signature=b8qp*Zwlm9*gDxdQSSfe4fAN-rUTTU9uCMip85qjt3VQ8AQg0CoM4HmoIb61cMb1FqVpFdUSWWXj6bSfbiTkVWE4mUYFQbpnJhw2Uu4leyp*GoavFSTfYOXrFgytzOPJKXCHW*uB7zu3Pooviu*S8ixN*-nbGMuwZ8Qq4pDz8rE="
                    ],
                    [
                        "type" => "view",
                        "name" => "公知评析",
                        "url"  => "http://mp.weixin.qq.com/s?__biz=MzAxMjI4Mzg2OQ==&mid=2650247052&idx=1&sn=8e2d0d553cbe0559dcdba3ef970b7c2b&chksm=83b7153eb4c09c28c937ef5c759b098f21a515d18c5096dd69de7f5860b416343d24a9e53f05&scene=18#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "李开复评析",
                        "url"  => "http://mp.weixin.qq.com/s?__biz=MzAxMjI4Mzg2OQ==&mid=2650247087&idx=3&sn=52e4d91ce264f1710f1f6c0d2bae98ab&chksm=83b7151db4c09c0bfd25bd4fe6fffc7366a48163948b97ff8e9d2557d832ef4d35b584e97a4b&scene=18#wechat_redirect"
                    ],
                    [
                        "type" => "view",
                        "name" => "高铁",
                        "url"  => "http://mp.weixin.qq.com/s?src=3&timestamp=1486709269&ver=1&signature=b8qp*Zwlm9*gDxdQSSfe4fAN-rUTTU9uCMip85qjt3VgPdGOoO32irTSwltMRUFpfnVeMoq*FZ8-bH-8uTtv0cKqkrNW0hG36z2xqA-0Zza3FObx-pokpmjaGoHgU71tzZ4crs2WFrIi8tc8qouCsdH7Nn9iIZWioDziZWvJ*jk="
                    ]
                ],
            ],
            [
                "type" => "view",
                "name" => "打赏",
                "url"  => "http://mp.weixin.qq.com/s?__biz=MzAxMjI4Mzg2OQ==&mid=502762919&idx=1&sn=4981e87e8e20e913c9459655cf4837bf&chksm=03b7171534c09e03e5f1942a87783e10d6f3b96d48f7d656fd7b25577ff6c31218ca0c045c38&scene=18#wechat_redirect"
            ]
        ];

        $menu = $wechat->menu;
        $menu->add($buttons);

    }

    public function getMenu(Application $wechat)
    {
        $menu = $wechat->menu;
        $menus = $menu->all();
        dd($menus);
    }

}
