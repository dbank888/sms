<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- 上述3个meta标签*必须*放在最前面，任何其他内容都*必须*跟随其后！ -->
    <meta name="keywords" content="sms" />
    <meta name="author" content="maple.xia" />

    <title>首页</title>

    @include('partials.css_basic')

    {{--page--}}
    {!! HTML::style('css/index/layout.css') !!}
    {!! HTML::style('css/index/elements.css') !!}
    {!! HTML::style('css/index/page.css') !!}
</head>
<body>

@include('partials.page-nav')

@include('partials.page-sidebar')
<!-- main container -->
<div class="content">
    <!-- settings changer -->
    @include('partials.changeTheme')

    <div style="margin:0; padding:2px; overflow:hidden;">
        <iframe id="iframeMain" name="mainFrame" style="width:100%;" frameborder="0" src="/home" ></iframe>
    </div>
</div>

@include('partials.page-footer')

@include('partials.js_basic')

<script type="text/javascript">
    var min_height = 600;
    function resetFrame(){
        var iframe = document.getElementById("iframeMain");
        try{
            var bHeight = iframe.contentWindow.document.body.scrollHeight;
            var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
            var height = Math.min(bHeight, dHeight);
            iframe.height = height > min_height ? height : min_height;
        }catch (ex){}
    }

    var timer = window.setInterval("resetFrame()", 300); //定时开始

    function reinitIframeEND(){
        var iframe = document.getElementById("iframeMain");
        try{
            var bHeight = iframe.contentWindow.document.body.scrollHeight;
            var dHeight = iframe.contentWindow.document.documentElement.scrollHeight;
            var height = Math.min(bHeight, dHeight);
            iframe.height = height > min_height ? height : min_height;
        }catch (ex){}

        // 停止定时
        window.clearInterval(timer);
    }

    $(function(){
        resetFrame();

        $('#nav_person_info').click(function(){
            var  bind= $(".nav-personInfo");
            bind.trigger("click");
            window.open(bind.find("a").attr('href'),'mainFrame');
        })

        $('body').css('background-color', '#f7f7f7');
        $("#dark_theme").click(function(){
            $('body').css('background', 'none');
        })


        var perpend_html = '<div class="pointer"> <div class="arrow"></div> <div class="arrow_border"></div> </div>';
        $('#dashboard-menu li').eq(0).addClass('active').prepend(perpend_html);

        $('#dashboard-menu li ').click(function(){
            $('#dashboard-menu li').removeClass('active');
            $('#dashboard-menu .pointer').remove();
            $(this).addClass('active').prepend(perpend_html);
        })
    })

</script>

</body>
</html>