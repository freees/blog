<?php $__env->startSection('main'); ?>
<div class="fly-panel fly-column">
  <div class="layui-container">
    <ul class="layui-clear">
      <li  class="layui-this"><a href="">首页</a></li>
        <?php $__currentLoopData = $nav_list_2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><a href="<?php echo e(route('article_list',['nav_id'=>$value->nav_id,'create_time'=>'desc'])); ?>"><?php echo e($value->name); ?><span class="<?php echo e($value->class_name); ?>"></span></a></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li>
        <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="<?php echo e(url('my_article')); ?>">我发表的贴</a></li>
        <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><a href="<?php echo e(url('my_article')); ?>">我收藏的贴</a></li>
    </ul>

    <div class="fly-column-right layui-hide-xs">
      <span class="fly-search"><i class="layui-icon"></i></span>
      <a href="<?php echo e(route('add_article')); ?>" class="layui-btn">发表新帖</a>
    </div>
    <div class="layui-hide-sm layui-show-xs-block" style="margin-top: -10px; padding-bottom: 10px; text-align: center;">
      <a href="<?php echo e(route('add_article')); ?>" class="layui-btn">发表新帖</a>
    </div>
  </div>
</div>

<div class="layui-container">
  <div class="layui-row layui-col-space15">
    <div class="layui-col-md8">
      <div class="fly-panel">
        <div class="fly-panel-title fly-filter">
          <a>置顶</a>
        </div>
        <ul class="fly-list">
          <?php $__currentLoopData = $top_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li>
            <a href="<?php echo e(route('user_home',['user_no'=>$v->user_no])); ?>" class="fly-avatar">
              <img src="<?php echo e($v->face_img); ?>" alt="">
            </a>
            <h2>
              <a class="layui-badge"><?php echo e($v->name); ?></a>
              <a href="<?php echo e(route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])); ?>"><?php echo e($v->title); ?></a>
            </h2>
            <div class="fly-list-info">
              <a href="<?php echo e(route('user_home',['user_no'=>$v->user_no])); ?>" link>
                <cite><?php echo e($v->nick_name); ?></cite>
                <i class="iconfont icon-renzheng"></i>
                <i class="layui-badge fly-badge-vip">VIP</i>
              </a>
              <span><?php echo e(date('Y-m-d H:i',$v->create_time)); ?></span>
              
              <span class=" layui-hide-xs"><i class="iconfont" title="人气">&#xe60b;</i> <?php echo e($v->page_views); ?></span>
              <span class="fly-list-nums"> 
                <i class="iconfont icon-pinglun1" title="评论"></i> <?php echo e($v->comment_num); ?>

              </span>
            </div>
            <div class="fly-list-badge">
              <?php if($v->is_top == 1): ?>
                <span class="layui-badge layui-bg-green">置顶</span>
              <?php endif; ?>
              <?php if($v->is_fine == 1): ?>
                <span class="layui-badge layui-bg-red">精帖</span>
              <?php endif; ?>
            </div>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
      </div>
      <div class="fly-panel" style="margin-bottom: 0;">
        <div class="fly-panel-title fly-filter">
          <a href="<?php echo e(route('index',['create_time'=>'desc'])); ?>" <?php if($order == 'create_time'): ?> class="layui-this" <?php endif; ?>>最新</a>
          <span class="fly-mid"></span>
          <a href="<?php echo e(route('index',['page_views'=>'desc'])); ?>" <?php if($order == 'page_views'): ?> class="layui-this" <?php endif; ?>>热度</a>
          <span class="fly-mid"></span>
          <a href="<?php echo e(route('index',['comment_num'=>'desc'])); ?>" <?php if($order == 'comment_num'): ?> class="layui-this" <?php endif; ?>>评论</a>
          <span class="fly-mid"></span>
          <a href="<?php echo e(route('index',['is_fine'=>'desc'])); ?>" <?php if($order == 'is_fine'): ?> class="layui-this" <?php endif; ?>>精贴</a>
        </div>

        <ul class="fly-list">
          <?php $__currentLoopData = $artile_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li>
            <a href="<?php echo e(route('user_home',['user_no'=>$v->user_no])); ?>" class="fly-avatar">
              <img src="<?php echo e($v->face_img); ?>" alt="">
            </a>
            <h2>
              <a class="layui-badge"><?php echo e($v->name); ?></a>
              <a href="<?php echo e(route('article_detail',['article_id'=>$v->article_id,'nav_id'=>$v->nav_id])); ?>"><?php echo e($v->title); ?></a>
            </h2>
            <div class="fly-list-info">
              <a href="<?php echo e(route('user_home',['user_no'=>$v->user_no])); ?>" link>
                <cite><?php echo e($v->nick_name); ?></cite>
                <i class="iconfont icon-renzheng"></i>
                <i class="layui-badge fly-badge-vip">VIP</i>
              </a>
              <span><?php echo e(date('Y-m-d H:i',$v->create_time)); ?></span>
              
              <span class="layui-hide-xs" ><i class="iconfont" title="人气">&#xe60b;</i> <?php echo e($v->page_views); ?> </span>
              <!--<span class="layui-badge fly-badge-accept layui-hide-xs">已结</span>-->
              <span class="fly-list-nums">

                <i class="iconfont icon-pinglun1" title="评论"></i> <?php echo e($v->comment_num); ?>

              </span>
            </div>
            <div class="fly-list-badge">
              <?php if($v->is_fine == 1): ?>
                <span class="layui-badge layui-bg-red">精帖</span>
              <?php endif; ?>
            </div>
          </li>
         <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        </ul>
        <?php if(count($artile_list) >= config('blog.article_page_size')): ?>
        <div style="text-align: center">
          <div class="laypage-main">
           <a href="<?php echo e(route('article_list',['page'=>'2',$order=>'desc'])); ?>" class="laypage-next">更多求解</a>
          </div>
        </div>
        <?php endif; ?>
      </div>
    </div>
    <?php echo $__env->make('Blog.Common.right_module', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Blog.Common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>