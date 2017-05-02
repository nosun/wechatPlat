@extends('layout.app')

@section('content')
        <div class="article-list">
            <form class="form-inline" name="search-form" role="form" action="" method="post">
                {{csrf_field()}}
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
                        {{--<th></th>--}}
                        <th>id</th>
                        <th>title</th>
                        <th>时间</th>
                        <th>点击</th>
                        <th>评论</th>
                        <th>操作</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($articles as $article)
                    <tr>
                        {{--<td><input type="checkbox" name="WbSelected[]" value="{{$article->id}}"></td>--}}
                        <td>{{$article->id}}</td>
                        <td><a href="{{$article->titleurl}}" target="_blank" title="{{$article->title}}">{{mb_substr($article->title, 0, 40)}}</a></td>
                        <td>{{date('Y-m-d H:m:s', $article->newstime)}}</td>
                        <td>{{$article->onclick}}</td>
                        <td>{{$article->plnum}}</td>
                        <td><a href="/e/extend/share/public/weibo/send/{{$article->id.$hash['whehref'] }}" target="main">选择推送</a></td>
                    </tr>
                    @endforeach
                    <tr>
                       <td colspan="7"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="bottom clearfix">
                    <div class="pull-left">{{$pagination->render()}}</div>
                    {{--<div class="pull-right" style="margin: 20px 0px"><button type="button" class="btn btn-primary">推送选中文章到微博</button></div>--}}
                </div>
            </form>
        </div>
@endsection
