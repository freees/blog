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
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title" id="LAY_mine">
        <li class="layui-this" lay-id="info">我的资料</li>
        <li lay-id="avatar">头像</li>
        <li lay-id="pass">密码</li>
      </ul>
      <div class="layui-tab-content" style="padding: 20px 0;">
        <div class="layui-form layui-form-pane layui-tab-item layui-show">
          <form method="post">
            <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">邮箱</label>
              <div class="layui-input-inline">
                <input type="text" id="email" name="email" required lay-verify="email" autocomplete="off" value="{{$user->email}}" class="layui-input">
              </div>
              <div class="layui-form-mid layui-word-aux">如果您在邮箱已激活的情况下，变更了邮箱，需重新验证邮箱并手动重新登录。</div>
            </div>
            <div class="layui-form-item">
              <label for="L_email" class="layui-form-label">手机</label>
              <div class="layui-input-inline">
                <input type="text" id="mobile" name="mobile" required lay-verify="phone" autocomplete="off" value="{{$user->mobile}}" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item">
              <label for="L_username" class="layui-form-label">昵称</label>
              <div class="layui-input-inline">
                <input type="text" id="nick_name" name="nick_name" required lay-verify="required" autocomplete="off" value="{{$user->nick_name}}" class="layui-input">
              </div>
              <div class="layui-inline">
                <div class="layui-input-inline">
                  <input type="radio" name="sex" value="男" @if($user->sex =='男') checked @endif title="男">
                  <input type="radio" name="sex" value="女" @if($user->sex =='女') checked @endif title="女">
                </div>
              </div>
            </div>
            <div class="layui-form-item">
              <label for="L_city" class="layui-form-label">城市</label>
              <div class="layui-input-inline">
                <input type="text" id="area" name="area" autocomplete="off" value="{{$user->area}}" class="layui-input">
              </div>
            </div>
            <div class="layui-form-item layui-form-text">
              <label for="L_sign" class="layui-form-label">签名</label>
              <div class="layui-input-block">
                <textarea placeholder="随便写些什么刷下存在感" id="signature"  name="signature" autocomplete="off" class="layui-textarea" style="height: 80px;">{{$user->signature}}</textarea>
              </div>
            </div>
            <div class="layui-form-item">
              <button class="layui-btn" key="set-mine" lay-filter="set1" lay-submit>确认修改</button>
            </div>
            </form>
          </div>

          <div class="layui-form layui-form-pane layui-tab-item" id="avatar">
            <div class="layui-form-item">
              <div class="avatar-add">
                <p>建议尺寸168*168，支持jpg、png、gif，最大不能超过50KB</p>
                <button type="button" class="layui-btn upload-img" id="face_img">
                  <i class="layui-icon">&#xe67c;</i>上传头像
                </button>
                <img src="{{$user->face_img}}" id="face_img_url">
                <span class="loading"></span>
              </div>
            </div>
          </div>
          
          <div class="layui-form layui-form-pane layui-tab-item">
            <form  method="post">
              <div class="layui-form-item">
                <label for="L_nowpass" class="layui-form-label">当前密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="nowpass" name="nowpass" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="password" class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="password" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid layui-word-aux">6到16个字符</div>
              </div>
              <div class="layui-form-item">
                <label for="password2" class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="password2" name="password2" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <button class="layui-btn" key="set-mine" lay-filter="set2" lay-submit>确认修改</button>
              </div>
            </form>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>
<script>
  layui.use(['layedit','upload'], function(){
    var  form = layui.form,upload = layui.upload;
    form.on('submit(set1)', function(data){
      $.post("{{url('set')}}",data.field,function(res){
        if(res.code == '1'){
          layer.msg(res.msg, {icon: 1},function () {
            window.location.reload();
          });
        }else if(res.code == '2'){
          layer.msg(res.msg, function () {
            //window.location.reload();
          });
        }
      },'json');
      return false;
    });

    form.on('submit(set2)', function(data){
      if(!(/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[~!@#$%^&*()_+`\-={}:";'<>?,.\/]).{6,12}$/.test(data.field.password))){
        layer.msg('密码请设置6-12位的字母数字特殊字符组合');
        return false;
      }
      if(data.field.password != data.field.password2){
        layer.msg('两次密码不同o(╥﹏╥)o');
        return false;
      }
      $.post("{{url('set')}}",data.field,function(res){
        if(res.code == '1'){
          layer.msg(res.msg, {icon: 1},function () {
            window.location.href="{{url('login')}}";
          });
        }else if(res.code == '2'){
          layer.msg(res.msg, function () {
            // window.location.reload();
          });
        }
      },'json');
      return false;
    });

    upload.render({
      elem: '#face_img'
      ,url: '{{url('set_face')}}'
      ,accept: 'file' //普通文件
      ,exts: 'jpg|jpeg|png|gif' //只允许上传压缩文件
      ,done: function(res){
        if(res.code == '1'){
          $('#face_img_url').attr('src',res.src);
        }
        layer.msg(res.msg);
      }
    });
  });
</script>
@endsection