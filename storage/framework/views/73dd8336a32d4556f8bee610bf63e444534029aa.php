
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
  <title>社区</title>
  <link rel="icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon" />
  <link rel="shortcut icon" href="<?php echo e(asset('favicon.ico')); ?>" type="image/x-icon" />
  <link rel="stylesheet" href="<?php echo e(asset('layui/css/layui.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css/global.css')); ?>">
  <script  src="<?php echo e(asset('layui/layui.js')); ?>"></script>
  <script  src="<?php echo e(asset('js/jquery.min.js')); ?>"></script>
  <script  src="<?php echo e(asset('js/common.js')); ?>"></script>
  <script>
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  </script>
  <?php echo $__env->yieldContent('resources'); ?>
</head>
<body>

  <?php echo $__env->make('Blog.Common.header', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

  <?php echo $__env->yieldContent('main'); ?>

  <?php echo $__env->make('Blog.Common.footer', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

</body>
</html>