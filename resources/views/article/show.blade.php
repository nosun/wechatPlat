@extends('layout.app')
@section('content')
    <style>
        .content:after {
            content:"."; display:block; height:0; visibility:hidden; clear:both;
        }
        .content .main {
            width: 700px;
            float:left;
        }
        p {
            font-size:16px;
            line-height:22px;
            height:22px;
        }
        .content .action{
            float:left;
            margin-left:30px;
        }
    </style>
    <div class="content">
        <div class="main">
            <h2>{{ $article->title }}</h2>
            <div class="info" style="margin:10px auto;height:30px;line-height:30px;">
                <div class="author col-lg-2">
                    <a href="/articles?key=author&keywords={{ $article->author }}&page=1"> {{ $article->author }} </a>
                </div>
                <div class="status col-lg-4" style="color:orangered">
                    {{ $article->status < 0 ? "已删除" : "正常" }} |
                    @if($article->used == 1)
                        待用
                    @elseif($article->used == -1)
                        已用
                    @else
                        未用
                    @endif
                </div>
            </div>
            <div id="content">{!! $article->content !!}</div>
        </div>
        <div class="action">
            <form class="form-inline">
                <select class="form-control" id="choose">
                    <option value="0" @if($article->used == "0") selected @endif>未用</option>
                    <option value="1" @if($article->used == "1") selected @endif>待用</option>
                    <option value="-1" @if($article->used == "-1") selected @endif>已用</option>
                </select>
                <button class="btn btn-danger" id="delete">
                    删除
                </button>
            </form>
        </div>
    </div>

@endsection

@section('user_js')
    <script>
        $(function(){
            var id= "{{ $article->id }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            function updateArticle(id,key,value){
                var arr ={};
                arr[key] = value;
                $.ajax({
                    url:"/article/" + id,
                    method: 'post',
                    data: arr,
                    success:function(res){
                        //console.log(res);
                        window.location.reload();
                    }
                })
            }

            $("#delete").on("click",function(){
                updateArticle(id,'status','-1');
            });

            $("#choose").on("change",function(){
                updateArticle(id,'used',$(this).val());
            });


        })
    </script>
@endsection