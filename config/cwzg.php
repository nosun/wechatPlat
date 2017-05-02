<?php

return [
    'edbPrefix'=>'cwcms_',
    'pdbPrefix' => 'cw_',
    'imageUrl' => 'http://backend.cwzg.cn',
    'siteUrl' => 'http://www.cwzg.cn',
    'sitename' => '察网',
    'keywords' => '察网，新闻网站，民营，爱国网站，人物资料',
    'description' => '“察网中国”是由海南察网文化传媒有限公司运营的民间性质爱国网民网站。',
    'copyright' => 'Copyright &copy; '.date('Y').' 察网',
    'newsTextPageLength'=>2000,
    'mobileUrl'=>env('MOBILE_URL', 'http://m.cwzg.cn'),
    'staticUrl'=>env('STATIC_URL', null),
    'pageRow' => 15,
    'WxListPageRow' => 3,
    'serviceLink' => [
        '关于我们' => 'http://www.cwzg.cn/about/info.html',
        '联系方式' => 'http://www.cwzg.cn/about/contact.html',
        '版权信息' => 'http://www.cwzg.cn/about/copyright.html',
        '招聘信息' => 'http://www.cwzg.cn/about/job.html',
    ],
    'linkTypes' => [
        '推荐门户' => 'c-recommend',
        '省级媒体' => 'c-gov-media',
        '时事评论' => 'c-reviews',
        '知名论坛' => 'c-bbs',
        '军事网站' => 'c-military',
        '爱国网站' => 'c-patriotic',
        '各类思潮' => 'c-thinks',
        '个人微博' => 'c-weibo',
        '高级神器' => 'c-god-tools',
        '知名博客' => 'c-blog',
        '媒体公众号' => 'c-wechat-media',
        '个人公众号' => 'c-wechat-personal',
    ]
];
