<header>
    <div class="header-top clearfix">
        <div class="inner">
            <div class="logo-box pull-left">
                <a href="/"><h1 class="icon-sprites logo-img">察网网址导航</h1></a>
            </div>
            <div class="search-box pull-left">
                <form class="js-search-from" action="/e/search/index.php" method="post">
                    <div class="form-group">
                        <input type="text" name="keyboard" class="form-control ipt-words js-keyboard" placeholder="请输入关键字" >
                        <input type="button" class="btn btn-default btn-baidu-search js-search-baidu" value="百度一下" >
                        <input type="submit" class="btn btn-default" value="站内搜索" >
                        <input type="hidden" name="classid" value="0" >
                        <input type="hidden" name="show" value="title,smalltext,newstext,author">
                    </div>
                </form >
            </div>
            <div class="tools pull-right">
                <a href="{{$siteUrl}}" class="link-home" >
                    <i class="icon-sprites"></i>
                    察网首页
                </a >
                <a href="" class="link-join" data-toggle="modal" data-target="#joinModal" >
                    <i class="icon-sprites"></i>
                    申请收录
                </a >
                <a href="" class="link-ctrl-d" >
                    <i class="icon-sprites"></i>
                    按Ctrl+D收藏导航
                </a >
            </div>
        </div>
    </div>
    <div class="header-bottom clearfix">
        <div class="inner">
            <ul>
                @foreach($linkNav as $item)
                    <li><a href="{{$item->url}}" >{{$item->tname}}</a ></li>
                @endforeach
            </ul>
        </div>
    </div>
</header>

<div class="modal fade" id="joinModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">申请收录</h4>
            </div>
            <form class="js-join-from" method="post" action="{{url('/copyfrom/save')}}">
                {{csrf_field()}}
                <div class="modal-body clearfix">
                    <div class="form-group">
                        <label for="slt-category" class="col-sm-2 control-label">分类</label>
                        <div class="col-sm-10">
                            <select name="ttid" class="js-ttid-select form-control" id="slt-category">
                                @foreach($infotypes as $infotype)
                                    <option value="{{$infotype->typeid}}" >{{$infotype->tname}}</option >
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ipt-site-name" class="col-sm-2 control-label">名称</label>
                        <div class="col-sm-10">
                            <input type="text" name="title" class="form-control js-title-input" id="ipt-site-name" placeholder="请输入链接名称">
                        </div>
                    </div>
                    <div class="form-group js-titleurl">
                        <label for="ipt-url" class="col-sm-2 control-label">网址</label>
                        <div class="col-sm-10">
                            <input type="text" name="titleurl" class="form-control" id="ipt-url" placeholder="http://">
                            <p class="error-message js-titleurl-massage"></p>
                        </div>
                    </div>
                    <div class="form-group js-publicno hide">
                        <label for="ipt-url" class="col-sm-2 control-label">公众号</label>
                        <div class="col-sm-10">
                            <input type="text" name="publicno" class="form-control" id="ipt-url" placeholder="请输入网址">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="ipt-brief" class="col-sm-2 control-label">简介</label>
                        <div class="col-sm-10">
                            <textarea class="form-control js-smalltext-input" name="smalltext" id="ipt-brief" placeholder="简介，200字以内"></textarea>
                        </div>
                    </div>
                    <div class="form-group js-titlepic">
                        <label for="ipt-icon-url" class="col-sm-2 control-label">图标</label>
                        <div class="col-sm-10">
                            <input type="text" name="titlepic" class="form-control" id="ipt-icon-url" placeholder="http://">
                            <p class="help-block">请提供自定义图标链接地址（选填）</p>
                            <p class="error-message js-titlepic-massage"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">提交</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal -->
</div>