<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" >
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title ></title >
    <link href="/lib/bootstrap-3.3.5/css/bootstrap.css" rel="stylesheet" type="text/css" />
    <link href="/css/app.css" rel="stylesheet" type="text/css" />
    @yield('user_css')
</head>
<body>
    @yield('content')
<script src="/lib/jquery/jquery-2.2.3.min.js"></script>
<script src="/lib/bootstrap-3.3.5/js/bootstrap.min.js"></script>

@yield('user_js')
</body>
</html>
