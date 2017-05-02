@extends('layout.app')

@section('user_css')

@endsection

@section('content')
   <!-- /.row -->
    <div class="row">
        <div class="box">
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">

                    {{--@foreach($list as $row)--}}
                     {{--{{ $row->media_id }}--}}
                    {{--@endforeach--}}
            </div>

            <a href="/e/extend/share/public/wechat/news<?=$hash['whehref']?>">增加素材</a>
            <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
@endsection

@section('user_js')

@endsection


