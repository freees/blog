@extends('Blog.Common.base')
@section('main')
<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li class="layui-this">登入</li>
        <li><a href="{{url('register')}}">注册</a></li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">
            <form method="post">
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_email" name="email" required lay-verify="email" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">人类验证</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_vercode" name="captcha" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid" style="padding: 0!important;">
                  <img src="{{captcha_src('math')}}" onclick="this.src='{{captcha_src('math')}}'+Math.random()">
                </div>
              </div>
              <div class="layui-form-item">
                <button class="layui-btn" lay-filter="login" lay-submit>立即登录</button>
                <span style="padding-left:20px;">
                  <a href="{{url('forget')}}">忘记密码？</a>
                </span>
              </div>
              {{--<div class="layui-form-item fly-form-app">
                <span>或者使用社交账号登入</span>
                <a href="" onclick="layer.msg('正在通过QQ登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-qq" title="QQ登入"></a>
                <a href="" onclick="layer.msg('正在通过微博登入', {icon:16, shade: 0.1, time:0})" class="iconfont icon-weibo" title="微博登入"></a>
              </div>--}}
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  layui.use(['layer', 'form'], function(){
    var layer = layui.layer,form = layui.form;
    form.on('submit(login)', function(data){
      $.post("{{url('login')}}",data.field,function(res){
        if(res.code == '1'){
          layer.msg(res.msg, {icon: 1},function () {
            window.location.href="{{url('index')}}";
          });
        }else if(res.code == '3'){
          window.location.href="{{url('check_email')}}";
        }else{
          layer.msg(res.msg, function () {
            //window.location.reload();
          });
        }
      },'json');
      return false;
    });
  });

</script>
@endsection


