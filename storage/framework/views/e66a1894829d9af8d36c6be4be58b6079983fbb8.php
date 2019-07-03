<?php $__env->startSection('main'); ?>
<div class="layui-container fly-marginTop">
  <div class="fly-panel" pad20 style="padding-top: 5px;">
    <div class="layui-form layui-form-pane">
      <div class="layui-tab layui-tab-brief" lay-filter="user">
        <ul class="layui-tab-title">
          <li class="layui-this">发表新帖</li>
        </ul>
        <div class="layui-form layui-tab-content" id="LAY_ucm" style="padding: 20px 0;">
          <div class="layui-tab-item layui-show">
            <form action="" method="post">
              <div class="layui-row layui-col-space15 layui-form-item">
                <div class="layui-col-md3">
                  <label class="layui-form-label">所在专栏</label>
                  <div class="layui-input-block">
                    <select lay-verify="required" id="nav_id"  name="nav_id" lay-filter="column" lay-search="">
                      <option value="">选择或搜索</option>
                      <?php $__currentLoopData = $nav_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <option value="<?php echo e($v->nav_id); ?>"><?php echo e($v->name); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                </div>
                <div class="layui-col-md9">
                  <label for="L_title" class="layui-form-label">标题</label>
                  <div class="layui-input-block">
                    <input type="text" id="title" name="title" required lay-verify="required" autocomplete="off" class="layui-input">
                  </div>
                </div>
              </div>
              <div class="layui-form-item layui-form-text">
                <div class="layui-input-block">
                  <textarea id="content" name="content" lay-verify="content"  placeholder="详细描述" class="layui-textarea fly-editor" style="height: 260px;display: none"></textarea>
                </div>
              </div>
              <div class="layui-form-item">
                <label for="L_vercode" class="layui-form-label">人类验证</label>
                <div class="layui-input-inline">
                  <input type="text" id="captcha" name="captcha" required lay-verify="required" placeholder="请回答后面的问题" autocomplete="off" class="layui-input">
                </div>
                <div class="layui-form-mid" style="padding: 0!important;">
                  <img src="<?php echo e(captcha_src('math')); ?>" onclick="this.src='<?php echo e(captcha_src('math')); ?>'+Math.random()">
                </div>
              </div>
              <div class="layui-form-item">
                <button class="layui-btn" lay-filter="add" lay-submit>立即发布</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  layui.use('layedit', function(){
    var layedit = layui.layedit,
        form = layui.form;
    layedit.set({
      uploadImage: {
        url: '<?php echo e(url('upload_image')); ?>' //接口url
        ,type: 'post' //默认post
      }
    });
    var index = layedit.build('content',{
      tool: [
        'code' //插入代码
        ,'image' //插入图片
        ,'strong' //加粗
        ,'left' //左对齐
        ,'center' //居中对齐
        ,'right' //右对齐
        ,'link' //超链接
        ,'face' //表情

      ]
    }); //建立编辑器
    //将富文本内容同步到表单,否则无法获取
    form.verify({
      content:function () {
        return layedit.sync(index);
      }
    });
    form.on('submit(add)', function(data){
      data.field['content'] = layedit.getContent(index);
      $.post("<?php echo e(url('add_article')); ?>",data.field,function(res){
        if(res.code == '1'){
          layer.msg(res.msg, {icon: 1},function () {
              window.location.href='<?php echo e(url('index')); ?>';
          });
        }else if(res.code == '2'){
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