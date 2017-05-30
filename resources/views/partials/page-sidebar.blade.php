<!-- sidebar -->
<div id="sidebar-nav">
    <ul id="dashboard-menu">
        <li class="nav-index">
            <a href="/index" target="mainFrame">
                <i class="glyphicon glyphicon-home"></i>
                <span>首页</span>
            </a>
        </li>
        <li>
            <a class="dropdown-toggle" href="">
                <i class="glyphicon glyphicon-magnet"></i>
                <span>保险公司</span>
            </a>
            <ul class="submenu">
                <li><a href="/company" target="mainFrame">信息列表</a></li>
                <li><a href="/company/create" target="mainFrame">添加记录</a></li>
            </ul>
        </li>
        <li>
            <a class="dropdown-toggle" href="">
                <i class="glyphicon glyphicon-leaf"></i>
                <span>服务商</span>
            </a>
            <ul class="submenu">
                <li><a href="/service" target="mainFrame" >信息列表</a></li>
                <li><a href="/service/create" target="mainFrame" >添加记录</a></li>
            </ul>
        </li>
        <li class="nav-personInfo">
            <a href="/smsList" target="mainFrame" >
                <i class="glyphicon glyphicon-envelope"></i>
                <span>短信记录</span>
            </a>
        </li>

        {{--<li class="nav-personInfo">
            <a href="/personInfo" target="mainFrame" >
                <i class="glyphicon glyphicon-info-sign"></i>
                <span>我的信息</span>
            </a>
        </li>--}}
        <li class="nav-calender">
            <a href="/calendar" target="mainFrame" >
                <i class="glyphicon glyphicon-calendar"></i>
                <span>日历</span>
            </a>
        </li>
    </ul>
</div>
<!-- end sidebar -->