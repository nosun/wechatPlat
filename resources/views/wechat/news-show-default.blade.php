@extends('layout.simple')
@section('title')
   {{ $title }}
@endsection
@section('user_css')
    <link href="/e/extend/share/public/css/preview/default.css" rel="stylesheet" type="text/css">
@endsection

@section('content')
    <div class="container-fluid p-news-edit">
        <!-- /.row -->
        <div class="row main-content">
            <div class="content-view">
                <h2 class="title">
                    {{ $content->title }}
                </h2>
                <div class="info">
                    <span id="post-date" class="media_meta media_meta_text">{{ substr($content->created_at,0,10) }}</span>
                    <span class="media_meta media_meta_text">{{ $content->author }}</span>
                    <a class="media_meta link" href="{{$siteUrl}}" target="_blank">
                        察网
                    </a>
                </div>
                <div id="content">
                    <div class="content-top">
                        <div class="top-image">
                        <p style="text-align: justify; margin-bottom: 25px; line-height: 1.75em;">
                            <img data-src="http://mmbiz.qpic.cn/mmbiz_gif/SJJkaGcJ6nf97PsNN2PTSXgNoXMP7Lg6H9lpOGeXXOTEyaJAVQJ8O6j4yyzbG1aWLbjFIbhuv0ho46tAFeHItw/0?wx_fmt=gif" title="QQ图片20160812095547.gif" data-type="gif" data-ratio="0.16666666666666666" data-w="300" style="width: auto ! important; height: auto ! important; visibility: visible ! important;" src="http://mmbiz.qpic.cn/mmbiz_gif/SJJkaGcJ6nf97PsNN2PTSXgNoXMP7Lg6H9lpOGeXXOTEyaJAVQJ8O6j4yyzbG1aWLbjFIbhuv0ho46tAFeHItw/0?wx_fmt=gif&amp;wxfrom=5&amp;wx_lazy=1" class=" __bg_gif" data-order="0" data-fail="0"></p>
                        </div>
                        <p class="top-info">
                            提醒：最新版微信添加了公众号置顶功能，只要打开“察网”公众号并点击右上角图标，点击“置顶公共号”，就可以将察网置顶。这样，无论何时更新，您将更容易找到我们。
                        </p>
                    </div>
                    @if($content->note)
                        <div class="content-intro">
                            <section style="margin: 0.5em 1em 1em; border: 0px rgb(125, 16, 6); color: rgb(62, 62, 62); line-height: 25px; display: inline-block; box-sizing: border-box;">
                                <section style="line-height:2.5; margin-left: 1.5em;">
                                    <section style="color: rgb(125, 16, 6); display: inline-block; padding-right: 10px; padding-left: 10px; box-sizing: border-box; background-color: rgb(254, 254, 254);">
                                        <span style="font-size: 18px;">
                                            <strong>摘 要</strong>
                                        </span>
                                    </section>
                                </section>
                                <section style="padding: 22px 16px 16px; border: 1px dashed rgb(125, 16, 6); color: rgb(0, 0, 0); margin-top: -24px; box-sizing: border-box;">
                                    <p style="line-height: 2em; text-indent: 0em; white-space: normal;">
                                        <span style="font-size: 18px;">
                                            <span style="font-size: 18px; color: rgb(102, 102, 102);"></span>
                                            {{ $content->digest }}
                                        </span>
                                    </p>
                                </section>
                            </section>
                        </div>
                    @endif
                    <div class="content-main">

                       <?php echo $content->content; ?>
                    </div>
                    @if($content->copyright)
                        <div class="content-copyright">
                            <p>
                                {{ $content->copyright }}
                            </p>
                        </div>
                    @endif
                    <div class="content-footer">
                        <p class="dashang">
                            <img data-src="http://mmbiz.qpic.cn/mmbiz_jpg/SJJkaGcJ6ne35yQWiaYNBUY01UKPNDtIDshTHhtRticqZ7q8OkLZRJfeWSZEHHA6eTKBYfR2mbzRibEsxIuTRl2PA/0?wx_fmt=jpeg" data-ratio="0.625" data-w="800" src="http://mmbiz.qpic.cn/mmbiz_jpg/SJJkaGcJ6ne35yQWiaYNBUY01UKPNDtIDshTHhtRticqZ7q8OkLZRJfeWSZEHHA6eTKBYfR2mbzRibEsxIuTRl2PA/640?" data-fail="0">
                        </p>
                        <p class="guanzhu" style="position:relative">
                            <img src="http://mmbiz.qpic.cn/mmbiz/XHMKhhO5EjfFvYUXiciaxwjEzzYE0Bou3qA41ia4hE0c4ibAlicSquOQvK1QCQqhyMYppyPz2a8s1Mic0NQ5O1A5iaTAw/0" alt="">
                            <span>点击“阅读原文”，更多精彩尽在察网中国：www.cwzg.cn</span>
                        </p>
                    </div>
                </div>
                <div id="from">
                    <a class="media_meta link" href="{{ $content->content_source_url  }}" target="_blank">阅读原文</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('user_js')
@endsection
