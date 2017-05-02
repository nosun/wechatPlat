<footer>
    <div class="footer-top" >
        <div class="inner clearfix" >
            <div class="sites-count pull-left">
                <h3><i class="icon-sprites"></i>已收录网站</h3>
                <p class="count" ><span >{{$linkCount}}</span >个</p >
                <p class="update-time"><i class="icon-sprites"></i>更新时间：{{date('Y-m-d', $updatetime)}}</p>
            </div>
            <div class="articles-list new pull-left">
                <h3><i class="icon-sprites"></i>最新文章</h3>
                <ul>
                    @foreach($newArticles as $article)
                    <li><a href="{{$article->titleurl}}" target="_blank" title="{{$article->title}}" ><span class="dot">&bull;</span>{{$article->title}}</a ></li>
                    @endforeach
                </ul>
                <div class="line-v"></div>
            </div>
            <div class="articles-list hot pull-left">
                <h3><i class="icon-sprites"></i>热门文章</h3>
                <ul>
                    @foreach($hotArticle as $article)
                    <li><a href="{{$article->titleurl}}" target="_blank" title="{{$article->title}}" ><span class="dot">&bull;</span>{{$article->title}}</a ></li>
                    @endforeach
                </ul>
                <div class="line-v"></div>
            </div>
            <div class="weixin-box pull-left">
                <img src="{{$siteUrl}}/skin/cwzg/image/global/img_weixin.jpg" alt="察网微信二维码" >
            </div>
            <div class="us-info-box pull-right">
                <ul>
                    @foreach($serviceLink as $title => $link)
                        <li><a href="{{$link}}" title="{{$title}}" target="_blank" >{{$title}}</a ></li>
                    @endforeach
                </ul>
            </div>
        </div >
    </div >
    <div class="footer-bottom">
        <div class="inner clearfix">
            <ul class="pull-left icp">
                <li>
                    <span>{{$copyright}}</span>
                </li>
                <li>
                    <span> ICP备案号：</span><a>琼ICP备14000134号</a>
                </li>
                <li>
                    <span>网络文化经营许可证：琼网文[2016]2834-020号</span>
                </li>
                <li>
                    <span>增值电信业务经营许可证：琼B2-20160037</span>
                </li>
                <li>
                    <span>广播电视节目制作经营许可证：（琼）字00167号</span>
                </li>
            </ul>
            <ul class="pull-right follow-us">
                <li>
                      <span style="display:none">
                        <script type="text/javascript">
                            var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
                            document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3F2cd2b7e7f3e72897e329f2cf72972ed9' type='text/javascript'%3E%3C/script%3E"));
                        </script>
		       <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1256518695'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s4.cnzz.com/z_stat.php%3Fid%3D1256518695%26show%3Dpic1' type='text/javascript'%3E%3C/script%3E"));</script>
                      </span>
                </li>
                <li class="weibo">
                    <a href="http://weibo.com/p/1006065041898236" target="_blank" ><i class="icon-sprites"></i></a >
                </li>
                <li class="qq">
                    <a href="http://wpa.qq.com/msgrd?v=3&uin=3300977562&site=qq&menu=yes" target="_bllank" ><i class="icon-sprites"></i></a >
                </li>
            </ul>
        </div>
    </div>
</footer>