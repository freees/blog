<?php $__env->startSection('main'); ?>

<div class="layui-container fly-marginTop fly-user-main">
  <?php echo $__env->make('Blog.Common.user_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

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
      <ul class="layui-tab-title">
        <li class="layui-this">
          激活邮箱
        </li>
      </ul>
      <div class="layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
        <ul class="layui-form">
          <li class="layui-form-li">
            <label for="activate">您的邮箱：</label>
            <span class="layui-form-text"><?php echo e($user->email); ?>

              <?php if($user->email_is_check == 1): ?>
              <em style="color:#999;">（已成功激活）</em>
              <?php else: ?>
              <em style="color:#c00;">（尚未激活）</em>
                <?php endif; ?>
            </span>
          </li>
          <?php if($user->email_is_check == 0): ?>
          <li class="layui-form-li" style="margin-top: 20px; line-height: 26px;">
            <div>
              1. 如果您未收到邮件，或激活链接失效，您可以
              <a class="layui-form-a" style="color:#4f99cf;" id="send_email" href="javascript:;" email="" >重新发送邮件</a>，或者
              <a class="layui-form-a" style="color:#4f99cf;" href="<?php echo e(url('set')); ?>">更换邮箱</a>；
            </div>
            <div>
              2. 邮箱为激活状态部分功能受限，例如：聊天、发贴、评论、点赞、收藏等；
            </div>
            <div>
              3. 如果您始终没有收到发送的邮件，请注意查看您邮箱中的垃圾邮件；
            </div>
            <div>
              4. 如果你实在无法激活邮件，您还可以联系：468027411@qq.com
            </div>
          </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </div>
  
</div>
<script>

  layui.use(['layer', 'form'], function(){
    var layer = layui.layer;
    $(document).on('click','#send_email',function(){
      $.get('<?php echo e(url('send_email')); ?>',function (res) {
        layer.msg('发送成功');
      })
    });
  });


</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Blog.Common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>