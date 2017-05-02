@extends('layout.app')

@section('content')
    <div class="content container">
        <div class="page-header">
            <h2>微信文章平台</h2>
        </div>
        <div class="search row" style="margin-bottom:20px;">
            <form class="form-inline" name="search-form" role="form" action="/articles" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <select class="form-control" name="origin">
                        <option value="-1" >原创选择</option>
                        <option value="原创" @if(isset($option['origin']) && $option['origin'] == "原创") selected @endif >原创</option>
                        <option value="非原创" @if(isset($option['origin']) && $option['origin'] == "非原创") selected @endif >非原创</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" name="idx">
                        <option value="-1" @if(isset($option['idx']) && $option['idx'] == "") selected @endif >顺序选择</option>
                        <option value="1" @if(isset($option['idx']) && $option['idx'] == "1") selected @endif >1</option>
                        <option value="2" @if(isset($option['idx']) && $option['idx'] == "2") selected @endif >2</option>
                        <option value="3" @if(isset($option['idx']) && $option['idx'] == "3") selected @endif >3</option>
                        <option value="4" @if(isset($option['idx']) && $option['idx'] == "4") selected @endif >4</option>
                        <option value="5" @if(isset($option['idx']) && $option['idx'] == "5") selected @endif >5</option>
                        <option value="6" @if(isset($option['idx']) && $option['idx'] == "6") selected @endif >6</option>
                    </select>
                </div>
                <div class="form-group">
                    <select class="form-control" name="key">
                        <option value="title" @if(isset($option['key']) && $option['key'] == "title") selected @endif>标题</option>
                        <option value="author" @if(isset($option['key']) && $option['key'] == "author") selected @endif>作者</option>
                    </select>
                </div>
                <div class="form-group" style="width: 30%">
                    <input type="text" class="form-control" name="keywords" id="title"
                           placeholder="关键字" value="{{isset($option['keywords']) ? $option['keywords'] :''}}" style="width:100%">
                </div>
                <button type="submit" class="btn btn-default">搜索</button>
            </form>
        </div>
        <div class="row">
            <table class="table table-bordered table-hover">
                <thead>
                <tr>
                    <th width="50%">标题</th>
                    <th width="10%">作者</th>
                    <th width="10%">时间</th>
                    <th width="10%">原创</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr>
                        <td>
                            <a href="{{url('/article/'.$article->id)}}" target="_blank">{{$article->title}}</a>
                        </td>
                        <td>
                            {{ $article->author }}
                        </td>
                        <td>
                            {{ $article->date }}
                        </td>
                        <td>
                            {{ $article->origin }}
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <div class="bottom row page">
            {{$page->render()}}
        </div>

        <div class="authors">
            @foreach($authors as $row)
                    {{ $row->author }},
            @endforeach
        </div>
    </div>

@endsection