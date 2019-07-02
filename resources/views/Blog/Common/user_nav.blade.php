<ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
    <li class="layui-nav-item">
        <a href="{{route('user_home',['user_no'=>session('user_no')])}}">
            <i class="layui-icon">&#xe612;</i>
            我的主页
        </a>
    </li>
    <li class="layui-nav-item  @if(Request::path() == 'check_email') layui-this @endif">
        <a href="{{url('check_email')}}">
            <i class="layui-icon">&#x1005;</i>
            邮箱激活
        </a>
    </li>
    <li class="layui-nav-item @if(Request::path() == 'my_article') layui-this @endif">
        <a href="{{url('my_article')}}">
            <i class="layui-icon">&#xe60a;</i>
            我的贴子
        </a>
    </li>
    <li class="layui-nav-item @if(Request::path() == 'set') layui-this @endif ">
        <a href="{{url('set')}}">
            <i class="layui-icon">&#xe620;</i>
            基本设置
        </a>
    </li>
    <li class="layui-nav-item @if(Request::path() == 'message') layui-nav-itemed @endif">
        <a href="javascript:;">
            <i class="layui-icon">&#xe611;</i>
            我的好友
        </a>
        <dl class="layui-nav-child">
            <dd><a href="{{route('message',['to_user'=>'all'])}}">群聊</a></dd>
            @foreach($friends as $v)
            <dd><a href="{{route('message',['to_user'=>$v->friend_no])}}">{{$v->nick_name}}</a></dd>
            @endforeach
        </dl>
    </li>
</ul>
