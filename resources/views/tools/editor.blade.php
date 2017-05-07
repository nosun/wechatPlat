@extends('layout.app')

@section('content')
    <style>
        .content {
            width:800px;
        }
    </style>
    <div class="content container">
        <div class="main">
            <form class="form-horizontal">
                <div class="form-group">
                    <label for="content" class="col-lg-1 control-label">正文</label>
                    <div class="col-sm-10 col-lg-11">
                        <textarea class="textarea js-newstext" id="content" name="content" style="width: 100%;"></textarea>
                    </div>
                    <div class="error input-message col-lg-2 sp_content"></div>
                </div>
                <div class="form-group">
                    <label for="status" class="col-sm-2 col-lg-1 control-label">模板</label>
                    <div class="col-lg-4">
                        <select class="form-control select2 js-template" name="template" id="template">
                            <option value="tmp1">模板1</option>
                            <option value="tmp2">模板2</option>
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('user_js')
    <script type="text/javascript" charset="utf-8" src="/js/custom_editor_weichatstyle.js"></script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.config.js"></script>
    <script type="text/javascript" charset="utf-8" src="/ueditor/ueditor.all.js"></script>
        <script type="text/javascript">
        var ue = buildUEditor('content');

            function buildUEditor(id){
                return UE.getEditor(id, {
                    initialFrameHeight: 500, //编辑器高
                    scaleEnabled: true,
                    autoHeightEnabled: false,
                    maximumWords:1000000,
                    iframeCssUrl:'/css/custom_editor.css'
                });
            }
    </script>
@endsection