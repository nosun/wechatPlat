@extends('layout.app')

@section('user_css')
    <style>
        .un-save:after {
            content:" (未保存)";
            font-size:12px;
            font-weight:normal;
        }
    </style>
@endsection

@section('content')
    <div class="p-news-edit">
        <ul class="breadcrumb">
            <li><a href="/e/extend/share/public/wechat/newsList{{$hash['whehref']}}">素材</a></li>
            @if(isset($news) && $news->id)
                <li><a href="/e/extend/share/public/wechat/news/edit/{{ $news->id.$hash['whehref']}}">编辑素材</a></li>
            @else
                <li><a href="/e/extend/share/public/wechat/news{{$hash['whehref']}}">添加素材</a></li>
            @endif
            <li class="pull-right"><a href="#" class="js-wechat-article-list">选择文章</a></li>
        </ul>
        <div class="row">
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>
        <!-- /.row -->
        <div class="row main-content">
            <div class="main-left appmsg_preview_container">
                <div class="content-list">
                    <div class="appmsg_container_hd">
                        <h4 class="appmsg_container_title">图文列表</h4>
                    </div>
                    @if(!empty($contents))
                        @foreach($contents as $value)
                            <?php $article = $value->convertArticle(); ?>
                            <ul class="js-content-group" data-id="{{$article['fid']}}">
                                <li class="media-first {{!empty($content) && $article['id'] == $content->id ? 'on' : ''}}">
                                    <img src="{{$article['titlepic']}}" alt="{{$article['title']}}">
                                    <div class="title">
                                        <p>{{$article['title']}}</p>
                                    </div>
                                </li>
                                <li><div class="js-delete delete label label-danger">
                                        <span class="glyphicon glyphicon-trash"></span>&nbsp;删除</div>
                                </li>
                            </ul>
                        @endforeach
                    @endif
                    <div class="appmsg_container_bd hide">
                        <a onclick="return false;" title="添加一篇图文" class="create_access_primary appmsg_add" id="js_add_appmsg" href="javascript:void(0);">
                            <i class="icon35_common add_gray">增加一条</i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-md-8 main-right">
                <div class="js-danger alert alert-danger alert-dismissable hide">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-hidden="true">
                        &times;
                    </button>
                    <div class="danger-content"></div>
                </div>

                <div class="js-success alert alert-success alert-dismissable hide">
                    <button type="button" class="close" data-dismiss="alert"
                            aria-hidden="true">
                        &times;
                    </button>
                    <div class="success-content"></div>
                </div>

                <div class="content-box">
                    <form id="articleForm" class="form-horizontal"
                          action="{{url('/wechat/news/'.(isset($news) ? $news->id : '').$hash['whehref']) }}"
                          method="post"
                          enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="tab-content">
                            <div id="basic-info" class="active tab-pane">
                                @include('wechat.newsForm')
                            </div>
                        </div>
                        <div class="box-footer">
                            <button type="button" class="js-save btn btn-success">保存</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('user_js')
    <script type="text/javascript" charset="utf-8" src="/skin/cwzg/js/custom_editor_weichatstyle.js"></script>
    <script type="text/javascript" charset="utf-8" src="/e/extend/share/public/js/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/e/extend/ueditor/ueditor.all.js"></script>
    <script type="text/javascript" charset="utf-8" src="/e/extend/ueditor/ueditor.toolbarconfig.js"></script>
    <script type="text/javascript">
        $(function(){

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            window.newsEditJs = {
                form : {
                    title : $('.js-title'),
                    titleurl : $('.js-titleurl'),
                    author : $('.js-author'),
                    titlepicinput : $('.js-titlepic-input'),
                    titlepicimg : $('.js-titlepic-img'),
                    smalltext : $('.js-smalltext'),
                    newstext : $('.js-newstext'),
                    template : $('.js-template'),
                    note : $('.js-note'),
                    mediaId : $('.js-media-id')
                },

                contents : {!! !empty($articles) ?json_encode($articles) : '{}' !!},

                setContent : function(id, content){
                    window.newsEditJs.contents[id] = content;
                },

                getContent : function(id){
                    return window.newsEditJs.contents[id] ? window.newsEditJs.contents[id] : null;
                },

                contentExist : function(id){
                    return !!window.newsEditJs.contents[id];
                },

                resetSelectContent : function(){
                    var $on = $('.js-content-group .on');
                    if($on.length){
                        var id = $on.closest('.js-content-group').data('id');
                        var article = window.newsEditJs.getContent(id);
                        if(article){
                            article = $.extend(article, window.newsEditJs.getFormContent());
                            window.newsEditJs.setContent(id, article);
                        }
                    }
                },

                addArticle : function(article){
                    if($('.js-content-group').length <= 10){
                        //$danger.addClass('hide').find('.danger-content').empty();
                        article.type = 'article';
                        article.fid = 'article-'+article.id;

                        if(!window.newsEditJs.contentExist(article.fid)){
                            window.newsEditJs.resetForm(article,true);
                            window.newsEditJs.setContent(article.fid, article);

                            var $element = window.newsEditJs.createListArticleElement(article);
                            $('.media-first').removeClass('on');
                            $element.find('.media-first').addClass('on');
                            // init bind check length
                            cwjs.wechatEdit.init($(".check-length"));
                        }
                    }else{
                        //$danger.removeClass('hide').find('.danger-content').html('你添加的文章数量超过限制');
                    }

                },

                resetForm : function(){
                    var article = arguments[0] ? arguments[0] : null;
                    var keepUe = arguments[1] ? arguments[1] : false;
                    window.newsEditJs.form.title.val(article ? article.title : '');
                    window.newsEditJs.form.titleurl.val(article ? article.titleurl : '');
                    window.newsEditJs.form.author.val(article ? article.author : '');
                    window.newsEditJs.form.smalltext.val(article ? article.smalltext : '');
                    window.newsEditJs.form.note.val(article ? article.note : '');

                    //ue.setContent(article ? article.newstext : '');

                    $(".check-length").parents('.form-group').children('.input-message').html('');
                    if(article){
                        //销毁原UE实例，构建新UE实例
                        if(keepUe == false && ue.uid !== undefined){
                            ue.destroy();
                            window.newsEditJs.form.newstext.val(article.newstext);
                            ue = buildUEditor('content');
                        }else{
                            window.newsEditJs.form.newstext.val(article.newstext);
                            ue.setContent(article.newstext);
                        }

                        window.newsEditJs.form.titlepicinput.addClass('hide');
                        window.newsEditJs.form.titlepicimg.removeClass('hide');
                        window.newsEditJs.form.titlepicimg.attr('src', article.titlepic);
                    }else{
                        ue.setContent('');
                        window.newsEditJs.form.titlepicinput.removeClass('hide');
                        window.newsEditJs.form.titlepicimg.addClass('hide');
                    }
                },

                formCheck : function(){
                    var $form = $('#articleForm');

                    var lengthCheck = (function(){
                        var check = true;
                        $(".check-length").each(function(){
                            check = cwjs.wechatEdit.checkLength($(this));
                            return check;
                        });
                        return check;
                    });

                    if(lengthCheck() == false){
                        return false;
                    }

                    var checkInfo = $form.autoCheckForm({
                        articleTitle : 'required',
                        author : 'required',
                        from_url : 'required',
                        summary : 'required'
                    });

                    var input = window.newsEditJs.form;
                    if(!checkInfo.check()){
                        if(!input.titlepicinput.hasClass('hide') && !input.titlepicinput.val()){
                            $('.sp_image').html('Image is required');
                        }else{
                            $('.sp_image').html('');
                        }

                        if(!ue.getContent()){
                            $('.sp_content').html('Content is required');
                        }else{
                            $('.sp_content').html('');
                        }

                        return false;
                    }

                    if(!input.titlepicinput.hasClass('hide') && !input.titlepicinput.val()){
                        $('.sp_image').html('Image is required');
                        return false;
                    }else{
                        $('.sp_image').html('');
                    }

                    if(!ue.getContent()){
                        $('.sp_content').html('Content is required');
                        return false;
                    }else{
                        $('.sp_content').html('');
                    }

                    return true;

                },

                getFormContent : function () {
                    var input = window.newsEditJs.form;
                    return {
                        mediaId : input.mediaId.val(),
                        title : input.title.val(),
                        author : input.author.val(),
                        titleurl : input.titleurl.val(),
                        smalltext : input.smalltext.val(),
                        note : input.note.val(),
                        template : input.template.val(),
                        newstext : ue.getContent()
                    }
                },

                createListArticleElement : function(article){
                    var $add = $('#js_add_appmsg');
                    var content = '<ul class="js-content-group" data-id="'+article.fid+'">';
                    content += '<li class="media-first">';
                    content += ' <img src="'+article.titlepic+'" alt="'+article.title+'">';
                    content += '<div class="title">';
                    content += '<p>'+article.title+'</p>';
                    content += '</div>';
                    content += '</li>';
                    content += '<li>';
                    content += '<div class="js-delete delete label label-danger un-save">';
                    content += '<span class="glyphicon glyphicon-trash"></span>&nbsp;删除';
                    content += '</div>';
                    content += '</li>';
                    content += '</ul>';

                    var $element = $(content);
                    $add.closest('.appmsg_container_bd').before($element);
                    return $element;
                },

                ajaxArticleSave : function(article){
                    var callback = arguments[1] ? arguments[1] : null;
                    var request = $.ajax({
                        url: '{{url('/wechat/ajax/content/save'.$hash['whehref'])}}',
                        method: 'post',
                        async: 'false',
                        dataType: 'json',
                        data: {
                            article : article
                        }
                    });

                    request.done(function(result){
                        if(result.code == 200) {
                            var resultArticle = result.data.article;

                            if(article.type == 'article' && window.newsEditJs.contentExist(article.fid)){
                                window.newsEditJs.setContent(article.fid, undefined);
                            }

                            window.newsEditJs.setContent(resultArticle.fid, resultArticle);
                            window.newsEditJs.form.mediaId.val(resultArticle.media_id);
                            // console.log(resultArticle);
                            // ue.setContent(resultArticle.newstext);
                        } else {
                            console.error(result.data);
                        }

                        if(callback && typeof callback == 'function'){
                            callback(result);
                        }
                    });
                },

                save : function(){
                    var $element = arguments[0] ? arguments[0] : null;
                    var callback = arguments[1] ? arguments[1] : null;
                    var id = $element ? $element.data('id') : null;

                    var newsEditJs = window.newsEditJs;
                    var form = newsEditJs.form;

                    if(!newsEditJs.formCheck()){
                        alert('参数错误，请检查');
                        return false;
                    }

                    //$save.prop('disabled',  true);
                    var article = {type:'new'};
                    if(id && newsEditJs.contentExist(id)){
                        article = newsEditJs.getContent(id);
                    }

                    article = $.extend(article, newsEditJs.getFormContent());

                    var idx = 0;
                    if(article.type == 'new' && !$element){
                        idx = $('.js-content-group').length + 1;
                    }else{
                        $.each($('.js-content-group'), function(index, content){
                            var $content = $(content);
                            if($content.data('id') == article.fid){
                                idx++;
                                return false;
                            }
                            idx++;
                        });
                    }
                    article.idx = idx;

                    newsEditJs.ajaxArticleSave(article, function(result){
                        if(result.code == 200){
                            var resultArticle = result.data.article;
                            if(!$element){
                                $element = newsEditJs.createListArticleElement(resultArticle);
                            }

                            $element.data('id', resultArticle.fid);
                        }

                        if(callback && typeof callback == 'function'){
                            callback(result);
                        }
                    });

                    $(".check-length").each(function(){
                        cwjs.wechatEdit.checkLength($(this));
                    });

                },

                ajaxDeleteContent : function(id){
                    var callback = arguments[1] ? arguments[1] : null;
                    var request = $.ajax({
                        url: '{{url('/wechat/ajax/content/delete'.$hash['whehref'])}}',
                        method: 'post',
                        async: 'false',
                        dataType: 'json',
                        data: {
                            id : id
                        }
                    });

                    request.done(function(result){
                        if(result.code == 200){
                            if(callback && typeof callback == 'function'){
                                callback();
                            }
                        }else{
                            console.error(result.data);
                        }
                    });
                },

                deleteArticle : function ($element) {
                    var article = window.newsEditJs.getContent($element.data('id'));
                    if(article && article.type == 'content'){
                        var seg = article.fid.split('-');
                        if(seg[0] == 'content' && seg[1]){
                            window.newsEditJs.ajaxDeleteContent(seg[1], function(){});
                        }
                    }
                    $element.remove();
                    window.newsEditJs.setContent($element.data('id'),undefined);
                    // need up to top 1
                    window.newsEditJs.resetForm();

                }
            };

            //var $success = $('.js-success');
            //var $danger = $('.js-danger');
            //var $save = $('.js-save');

            var ue = buildUEditor('content');

            function buildUEditor(id){
                return UE.getEditor(id, {
                    toolbars: Wechat,
                    initialFrameHeight: 500, //编辑器高
                    scaleEnabled: true,
                    autoHeightEnabled: false,
                    maximumWords:1000000,
                    iframeCssUrl:'',
                    serverUrl: "/e/extend/ueditor/php/controller.php?isadmin=1"
                });
            }

            ue.ready(function () {});

            var $newsEdit = $('.p-news-edit');

            // 选择文章
            $newsEdit.on('click', '.js-wechat-article-list', function(){
                window.open('/e/extend/share/public/wechat/article/list{{$hash['whehref']}}','','width=1000,height=800,scrollbars=yes,resizable=yes');
            });

            // 切换文章
            $newsEdit.on('click', '.media-first', function(){
                //$success.addClass('hide').find('.success-content').empty();
                //$danger.addClass('hide').find('.danger-content').empty();
                // 设置文章内容
                window.newsEditJs.resetSelectContent();
                var id  = $(this).closest('.js-content-group').data('id');
                if(window.newsEditJs.contentExist(id)){
                    var article = window.newsEditJs.getContent(id);
                    window.newsEditJs.resetForm(article);
                }
                $('.media-first').removeClass('on');
                $(this).addClass('on');
                cwjs.wechatEdit.init($(".check-length"));
            });

            // 保存文章
            $newsEdit.on('click', '.js-save', function(){
                //$success.addClass('hide').find('.success-content').empty();
                //$danger.addClass('hide').find('.danger-content').empty();

                var $element = null;
                var $on = $('.js-content-group .on');
                if($on.length){
                    $element = $on.closest('.js-content-group');
                }

                $element.find('.js-delete').removeClass('un-save');

                window.newsEditJs.save($element, function(result){
                    //$save.prop('disabled',  false);
                    if(result.code == 200) {
                        //$success.removeClass('hide').find('.success-content').html('<p>文章保存成功！</p>');
                        alert("文章保存成功")
                    } else {
                        //$danger.removeClass('hide').find('.danger-content').html('<p>'+result.data+'</p>');
                        alert(result.data)
                    }
                });
            });

            // 删除文章
            $newsEdit.on('click', '.js-delete', function(e){
                if(confirm('你确定要删除么？')){
                    window.newsEditJs.deleteArticle($(this).closest('.js-content-group'));
                }
            });
        });
    </script>
@endsection
