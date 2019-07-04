<div class="layui-col-md4">

  <div class="fly-panel">
    <h3 class="fly-panel-title">温馨通道</h3>
    <ul class="fly-panel-main fly-list-static">
            @foreach($aisle as $v)
            <li>
                <a @if(session('user_no')) href="{{$v->url}}" @else href="javascript:;" id="getAisle" @endif target="_blank">{{$v->title}}</a>
            </li>
        @endforeach
    </ul>
  </div>

  <div class="fly-panel fly-rank fly-rank-reply" id="">
    <h3 class="fly-panel-title">发贴榜</h3>
    <dl>
      @foreach($article_num as $v)
        <dd>
          <a href="{{route('user_home',['user_no'=>$v->user_no])}}">
            <img src="{{$v->face_img}}"><cite>{{$v->nick_name}}</cite><i>发帖{{$v->num}}次</i>
          </a>
        </dd>
      @endforeach
    </dl>
  </div>
{{--  <div class="fly-panel">
    <div class="fly-panel-title">
      广告 | <a href="#" class="fly-link">我要加入</a>
    </div>
    <div class="fly-panel-main">
        @foreach($ad as $v)
            <a href="{{$v->url}}" target="_blank" class="fly-zanzhu">{{$v->title}}</a>
        @endforeach
    </div>
  </div>--}}

  <dl class="fly-panel fly-list-one">
    <dt class="fly-panel-title">热议</dt>
      @foreach($hot_list as $v)
        <dd>
          <a href="{{route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])}}">{{$v->title}}</a>
          <span style="float: right"><i class="iconfont icon-pinglun1"></i> {{$v->comment_num}}</span>
        </dd>
      @endforeach
  </dl>

    <div class="fly-panel" style="padding: 20px 0; text-align: center;">
        <img src="{{asset('images/blog/wx_qrcode.jpg')}}" style="max-width: 100%;" alt="layui">
        <p style="position: relative; color: #666;">扫码关注Free社区订阅号</p>
    </div>

  <div class="fly-panel fly-link">
    <h3 class="fly-panel-title">友情链接</h3>
    <dl class="fly-panel-main">
        @foreach($link as $v)
            <dd><a href="{{$v->url}}" target="_blank">{{$v->title}}</a><dd>
        @endforeach
    </dl>
  </div>



</div>