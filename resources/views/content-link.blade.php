@extends('layout.cw')

@section('body-class')
    p-sites-nav
@endsection

@section('header')
    @include('parts.link-header')
@endsection

@section('content')
    <div class="main-body">
        @if(\Session::has('success'))
            <div class="alert alert-success alert-dismissable" style="margin-top: 20px">
                <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">
                    &times;
                </button>
                {{\Session::get('success')}}
            </div>
        @endif
        <div class="category-box {{$infotype->class}}">
            <h2>
                <i class="icon-sprites"></i>
                <span>{{$infotype->tname}}</span>
                <a href="{{$infotype->url}}" class="more pull-right">更多&gt;&gt;</a>
            </h2>
            <ul class="url-list">
                @foreach($infotype->copyfroms as $copyfrom)
                    <li>
                        <a class="title clearfix" href="{{$copyfrom->titleurl}}" title="{{$copyfrom->title}}"
                           target="_blank">
                            @if($copyfrom->titlepic)
                                <div class="img-box pull-left">
                                    <img src="{{$copyfrom->titlepic}}" alt="{{$copyfrom->title}}">
                                </div>
                            @endif
                            <h3 class="pull-left">{{$copyfrom->title}}</h3>
                            @if($copyfrom->ishot)
                                <span class="hot pull-right">
                                <i class="icon-sprites"></i>
                            </span>
                            @endif
                        </a>

                        <p class="brief">
                            {{$copyfrom->smalltext}}
                        </p>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection

@section('footer')
    @include('parts.link-footer')
@endsection