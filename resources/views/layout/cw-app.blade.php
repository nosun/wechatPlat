<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>{{$title or $title_common}}</title>
    <meta name="keywords" content="{{$keywords or $keywords_common}}" />
    <meta name="description" content="{{$description or $description_common}}" />
    <meta property="wb:webmaster" content="40d0f3f4c37ae647" />
    <link rel="stylesheet" href="{{$siteUrl}}/skin/lib/bootstrap-3.3.5/css/bootstrap.min.css" />
    <link rel="stylesheet" href="{{$siteUrl}}//skin/cwzg/css/main.css" />
    @yield('user_css')
</head>
<body class="@yield('body-class')" >
@yield('header')

@yield('modal')

@yield('content')

@yield('footer')
<script src="{{$siteUrl}}/skin/lib/jquery/jquery-1.12.3/jquery-1.12.3.min.js" ></script >
<script src="{{$siteUrl}}//skin/lib/bootstrap-3.3.5/js/bootstrap.min.js" ></script >
<script src="{{$siteUrl}}//skin/cwzg/js/main.min.js" ></script >
@yield('user_js')
</body >
</html >

