<div class="layui-col-md4">

  <div class="fly-panel">
    <h3 class="fly-panel-title">温馨通道</h3>
    <ul class="fly-panel-main fly-list-static">
            <?php $__currentLoopData = $aisle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a <?php if(session('user_no')): ?> href="<?php echo e($v->url); ?>" <?php else: ?> href="javascript:;" id="getAisle" <?php endif; ?> target="_blank"><?php echo e($v->title); ?></a>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
  </div>

  <div class="fly-panel fly-rank fly-rank-reply" id="">
    <h3 class="fly-panel-title">发贴榜</h3>
    <dl>
      <?php $__currentLoopData = $article_num; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <dd>
          <a href="<?php echo e(route('user_home',['user_no'=>$v->user_no])); ?>">
            <img src="<?php echo e($v->face_img); ?>"><cite><?php echo e($v->nick_name); ?></cite><i>发帖<?php echo e($v->num); ?>次</i>
          </a>
        </dd>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </dl>
  </div>


  <dl class="fly-panel fly-list-one">
    <dt class="fly-panel-title">热议</dt>
      <?php $__currentLoopData = $hot_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <dd>
          <a href="<?php echo e(route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])); ?>"><?php echo e($v->title); ?></a>
          <span style="float: right"><i class="iconfont icon-pinglun1"></i> <?php echo e($v->comment_num); ?></span>
        </dd>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </dl>

    <div class="fly-panel" style="padding: 20px 0; text-align: center;">
        <img src="<?php echo e(asset('images/blog/wx_qrcode.jpg')); ?>" style="max-width: 100%;" alt="layui">
        <p style="position: relative; color: #666;">扫码关注Free社区订阅号</p>
    </div>

  <div class="fly-panel fly-link">
    <h3 class="fly-panel-title">友情链接</h3>
    <dl class="fly-panel-main">
        <?php $__currentLoopData = $link; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <dd><a href="<?php echo e($v->url); ?>" target="_blank"><?php echo e($v->title); ?></a><dd>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </dl>
  </div>



</div>