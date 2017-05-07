@extends('layout.app')

@section('content')
    <div class="content container">
        <div class="search row" style="margin-bottom:20px;">
            <form class="form-inline" name="search-form" role="form" action="/articles" method="post">
                {{csrf_field()}}
                <div class="form-group">
                    <select class="form-control" name="origin">
                        <option value="-1" >原创选择</option>
                        <option value="1" @if(isset($option['origin']) && $option['origin'] == "1") selected @endif >原创</option>
                        <option value="0" @if(isset($option['origin']) && $option['origin'] == "0") selected @endif >非原创</option>
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
                    <th width="50%">名称</th>
                    <th width="10%">类型</th>
                    <th width="10%">Logo</th>
                    <th width="10%">二维码</th>
                    <th width="10%">推荐级别</th>
                    <th width="10%">最后更新</th>
                </tr>
                </thead>
                <tbody>
                @foreach($sites as $site)
                    <tr>
                        <td>
                            <a href="{{url('/site/'.$site->id)}}" target="_blank">{{$site->name}}</a>
                        </td>
                        <td>
                            {{ $site->type == 1 ? "个人号" : "公司号" }}
                        </td>
                        <td>
                            {{ $site->logo }}
                        </td>
                        <td>
                            {{ $site->qrcode }}
                        </td>
                        <td>
                            {{ $site->elite }}
                        </td>
                        <td>
                           <a href="/articles?key=author&keywords={{ $site->name }}&page=1"> {{ empty($site->lastUpdated) ? "无" : $site->lastUpdated}} </a>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>
        </div>

        <div class="bottom row page">
            {{$page->render()}}
        </div>

    </div>

@endsection
