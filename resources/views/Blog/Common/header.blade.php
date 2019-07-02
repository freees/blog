<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <a class="fly-logo" href="{{url('/')}}">
            <img src="{{asset('images/blog/logo.png')}}">
        </a>
       {{-- <ul class="layui-nav fly-nav layui-hide-xs">
            <li class="layui-nav-item layui-this">
                <a href="/"><i class="iconfont icon-jiaoliu"></i>交流</a>
            </li>
            <li class="layui-nav-item">
                <a href="../case/case.html"><i class="iconfont icon-iconmingxinganli"></i>案例</a>
            </li>
            <li class="layui-nav-item">
                <a href="http://www.layui.com/" target="_blank"><i class="iconfont icon-ui"></i>框架</a>
            </li>
        </ul>--}}

        <ul class="layui-nav fly-nav-user">
            @if (!session('user_id'))
                <!-- 未登入的状态 -->
                    <li class="layui-nav-item">
                        <a class="iconfont icon-touxiang layui-hide-xs" href="{{'login'}}"></a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="{{url('login')}}">登入</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="{{url('register')}}">注册</a>
                    </li>
            @else
                    <li class="layui-nav-item">
                        <a class="fly-nav-avatar" href="javascript:void(0)" >
                            <cite class="layui-hide-xs">{{session('nick_name')}}</cite>
                            <i class="iconfont icon-renzheng layui-hide-xs" ></i>
                            <img src="{{session('face_img')}}">
                        </a>
                        <dl class="layui-nav-child" id="user_setting">
                            <dd><a href="{{route('user_home',['user_no'=>session('user_no')])}}"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
                            <dd><a href="{{url('check_email')}}"><i class="layui-icon">&#x1005;</i>邮箱激活</a></dd>
                            <dd><a href="{{url('my_article')}}"><i class="layui-icon">&#xe60a;</i>我的贴子</a></dd>
                            <dd><a href="{{url('set')}}"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                            <hr style="margin: 5px 0;">
                            <dd><a href="{{url('logout')}}" style="text-align: center;">退出</a></dd>
                        </dl>
                    </li>
        @endif
        </ul>
    </div>
</div>