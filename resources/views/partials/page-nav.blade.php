{{--
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">SMS</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li><a href="/">首页</a></li>
                <li id="nav-company"><a href="/company">保险公司</a></li>
                <li id="nav-service"><a href="/service">服务商</a></li>
                <li id="nav-smsList"><a href="/smsList">短信分发记录</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="javascript:history.back()">返回</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>--}}

<!-- navbar -->
<header class="navbar navbar-inverse" role="banner">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">SMS</a>
    </div>
    <ul class="nav navbar-nav pull-right hidden-xs">
        <li class="hidden-xs hidden-sm">
            <input class="search" type="text" />
        </li>
        <li class="notification-dropdown hidden-xs hidden-sm">
        <li class="settings hidden-xs hidden-sm">

            <a id="nav_person_info" role="button" data-title="短信分发记录">
                <span style="font-size: 16px;margin: 2px 15px 0 0;float: left;">{{ Auth::user()->name }}</span>
                <i class="glyphicon glyphicon-cog" ></i>
            </a>
        </li>
        <li class="settings hidden-xs hidden-sm">
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();" role="button" data-title="退出">
                <i class="glyphicon glyphicon-share-alt" ></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
        </li>
    </ul>
</header>
<!-- end navbar -->
