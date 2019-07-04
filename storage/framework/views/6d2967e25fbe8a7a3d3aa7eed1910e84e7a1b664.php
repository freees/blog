<?php $__env->startSection('main'); ?>
<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li><a href="<?php echo e(url('login')); ?>">登入</a></li>
        <li class="layui-this">注册</li>
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
                <div class="layui-form-mid layui-word-aux">将会成为您唯一的登入名</div>
              </div>
              <div class="layui-form-item">
                <label for="L_username" class="layui-form-label">昵称</label>
                <div class="layui-input-inline">
                  <input type="text" id="nick_name" name="nick_name" required lay-verify="nick_name" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_repass" class="layui-form-label">确认密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_repass" name="password2" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">人类验证</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_vercode" name="captcha" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid" style="padding: 0!important;">
                  <img src="<?php echo e(captcha_src('math')); ?>" onclick="this.src='<?php echo e(captcha_src('math')); ?>'+Math.random()">
                </div>
              </div>
              <div class="layui-form-item">
                <button class="layui-btn" lay-filter="register" lay-submit>立即注册</button>
              </div>
              
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
    form.on('submit(register)', function(data){
      if(!(/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[~!@#$%^&*()_+`\-={}:";'<>?,.\/]).{6,12}$/.test(data.field.password))){
        layer.msg('密码请设置6-12位的字母数字特殊字符组合');
        return false;
      }
      if(data.field.password != data.field.password2){
        layer.msg('两次密码不同o(╥﹏╥)o');
        return false;
      }
      $.ajax({
        type:'post',
        url:'<?php echo e(url('register')); ?>',
        data:data.field,
        beforeSend: function(){
          var loading = layer.load(0, {shade: false, time:2000});
        },
        success:function (res) {
          var res = JSON.parse(res);
          if(res.code == '1'){
            layer.msg(res.msg, {icon: 1},function () {
              window.location.href="<?php echo e(url('login')); ?>";
            });
          }else if(res.code == '2'){
            layer.msg(res.msg, function () {
              // window.location.reload();
            });
          }
        }
      })
      return false;
    });
  });

</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Blog.Common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>