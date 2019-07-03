<?php $__env->startSection('main'); ?>
<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li class="layui-this">登入</li>
        <li><a href="<?php echo e(url('register')); ?>">注册</a></li>
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
                  <img src="<?php echo e(captcha_src('math')); ?>" onclick="this.src='<?php echo e(captcha_src('math')); ?>'+Math.random()">
                </div>
              </div>
              <div class="layui-form-item">
                <button class="layui-btn" lay-filter="login" lay-submit>立即登录</button>
                <span style="padding-left:20px;">
                  <a href="<?php echo e(url('forget')); ?>">忘记密码？</a>
                </span>
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
    form.on('submit(login)', function(data){
      $.post("<?php echo e(url('login')); ?>",data.field,function(res){
        if(res.code == '1'){
          layer.msg(res.msg, {icon: 1},function () {
            window.location.href="<?php echo e(url('index')); ?>";
          });
        }else if(res.code == '3'){
          window.location.href="<?php echo e(url('check_email')); ?>";
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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('Blog.Common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>