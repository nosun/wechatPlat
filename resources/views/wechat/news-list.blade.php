@extends('layout.app')

@section('content')
{{--<a href="javascript:;" data-toggle="modal" data-target="#loadingModal" >loading modal box</a >--}}
<div class="p-wechat-news-list">
        <ul class="breadcrumb">
            <li><a href="/e/extend/share/public/wechat/newsList{{$hash['whehref']}}">素材列表</a></li>
            <li class="pull-right"><a href="{{url('/wechat/news').$hash['whehref']}}" >添加素材</a></li>
        </ul>

        @if(isset($error))
            <div class="alert alert-danger alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">
                    &times;
                </button>
                {!! $error !!}
            </div>
        @endif

        @if(isset($success))
            <div class="alert alert-success alert-dismissable">
                <button type="button" class="close" data-dismiss="alert"
                        aria-hidden="true">
                    &times;
                </button>
                {!! $success !!}
            </div>
        @endif
        <div class="row main-content">
            <div class="clearfix">
                @foreach($paginator->getIterator() as $news)
                    <?php $contents = $news->getContents() ?>
                    @if($contents)
                        <div class="news-list pull-left">
                            <h4 class="news-title">{{ substr($news->created_at,0,10)}}</h4>
                            <ul class="news-contents">
                                @foreach($contents as $key =>$conent)
                                    @if($key == 0)
                                        <li class="news first" >
                                            <a href="{{$conent->url or $conent->content_source_url}}" title="{{$conent->title}}" target="_blank">
                                                <img class="main-image" src="{{$conent->thumb_url}}" alt="{{$conent->title}}">
                                                <p class="main-title">{{$conent->title}}</p>
                                            </a>
                                        </li>
                                    @else
                                        <li class="clearfix news">
                                            <a href="{{$conent->url or $conent->content_source_url}}" title="{{$conent->title}}" target="_blank">
                                                <p class="pull-left side-title">{{$conent->title}}</p>
                                                <img class="side-image pull-right" src="{{$conent->thumb_url}}" alt="{{$conent->title}}">
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                            <div class="content-action">
                                <a href="{{url('/wechat/news/edit/'.$news->id.$hash['whehref'])}}" title="编辑">
                                    <span class="glyphicon glyphicon-edit"></span>
                                </a>
                                @if($news->media_id)
                                    <a class="remind" href="#" data-alarm="确定要更新？"
                                       data-url="{{url('/wechat/news/pushUpdate/'.$news->id.$hash['whehref'])}}" title="更新">
                                        <span class="glyphicon glyphicon-refresh"></span>
                                    </a>
                                @else
                                    <a class="remind" href="#" data-alarm="确定要推送？"
                                       data-url="{{url('/wechat/news/pushUpload/'.$news->id.$hash['whehref'])}}" title="推送">
                                        <span class="glyphicon glyphicon-send"></span>
                                    </a>
                                @endif
                                <a class="remind del" href="#" data-alarm="确定要删除?"
                                   data-url="{{url('/wechat/news/delete/'.$news->id.$hash['whehref'])}}" title="删除">
                                     <span class="glyphicon glyphicon-trash"></span>
                                </a>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
            {!! $paginator->render() !!}
        </div>
    </div>

    {{--modal loading--}}
    <div class="modal fade" id="loadingModal" data-backdrop="static"
         tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" style="margin-top: 10%;">
            <div class="modal-content">
                <div class="modal-body" style="text-align: center;">
                    <img src="/skin/cwzg/image/global/loading-01.gif" alt=""  style="margin-top: 30px;">
                    <p class="tips" style="text-align: center;margin-top: 30px;">
                        正在向微信服务器推送内容，请等待……
                    </p>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal -->
    {{--/modal loading end--}}


@endsection

@section('user_js')

    <script>
        $(".content-action").on('click', ".remind",function(){
            var message = $(this).data('alarm');
            if(confirm(message)){
                window.location.href=$(this).data('url');
                $('#loadingModal').modal('show');
            }
        });

        //Show modal
        //$('#loadingModal').modal('show');

        //Hide modal
        //$('#loadingModal').modal('hide');
    </script>

@endsection