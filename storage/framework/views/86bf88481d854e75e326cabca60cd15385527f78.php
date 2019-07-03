<div class="fly-header layui-bg-black">
    <div class="layui-container">
        <a class="fly-logo" href="<?php echo e(url('/')); ?>">
            <img src="<?php echo e(asset('images/blog/logo.png')); ?>">
        </a>
       

        <ul class="layui-nav fly-nav-user">
            <?php if(!session('user_id')): ?>
                <!-- 未登入的状态 -->
                    <li class="layui-nav-item">
                        <a class="iconfont icon-touxiang layui-hide-xs" href="<?php echo e('login'); ?>"></a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="<?php echo e(url('login')); ?>">登入</a>
                    </li>
                    <li class="layui-nav-item">
                        <a href="<?php echo e(url('register')); ?>">注册</a>
                    </li>
            <?php else: ?>
                    <li class="layui-nav-item">
                        <a class="fly-nav-avatar" href="javascript:void(0)" >
                            <cite class="layui-hide-xs"><?php echo e(session('nick_name')); ?></cite>
                            <i class="iconfont icon-renzheng layui-hide-xs" ></i>
                            <img src="<?php echo e(session('face_img')); ?>">
                        </a>
                        <dl class="layui-nav-child" id="user_setting">
                            <dd><a href="<?php echo e(route('user_home',['user_no'=>session('user_no')])); ?>"><i class="layui-icon" style="margin-left: 2px; font-size: 22px;">&#xe68e;</i>我的主页</a></dd>
                            <dd><a href="<?php echo e(url('check_email')); ?>"><i class="layui-icon">&#x1005;</i>邮箱激活</a></dd>
                            <dd><a href="<?php echo e(url('my_article')); ?>"><i class="layui-icon">&#xe60a;</i>我的贴子</a></dd>
                            <dd><a href="<?php echo e(url('set')); ?>"><i class="layui-icon">&#xe620;</i>基本设置</a></dd>
                            <hr style="margin: 5px 0;">
                            <dd><a href="<?php echo e(url('logout')); ?>" style="text-align: center;">退出</a></dd>
                        </dl>
                    </li>
        <?php endif; ?>
        </ul>
    </div>
</div>