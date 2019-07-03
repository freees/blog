<ul class="layui-nav layui-nav-tree layui-inline" lay-filter="user">
    <li class="layui-nav-item">
        <a href="<?php echo e(route('user_home',['user_no'=>session('user_no')])); ?>">
            <i class="layui-icon">&#xe612;</i>
            我的主页
        </a>
    </li>
    <li class="layui-nav-item  <?php if(Request::path() == 'check_email'): ?> layui-this <?php endif; ?>">
        <a href="<?php echo e(url('check_email')); ?>">
            <i class="layui-icon">&#x1005;</i>
            邮箱激活
        </a>
    </li>
    <li class="layui-nav-item <?php if(Request::path() == 'my_article'): ?> layui-this <?php endif; ?>">
        <a href="<?php echo e(url('my_article')); ?>">
            <i class="layui-icon">&#xe60a;</i>
            我的贴子
        </a>
    </li>
    <li class="layui-nav-item <?php if(Request::path() == 'set'): ?> layui-this <?php endif; ?> ">
        <a href="<?php echo e(url('set')); ?>">
            <i class="layui-icon">&#xe620;</i>
            基本设置
        </a>
    </li>
    <li class="layui-nav-item <?php if(Request::path() == 'message'): ?> layui-nav-itemed <?php endif; ?>">
        <a href="javascript:;">
            <i class="layui-icon">&#xe611;</i>
            我的好友
        </a>
        <dl class="layui-nav-child">
            <dd><a href="<?php echo e(route('message',['to_user'=>'all'])); ?>">群聊</a></dd>
            <?php $__currentLoopData = $friends; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <dd><a href="<?php echo e(route('message',['to_user'=>$v->friend_no])); ?>"><?php echo e($v->nick_name); ?></a></dd>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </dl>
    </li>
</ul>
