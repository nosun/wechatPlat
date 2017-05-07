/**
 * Created by Administrator on 2017/3/20.
 */
    var WXStyle=window.WXStyle || {};
    var topImg="";
    var shangImg="";
    var footerImg="http://mmbiz.qpic.cn/mmbiz_jpg/SI09JGtVYJXN4pUOl1ibx9aH3mFJCFavcTrmp7oH5SVlFdxhEDmNcES7QrX7UiajplCLGHvkNMwt5JlUlYJCFIlg/640?tp=webp&wxfrom=5&wx_lazy=1";
    var fenImg="http://mmbiz.qpic.cn/mmbiz/yqVAqoZvDibFTSNXrNwtUCo9IGakPp6U2icyGkwNDzV2QbjCjXT0ZRPRTibxcFn2dtpou0qde2y2UaqtaXrOPlSfg/640?tp=webp&wxfrom=5&wx_lazy=1";
    var endImg="http://mmbiz.qpic.cn/mmbiz/icGtRGdCVnpyqSvGw7FRIaW7dLbH66eFjcn8o3UiblmTQnaAQg6DufyuCFwr78yLY4MCic0BNXdyz6O5biaIPJh0fA/640?tp=webp&wxfrom=5&wx_lazy=1";

    WXStyle.style1={
        fontFamily:'font-family:微软雅黑,黑体,宋体;',
        header:'<section style="margin: 10px 0px; padding: 0px; visibility: visible; height: 40px; line-height: 40px; ' +
                'border-radius: 4px; text-align: center; box-shadow: rgb(190, 190, 190) 0px 3px 5px; ' +
                'background: none 0% 0% repeat scroll rgb(238, 239, 239);">' +
                '<span style="font-size: 14px; color: rgb(110, 109, 109);">点击上方</span>' +
                '<span style="font-size: 14px; color: rgb(96, 127, 166);">&nbsp;“教而有方”&nbsp;</span>' +
                '<span style="font-size: 14px; color: rgb(110, 109, 109);">关注我们吧&nbsp; ^-^</span></section>',
        h1:'',
        h2:'font-size:24px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #ba261a;',
        h3:'font-size:22px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        h4:'font-size:20px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        h5:'font-size:18px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        h6:'font-size:18px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        p:'text-align:justify;margin-bottom:20px;line-height:2em;color:#2e2e2d;',
        img:'max-width:100%;margin-top:10px;margin-bottom:10px;',
        blockquote:'padding: 10px 20px;border-left:5px solid #eee;background-color:#f1f1f1;margin-bottom:0;line-height:2em;color: #2e2e2d;',
        footer:''
    };

    WXStyle.style1.header=WXStyle.style1.header +
        '<p style="color: rgb(136, 136, 136); font-size: 16px;font-weight: bold">这里是摘要</p>' +
        '<p style="text-align:center"><img src="'+ fenImg +'"></p>';

    WXStyle.style1.footer=
        '<p style="text-align: center"><img src="' + endImg + '"></p>' +
        '<p style="color: rgb(136, 136, 136); font-size: 14px;">来源：</p>' +
        '<p style="color: rgb(136, 136, 136); font-size: 14px;">作者：</p>' +
        '<p style="color: rgb(136, 136, 136); font-size: 14px;">编辑：</p>' +
        '<p style="text-align: center"><img src="' + fenImg + '"></p>' +
        '<p style="color: rgb(211, 169, 173);font-weight: bolder;text-align: center">如果觉得文章有价值</p>' +
        '<p style="color: rgb(211, 169, 173);font-weight: bolder;text-align: center">欢迎点赞、顺手转发到朋友圈哦~</p>' +
        '<p style="color: rgb(211, 169, 173);font-weight: bolder;text-align: center">如果您觉得本号有价值</p>' +
        '<p style="color: rgb(211, 169, 173);font-weight: bolder;text-align: center">欢迎推荐给身边有需要的朋友们~</p>' +
        '<p style="text-align: center"><img src="'+ footerImg +'"></p>' +
        '<p style="color: rgb(0, 82, 255);font-weight: bolder;font-size:18px;text-align: center">小编很用心，值得您订阅 ^-^</p>';

    /*WXStyle.style2={
        header:'<div style="font-size:30px;"><span>标题</span></div>',
        fontFamily:'黑体,"Microsoft YaHei",宋体;',
        h1:'',
        h2:'font-size:24px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        h3:'font-size:22px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        h4:'font-size:20px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        h5:'font-size:18px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        h6:'font-size:16px;margin:1.5em 0;font-weight:bolder;line-height:2em;color: #2e2e2d;',
        p:'font-family:"Microsoft YaHei",宋体 ;font-size:16px;margin-bottom:20px;line-height:2em;text-indent:2em;color: #2e2e2d;',
        img:'max-width:100%;margin-top:10px;margin-bottom:10px;',
        blockquote:'padding: 10px 20px;border-left:5px solid #eee;margin-bottom:0;font-size:16px;line-height:2em;text-indent:2em;color: #666;',
        footer:'<div style="font-size:10px;color:#900"><span>页脚</span></div>'
    };*/


/*config*/
WXStyle.selectedStyle=WXStyle.style1;