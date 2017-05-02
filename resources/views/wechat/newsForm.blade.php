<input class="js-media-id" type="hidden" name="mediaId" value="{{ isset($news) && $news ? $news->media_id : '0'}}">
<div class="box-body">
    <div class="form-group">
        <label for="articleTitle" class="col-sm-2 col-lg-1 control-label">标题</label>
        <div class="col-lg-8">
            <input type="text" class="form-control js-title check-length" data-length="60" name="articleTitle"
                   value="@if(isset($content)){{ $content->title }}@else{{ old('articleTitle') }}@endif"
                   placeholder="标题">
        </div>
        <div class="error input-message col-lg-3 sp_articleTitle"></div>
    </div>
    <div class="form-group">
        <label for="image" class="col-sm-2 col-lg-1 control-label">封面</label>
        <div class="col-lg-8 thumb">
                <img class="js-titlepic-img {{empty($content) ? 'hide' : ''}}" src="{{!empty($content) ? $content->thumb_url : '#'}}" width="359" height="200" />
            <input type="text" class="form-control js-titlepic-input hide" id="thumb_url" name="thumb_url" placeholder="图片的url">
        </div>
        <div class="error input-message col-lg-3 sp_image"></div>
    </div>
    <div class="form-group">
        <label for="status" class="col-sm-2 col-lg-1 control-label">作者</label>
        <div class="col-lg-8">
            <input type="text" class="form-control js-author" id="author" name="author"
                   value="@if(isset($content)){{ $content->author }}@else{{ old('author') }}@endif"
                   placeholder="作者">
        </div>
        <div class="error input-message col-lg-3 sp_author"></div>
    </div>
    <div class="form-group">
        <label for="from_url" class="col-sm-2 col-lg-1 control-label">链接</label>
        <div class="col-lg-8">
            <input type="text" class="form-control js-titleurl" id="from_url" name="from_url"
                   value="@if(isset($content)){{ $content->content_source_url }}@else{{ old('from_url') }}@endif"
                   placeholder="来源链接">
        </div>
        <div class="error input-message col-lg-3 sp_from_url"></div>
    </div>
    <div class="form-group">
        <label for="summary" class="col-lg-1 control-label">微信摘要</label>
        <div class="col-sm-10 col-lg-11">
            <textarea class="textarea js-smalltext check-length" data-length="120" id="summary" name="summary" placeholder="微信摘要(纯文本)"
                      style="width: 100%; height: 140px; font-size: 14px;
                      line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
            >@if(isset($content)){{ $content->digest }}@else{{ old('summary') }}@endif</textarea>
        </div>
        <div class="error input-message sp_summary"></div>
    </div>
    <div class="form-group">
        <label for="note" class="col-lg-1 control-label">内容摘要</label>
        <div class="col-sm-10 col-lg-11">
            <textarea class="textarea js-note" id="note" name="note" placeholder="内容摘要(纯文本)"
                      style="width: 100%; height: 140px; font-size: 14px;
                      line-height: 18px; border: 1px solid #dddddd; padding: 10px;"
                    >@if(isset($content)){{ $content->note }}@else{{ old('note') }}@endif</textarea>
        </div>
        <div class="error input-message sp_note"></div>
    </div>
    <div class="form-group">
        <label for="content" class="col-lg-1 control-label">正文</label>
        <div class="col-sm-10 col-lg-11">
            <textarea class="textarea js-newstext" id="content" name="content"
                      style="width: 100%;">@if(isset($content)){{ $content->content }}@else{{ old('content') }}@endif</textarea>
        </div>
        <div class="error input-message col-lg-2 sp_content"></div>
    </div>
    <div class="form-group">
        <label for="editor" class="col-sm-2 col-lg-1 control-label">编辑</label>
        <div class="col-lg-4">
            <input type="text" class="form-control" id="editor" name="editor"
                   value="{{ 'editor' }}" readonly>
        </div>
    </div>
    <div class="form-group">
        <label for="status" class="col-sm-2 col-lg-1 control-label">模板</label>
        <div class="col-lg-4">
            <select class="form-control select2 js-template" name="template" id="template">
                @foreach($templates as $value)
                    <option value={{ $value }}
                    @if(isset($content) && $content->template == $value ) selected @endif>
                        {{ $value }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
