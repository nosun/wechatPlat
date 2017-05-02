@extends('layout.app')

@section('content')
    <div class="weibo-form">
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

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title clearfix">
                    发送微博
                    <span class="pull-right"><a class="js-open-list-weibo" href="#">选择文章</a></span>
                </h3>
            </div>
            <div class="panel-body">
                <div class="form-body">
                    <form class="js-form-weibo" role="form" method="post" action="/e/extend/share/public/weibo/send{{ $hash['whehref'] }}" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input type="hidden" name="id" value="{{isset($article) && $article ? $article->id : 0}}">
                        <div class="form-group">
                            <textarea class="form-control js-form-content" rows="3" placeholder="请输入微博内容" name="content">{!! isset($post['content']) ? $post['content'] : (isset($article) &&  $article ? $article->getWeiboText() : '') !!}</textarea>
                            <p class="note js-note">还可以输入<span>140</span>个字符！</p>
                        </div>
                        <div class="clearfix">
                            @if(isset($article) && $article)
                                @if($article->getNewstextImageUrl())
                                    <div class="image-list pull-left">
                                        <label for="weibo-image1">
                                            <input type="radio" name="select-image" id="weibo-image1" value="newtext" checked>
                                            <img width="60" height="100" src="{{$article->getNewstextImageUrl()}}">
                                        </label>
                                        <p style="text-align: center"><a href="{{$article->getNewstextImageUrl()}}" target="_blank">查看</a></p>
                                    </div>
                                @endif
                                @if($article->titlepic)
                                    <div class="image-list pull-left">
                                        <label for="weibo-image2">
                                            <input type="radio" name="select-image" id="weibo-image2" value="titlepic">
                                            <img width="60" height="100" src="{{$article->titlepicbase64}}">
                                        </label>
                                        <p style="text-align: center"><a href="{{$article->titlepicbase64}}" target="_blank">查看</a></p>
                                    </div>
                                @endif
                            @else
                                <div class="form-group pull-left">
                                    <input class="file-img" type="file" name="upload-image" id="inputfile">
                                </div>
                            @endif
                            <div class="pull-right">
                                <button type="submit" class="btn btn-default">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('user_js')
<script>
    $(function(){

        String.prototype.weibolength = function(){
            var length = 0;
            var i = 0;
            for (; i < this.length; i++){
                if(/^[\x00-\xff]/.test(this[i])){
                    length += 0.5;
                }else{
                    length++;
                }
            }
            return Math.ceil(parseFloat(length));
        };



        var $weiboPage = $('.weibo-form');
        var $content = $('.js-form-content');
        var $span = $('.js-note span');

        $weiboPage.on('click', '.js-open-list-weibo', function(){
            window.open('/e/extend/share/public/weibo/list{{$hash['whehref']}}','','width=1000,height=800,scrollbars=yes,resizable=yes');
        });

        $weiboPage.on('keydown','.js-form-content',function(e){
            calculateContentNumber();
        });

        $weiboPage.on('keyup','.js-form-content',function(e){
            calculateContentNumber();
        });

        $weiboPage.on('submit', '.js-form-weibo', function(){
            if(calculateContentNumber()){
                return true;
            }else{
                alert('微博内容过长，请修改！');
                return false;
            }
        });

        calculateContentNumber();

        function calculateContentNumber(){
            var leftNumber = 140 - $content.val().weibolength();
            $span.html(leftNumber);
            if(leftNumber > 0){
                $content.removeClass('warning-border');
            }else{
                $content.addClass('warning-border');
            }
            return leftNumber > 0;
        }

    });

</script>

@endsection