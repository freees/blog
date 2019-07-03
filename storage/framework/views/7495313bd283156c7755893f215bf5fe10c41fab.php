<?php $__env->startSection('resources'); ?>
  <script src="<?php echo e(asset('js/index.js')); ?>"></script>
<?php $__env->stopSection(); ?>
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
            <?php if(!$article_list->isEmpty()): ?>
            <?php $__currentLoopData = $article_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <a class="jie-title" href="<?php echo e(route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])); ?>" target="_blank"><?php echo e($v->title); ?></a>
              <i><?php echo e(date('Y-m-d',$v->create_time)); ?></i>
              <em><?php echo e($v->page_views); ?>阅/<?php echo e($v->comment_num); ?>评</em>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表贴</i></div>
            <?php endif; ?>
          </ul>
          <div style="text-align: center">
              <?php echo e($article_list->links()); ?>

          </div>
        </div>
        <div class="layui-tab-item">
          <ul class="mine-view jie-row">
            <?php if($collect): ?>
              <?php $__currentLoopData = $collect; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
              <a class="jie-title" href="<?php echo e(route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])); ?>" target="_blank"><?php echo e($v->title); ?></a>
              <i>收藏于<?php echo e(date('Y-m-d',$v->create_time)); ?></i>
            </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
              <div class="fly-none" style="min-height: 50px; padding:30px 0; height:auto;"><i style="font-size:14px;">没有发表贴</i></div>
            <?php endif; ?>
          </ul>
          <?php if($collect): ?>
          <div style="text-align: center">
            <?php echo e($collect->links()); ?>

          </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Blog.Common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>