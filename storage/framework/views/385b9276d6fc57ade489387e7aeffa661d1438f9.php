<?php $__env->startSection('main'); ?>
<div class="layui-container fly-marginTop">
  <div class="fly-panel fly-panel-user" pad20>
    <div class="layui-tab layui-tab-brief" lay-filter="user">
      <ul class="layui-tab-title">
        <li><a href="<?php echo e(url('login')); ?>">登入</a></li>
        <li class="layui-this">找回密码<!--重置密码--></li>
      </ul>
      <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <div class="layui-tab-item layui-show">
          <div class="layui-form layui-form-pane">
            <form method="post">
              <div class="layui-form-item">
                <label for="L_email" class="layui-form-label">邮箱</label>
                <div class="layui-input-inline">
                  <input type="text" id="email" name="email" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid" style="padding: 0!important;">
                  <button type="button" class="layui-btn layui-btn-normal" id="getcode" >获取验证码</button>
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">验证码</label>
                <div class="layui-input-inline">
                  <input type="text" id="L_vercode" name="code" required lay-verify="required" placeholder="请输入验证码" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_pass" class="layui-form-label">新密码</label>
                <div class="layui-input-inline">
                  <input type="password" id="L_pass" name="password" required lay-verify="required" autocomplete="off" class="layui-input">
                </div>
              </div>
              <div class="layui-form-item">
                <button class="layui-btn" alert="1" lay-filter="forget" lay-submit>提交</button>
              </div>
            </form>
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
  <script>
    var id;
    $("#getcode").click(function () {
      var email = $("#email").val();
      if(!email){
        layer.msg('邮箱不能为空');
        return false;
      }
        $(this).addClass('layui-btn-disabled');
        var time = 10;
        id=setInterval(function () {
            time--;
          $("#getcode").html(time+'秒后可重新获取');
          if(time <= 0){
            $("#getcode").removeClass('layui-btn-disabled');
            $("#getcode").html('获取验证码');
            clearInterval(id);
          }
        },1000)


      $.get("getcode", {email:email})
    })

    layui.use(['layer', 'form'], function(){
      var layer = layui.layer,form = layui.form;

      form.on('submit(forget)', function(data){
        $.post("<?php echo e(url('forget')); ?>",data.field,function(res){
          if(res.code == '1'){
            layer.msg(res.msg, {icon: 1},function () {
              window.location.href="<?php echo e(url('login')); ?>";
            });
          }else if(res.code == '2'){
            layer.msg(res.msg, function () {
              window.location.reload();
            });
          }
        },'json');
        return false;
      });
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Blog.Common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>