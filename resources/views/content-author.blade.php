@extends('layout.cw')

@section('body-class')
    p-author-content
@endsection

@section('content')
    <div class="main-body clearfix">
        <div class="left-side pull-left">
            <h2 class="block-title">作者专栏</h2>
            <ul class="article-list-pic-text">
                <?php $articles  =  $pagination->getItems()?>
                @foreach($articles as $article)
                <li class="clearfix">
                    <img src="{{urlImg('226x127', $article->titlepic)}}" alt="{{$article->title}}" >
                    <div class="detail">
                        <a href="{{$article->titleurl}}" target="_blank" title="{{$article->title}}"><h3>{{$article->title}}</h3></a >
                        <p>{{strip_tags($article->smalltext)}}</p>
                        <div class="article-info">
                            {!! $article->authorRender() !!}
                            <span class="view-count"><i class="icon-sprites"></i>{{$article->onclick}}</span>
                            <span class="comment-count"><i class="icon-sprites"></i>{{$article->plnum}}</span>
                            <span class="date">{{date('Y-m-d', $article->newstime)}}</span>
                        </div>
                    </div>
                    <span class="tag-column">{{$article->classname}}</span>
                </li>
                @endforeach
            </ul>
            {!! $pagination->render() !!}

        </div>
        <div class="right-side pull-right">
            <div class="author-detail">
                <img src="{{urlImg('102x102', $author->titlepic)}}" alt="{{$author->title}}" class="avatar" >
                <h3 class="name">{{$author->title}}</h3>
                <p class="title">{{$author->ftitle}}</p>
                <p class="brief">{!! $author->smalltext !!}</p>
                <ul class="count-box clearfix">
                    <li>
                        <div>
                            <span>{{$author->articlenum}}</span>
                            <p></p>
                            <span>文章</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <span>{{$author->articlepraisenum}}</span>
                            <p></p>
                            <span>赞</span>
                        </div>
                    </li>
                    <li>
                        <div>
                            <span>{{$author->articleplnum}}</span>
                            <p></p>
                            <span>评论</span>
                        </div>
                    </li>
                </ul>
            </div>
            @if(!empty($hotArticles))
            <div class="author-hot-list">
                <h2 class="block-title">最热文章</h2>
                <ul>
                    @foreach($hotArticles as $hotArticle)
                    <li>
                        <a href="{{$hotArticle->titleurl}}" title="{{$hotArticle->title}}" >
                            <img src="{{urlImg('364x218', $hotArticle->titlepic)}}" alt="{{$hotArticle->title}}" >
                            <div class="title">
                                <div class="show-table">
                                    <h3 class="show-cell">{{$hotArticle->title}}</h3>
                                </div>
                            </div>
                        </a >
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(!empty($recommendArticles))
            <div class="author-hot-list">
                <h2 class="block-title">推荐文章</h2>
                <ul>
                    @foreach($recommendArticles as $recommendArticle)
                        <li>
                            <a href="{{$recommendArticle->titleurl}}" title="{{$recommendArticle->title}}" >
                                <img src="{{urlImg('364x218', $recommendArticle->titlepic)}}" alt="{{$recommendArticle->title}}" >
                                <div class="title">
                                    <div class="show-table">
                                        <h3 class="show-cell">{{$recommendArticle->title}}</h3>
                                    </div>
                                </div>
                            </a >
                        </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
@endsection