@extends('Blog.Common.base')
@section('resources')
  <script src="{{asset('js/index.js')}}"></script>
@endsection
@section('main')

<div class="layui-container fly-marginTop fly-user-main">
  @include('Blog.Common.user_nav')

  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
  
  <div class="site-tree-mobile layui-hide">
    <i class="layui-icon">&#xe602;</i>
  </div>
  <div class="site-mobile-shade"></div>
  
  
  <div class="fly-panel fly-panel-user" pad20>
    <!--
    <div class="fly-msg" style="margin-top: 15px;">
      您的邮箱尚未验证，这比较影响您的帐号安全，<a href="activate.html">立即去激活？</a>
    </div>
    -->
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title" id="LAY_mine">
        <li data-type="mine-jie" lay-id="index" class="layui-this">我发的帖</li>
        <li data-type="collection" data-url="/collection/find/" lay-id="collection">我收藏的帖</li>
      </ul>
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <ul class="mine-view jie-row">
            @if(!$article_list->isEmpty())
            @foreach($article_list as $v)
            <li>
              <a class="jie-title" href="{{route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])}}" target="_blank">{{$v->title}}</a>
              <i>{{date('Y-m-d',$v->create_time)}}</i>
              <em>{{$v->page_views}}阅/{{$v->comment_num}}评</em>
            </li>
            @endforeach
            @else
              <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表贴</i></div>
            @endif
          </ul>
          <div style="text-align: center">
              {{ $article_list->links() }}
          </div>
        </div>
        <div class="layui-tab-item">
          <ul class="mine-view jie-row">
            @if($collect)
              @foreach($collect as $v)
            <li>
              <a class="jie-title" href="{{route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])}}" target="_blank">{{$v->title}}</a>
              <i>收藏于{{date('Y-m-d',$v->create_time)}}</i>
            </li>
              @endforeach
            @else
              <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表贴</i></div>
            @endif
          </ul>
          @if($collect)
          <div style="text-align: center">
            {{ $collect->links() }}
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>
@endsection