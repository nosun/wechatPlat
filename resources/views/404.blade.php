@extends('layout.cw')

@section('body-class')
    p-sites-nav
@endsection

@section('header')
    @include('parts.link-header')
@endsection

@section('user_css')
    <style>
        .not-found{
            margin: 150px 300px 200px;
        }

        .not-found-img{
            width: 207px;
            height:252px;
        }

        .not-found-p p{
            margin-left: 40px;
            font-family: 微软雅黑;
        }

        .not-found-p p:first-child{
            margin-top: 60px;
            margin-bottom: 30px;

            font-size: 24px;
            font-weight: bolder;
        }

        .not-found-p a{
            text-decoration: underline;
            color: #d76b54;
        }
    </style>
@endsection

@section('content')
    <div class="main-body">
        <div class="not-found clearfix">
            <div class="not-found-img pull-left"><img src="http://www.cwzg.cn/skin/cwzg/image/global/404.png" width="207" height="252"></div>
            <div class="not-found-p pull-left">
                <p>哎呀，你迷路了...</p>
                <p>别着急，点击 <a href="/">这里</a> 就可以找到出路</p>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    @include('parts.link-footer')
@endsection