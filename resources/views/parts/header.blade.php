<header>
    <div class="header-top">
        <div class="inner clearfix">
            <div class="pull-left">
                <a href="{{$siteUrl}}" class="logo" ></a >
                <ul class="column-list">
                    <li>
                        <a href="{{$siteUrl}}/politics/"  target="_self">观风察俗</a>
                    </li><li>
                        <a href="{{$siteUrl}}/expose/"  target="_self">察言观行</a>
                    </li><li>
                        <a href="{{$siteUrl}}/theory/"  target="_self">洞幽察微</a>
                    </li><li>
                        <a href="{{$siteUrl}}/history/"  target="_self">察古知今</a>
                    </li>
                </ul>
            </div>
            <!--user-login-->
            <script src="{{$siteUrl}}/e/member/login/loginjs.php"></script>
        </div>
    </div>
    <div class="header-bottom">
        <div class="inner clearfix">
            <ul class="pull-left">
                <li>
                    <a href="{{$siteUrl}}/thinktank" target="_self">智库</a >
                </li>
                <li>
                    <a href="{{$siteUrl}}/opinion"  target="_self">时评</a >
                </li>
                <li>
                    <a href="{{$siteUrl}}/debate"  target="_self">争鸣</a >
                </li>
                <li>
                    <a href="{{$siteUrl}}/view"  target="_self" >深度</a >
                </li>
                <li>
                    <a href="{{$siteUrl}}/column"  target="_self">专栏</a >
                </li>
                <li>
                    <a href="{{$siteUrl}}/special.html"  target="_self">专题</a >
                </li>
            </ul>
            <div class="pull-right search-box">
                <form method="post" action="{{$siteUrl}}/e/search/index.php" >
                    <input type="text" name="keyboard" class="search-input" placeholder="请输入关键词" value="" >
                    <input name="classid" value="0" type="hidden">
                    <input type="submit" class="btn-search icon-sprites" value="" >
                    <div class="field">
                        <label for="field-all" >
                            <input type="radio" name="show" id="field-all" value="title,smalltext,newstext,author" checked>
                            全部
                        </label >
                        <label for="field-title" >
                            <input type="radio" name="show" value="title" id="field-title">
                            标题
                        </label >
                        <label for="field-brief" >
                            <input type="radio" name="show" value="smalltext" id="field-brief" >
                            简介
                        </label >
                        <label for="field-author" >
                            <input type="radio" name="show" value="author" id="field-author">
                            作者
                        </label >
                    </div>
                </form >
            </div>
        </div>
    </div>
</header>