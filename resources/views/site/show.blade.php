@extends('layout.app')

@section('content')
    <div class="content container">
        <div class="main">
            <h2>{{ $article->title }}</h2>
            <div class="info">{{ $article->author }}</div>
            <div id="content">{!! $article->content !!}</div>
        </div>
    </div>
@endsection