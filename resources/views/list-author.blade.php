@extends('layout.cw')

@section('content')
    <ul>
        @foreach($authors as $author)
            <li><a href="{{url('/column/'.$author->filename.'/index_1.html')}}" target="_blank">{{$author->title}}</a></li>
        @endforeach
    </ul>
@endsection