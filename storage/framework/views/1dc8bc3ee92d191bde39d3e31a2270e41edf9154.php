<?php if($paginator->hasPages()): ?>
    <div class="layui-box layui-laypage layui-laypage-default">
        <?php if($paginator->onFirstPage()): ?>
            <a href="javascript:;" class="layui-laypage-prev layui-btn-disabled" data-page="1">上一页</a>
        <?php else: ?>
            <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="layui-laypage-prev" data-page="1">上一页</a>
        <?php endif; ?>

        
        <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <?php if(is_string($element)): ?>
                
                <span class="layui-laypage-spr"><?php echo e($element); ?></span>
            <?php endif; ?>

            
            <?php if(is_array($element)): ?>
                <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($page == $paginator->currentPage()): ?>
                        <span class="layui-laypage-curr">
                                <em class="layui-laypage-em"></em>
                                <em><?php echo e($page); ?></em>
                            </span>
                    <?php else: ?>
                        <a href="<?php echo e($url); ?>" data-page="<?php echo e($page); ?>"><?php echo e($page); ?></a>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        
        <?php if($paginator->hasMorePages()): ?>
            <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="layui-laypage-next" data-page="3">下一页</a>
        <?php else: ?>
            <a href="javascript:;" class="layui-laypage-next layui-btn-disabled" data-page="3">下一页</a>
        <?php endif; ?>
    </div>
<?php endif; ?>