@extends('layout.app')

@section('content')
    <div class="wechat-article-list">
        <form class="form-inline" name="search-form" role="form" action="" method="post">
            {{csrf_field()}}
            <input class="js-media-id" name="media_id" type="hidden" value="">
            <div class="form-group">
                <input type="text" class="form-control" name="keywords" id="name" placeholder="关键字" value="{{isset($post['keywords']) ? $post['keywords'] :''}}">
                &nbsp;&nbsp;
            </div>
            <div class="form-group">
                <label for="name">字段</label>
                <select class="form-control" name="field">
                    <option value="title" {{!isset($post['field']) || $post['field'] == 'title' ? 'selected' : ''}} >标题</option>
                    <option value="author" {{isset($post['field']) && $post['field'] == 'author' ? 'selected' : ''}}>作者</option>
                    <option value="smalltext" {{isset($post['field']) && $post['field'] == 'smalltext' ? 'selected' : ''}}>简介</option>
                </select>
                &nbsp;&nbsp;
            </div>
            <button type="submit" class="btn btn-default">搜索</button>
        </form>
        <form name="push-form" role="form" action="" method="post">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th></th>
                    <th>id</th>
                    <th>title</th>
                    <th>时间</th>
                    <th>点击</th>
                    <th>评论</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($pagination->getIterator() as $article)
                    <tr>
                        <td><input class="js-wx-selected" type="checkbox" name="WxSelected[]" value="{{$article->id}}"></td>
                        <td>{{$article->id}}</td>
                        <td><a href="{{$article->titleurl}}" target="_blank" title="{{$article->title}}">{{mb_substr($article->title, 0, 40)}}</a></td>
                        <td>{{date('Y-m-d H:m:s', $article->newstime)}}</td>
                        <td>{{$article->onclick}}</td>
                        <td>{{$article->plnum}}</td>
                        <td><a class="js-article-select" data-id="{{$article->id}}" href="#">选择添加</a></td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="7"></td>
                </tr>
                </tbody>
            </table>
            <div class="bottom clearfix">
                <div class="pull-left">{{$pagination->render()}}</div>
                <div class="pull-right" style="margin: 20px 0px"><button type="button" class="btn btn-primary js-article-multi-select">选择添加素材</button></div>
            </div>
        </form>
    </div>
@endsection

@section('user_js')
    <script>
        $(function(){
            var $articleList = $('.wechat-article-list');

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            function ajaxGetContent(id){
                var callback = arguments[1] ? arguments[1] : null;
                var $this = $(this);

                var request = $.ajax({
                    url: '{{url('/wechat/ajax/article').$hash['whehref']}}',
                    method: 'post',
                    async: 'false',
                    dataType: 'json',
                    data: {
                        id : id
                    }
                });

                request.done(function (result) {
                    if(result.code == 200){
                        if(callback && typeof callback == 'function'){
                            callback(result.data);
                        }
                    }else{
                        console.error(result.data);
                    }
                });
            }

            function addArticle(id){
                ajaxGetContent(id, window.opener.newsEditJs.addArticle);
            }

            $articleList.on('click', '.js-article-select', function(e){
                e.preventDefault();
                addArticle($(this).data('id'));
            });

            $articleList.on('click', '.js-article-multi-select', function(e){
                $.each($('.js-wx-selected:checked'), function(index, element){
                    addArticle($(element).val());
                });
            });
        });
    </script>
@endsection
