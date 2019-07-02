@extends('Blog.Common.base')
@section('main')

<div class="fly-home fly-panel" style="background-image: url();">
  <img src="{{$userInfo->face_img}}" >
  <i class="iconfont icon-renzheng" title="Fly社区认证"></i>
  <h1>
    {{$userInfo->nick_name}}
    <i class="iconfont icon-nan"></i>
    <!-- <i class="iconfont icon-nv"></i>  -->
    <i class="layui-badge fly-badge-vip">VIP</i>
  </h1>
  <p class="fly-home-info">
    <i class="iconfont icon-shijian"></i><span>{{date('Y-m-d',$userInfo->create_time)}} 加入</span>
    <i class="iconfont icon-chengshi"></i><span>{{$userInfo->area}}</span>
  </p>

  <p class="fly-home-sign">{{$userInfo->signature}}</p>
  @if($userInfo->user_no != session('user_no'))
  <div class="fly-sns" data-user="">
    @if(!$friend)
    <a href="javascript:;" class="layui-btn layui-btn-primary fly-imActive" data-type="addFriend" id="add_friend">加为好友</a>
    @endif
    <a href="javascript:;" class="layui-btn layui-btn-normal fly-imActive" data-type="chat">发起会话</a>
  </div>
  @endif
</div>

<div class="layui-container">
  <div class="layui-row">
    <div class="layui-col-md6 fly-home-jie" style="margin: auto;width: 70%;float: none">
      <div class="fly-panel">
        <h3 class="fly-panel-title">{{$userInfo->nick_name}} 的发贴</h3>
        <ul class="jie-row">
          @if(!$article_list->isEmpty())
            @foreach($article_list as $v)
            <li>
              @if($v->is_fine)
                <span class="fly-jing">精</span>
              @endif
              @if($v->is_top)
                <span class="jie-status-ok">置顶</span>
              @endif
              <a href="{{route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])}}" class="jie-title">{{$v->title}}</a>
              <i>{{date('Y-m-d',$v->create_time)}}</i>
              <em class="layui-hide-xs">
                <i class="iconfont" title="人气">&#xe60b;</i> {{$v->page_views}}
                <i class="iconfont icon-pinglun1" title="评论"></i> {{$v->comment_num}}
              </em>
            </li>
            @endforeach
          @else
            <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表贴</i></div>
          @endif
        </ul>
      </div>
    </div>

  </div>
</div>
  <script>
    layui.use(['layer'], function(){
      var layer = layui.layer;
      $(document).on('click','#add_friend',function(){
        $.post('{{url('add_friend')}}',{'friend_id':{{$userInfo->user_id}},'friend_no':'{{$userInfo->user_no}}'},function (res) {
          var res = JSON.parse(res);
          if(res.code == '1'){
            layer.msg(res.msg, {icon: 1},function () {
              window.location.reload();
            });
          }else{
            layer.msg(res.msg, function () {
              // window.location.reload();
            });
          }
        })
      });
    });
  </script>
@endsection