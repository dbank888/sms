<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="keywords" content="sms" />
    <meta name="author" content="maple.xia" />

    <title> @yield('title')</title>


    <!-- Bootstrap core CSS -->
    {!! HTML::style('css/bootstrap.min.css') !!}
    @yield('load_css')

    @yield('customize_css')

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    {!! HTML::script('js/html5shiv.min.js') !!}
    {!! HTML::script('js/respond.min.js') !!}
    <![endif]-->
</head>

<body>

@yield('content')


@include('partials.js_basic')
@yield('load_js')

@yield('customize_js')

</body>
</html>

