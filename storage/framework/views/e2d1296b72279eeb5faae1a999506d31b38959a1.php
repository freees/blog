<?php $__env->startSection('main'); ?>
  <div class="fly-panel fly-column">
    <div class="layui-container">
      <ul class="layui-clear">
        <li class="layui-hide-xs"><a href="/">首页</a></li>
        <?php $__currentLoopData = $nav_list_2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li <?php if($nav_id == $value->nav_id): ?> class="layui-this" <?php endif; ?>>
            <a href="<?php echo e(route('article_list',['nav_id'=>$value->nav_id,'create_time'=>'desc'])); ?>">
              <?php echo e($value->name); ?>

              <span class="<?php echo e($value->class_name); ?>"></span>
            </a>
          </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <li class="layui-hide-xs layui-hide-sm layui-show-md-inline-block"><span class="fly-mid"></span></li>

        <!-- 用户登入后显示 -->
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
    <div class="layui-col-md8 content detail">
      <div class="fly-panel detail-box">
        <h1><?php echo e($detail->title); ?></h1>
        <div class="fly-detail-info">
          <span class="layui-badge layui-bg-green fly-detail-column"><?php echo e($detail->name); ?></span>
          <?php if($detail->is_top == 1): ?>
          <span class="layui-badge layui-bg-black">置顶</span>
          <?php endif; ?>
          <?php if($detail->is_fine == 1): ?>
          <span class="layui-badge layui-bg-red">精帖</span>
         <?php endif; ?>
          <span class="fly-list-nums">
            <?php if($detail->collect == 1): ?>
              <a href="javascript:void(0);" class="layui-badge layui-bg-blue" id="collect">已收藏</a>
            <?php else: ?>
              <a href="javascript:void(0);" class="layui-badge" id="collect" style="background: #c6c6c6">收藏</a>
            <?php endif; ?>
            <a href="#comment"><i class="iconfont" title="评论">&#xe60c;</i> <?php echo e($detail->comment_num); ?></a>
            <i class="iconfont" title="人气">&#xe60b;</i> <?php echo e($detail->page_views); ?>

          </span>
        </div>
        <div class="detail-about" style="line-height: 45px;">
          <a class="fly-avatar" href="<?php echo e(route('user_home',['user_no'=>$detail->user_no])); ?>">
            <img src="<?php echo e($detail->face_img); ?>">
          </a>
          <div class="fly-detail-user">
            <a href="<?php echo e(route('user_home',['user_no'=>$detail->user_no])); ?>" class="fly-link">
              <cite><?php echo e($detail->nick_name); ?></cite>
              <i class="iconfont icon-renzheng"></i>
              <i class="layui-badge fly-badge-vip">VIP</i>
            </a>
            <span><?php echo e(date('Y-m-d H:i:s',$detail->create_time)); ?></span>
          </div>
          <div class="detail-hits" id="LAY_jieAdmin" data-id="123">
          </div>
        </div>
        <div class="detail-body photos d_content">
          <?php echo $detail->content; ?>

        </div>
      </div>

      <div class="fly-panel detail-box" id="flyReply">
        <fieldset class="layui-elem-field layui-field-title" style="text-align: center;">
          <legend>评论</legend>
        </fieldset>

        <ul class="jieda" id="jieda">
          <?php if(!$comment_list->isEmpty()): ?>
          <?php $__currentLoopData = $comment_list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <li data-id="111" class="jieda-daan">
            <a name="item-1111111111"></a>
            <div class="detail-about detail-about-reply">
              <a class="fly-avatar" href="">
                <img src="<?php echo e($v->face_img); ?>" alt=" ">
              </a>
              <div class="fly-detail-user">
                <a href="" class="fly-link">
                  <cite class="nick_name"><?php echo e($v->nick_name); ?></cite>
                  <i class="iconfont icon-renzheng" ></i>
                  <i class="layui-badge fly-badge-vip">VIP</i>
                </a>
                <?php if($v['user_no'] == $detail->user_no): ?>
                <span>(楼主)</span>
                <?php endif; ?>
              </div>

              <div class="detail-hits">
                <span><?php echo e(date('Y-m-d H:i:s',$v->create_time)); ?></span>
              </div>
            </div>
            <div class="detail-body jieda-body photos">
              <p><?php echo $v->content; ?></p>
            </div>
            <div class="jieda-reply">
              <?php if(in_array(session('user_id'),explode(',',$v->like_user_id)) && session('user_id')): ?>
              <span class="jieda-zan zanok" type="zan" onclick="zan(<?php echo e($v->id); ?>,this)">
                <i class="iconfont icon-zan"></i>
                <em ><?php echo e($v->like_num); ?></em>
              </span>
              <?php else: ?>
                <span class="jieda-zan" type="zan" onclick="zan(<?php echo e($v->id); ?>,this)">
                <i class="iconfont icon-zan"></i>
                  <em><?php echo e($v->like_num); ?></em>
                </span>
              <?php endif; ?>

              <span type="reply" class="reply">
                <i class="iconfont icon-svgmoban53"></i>
                回复
              </span>
              <div class="jieda-admin">
                <!-- <span type="del">删除</span>-->
                <!-- <span class="jieda-accept" type="accept">采纳</span> -->
              </div>
            </div>
            <input id="comment_user_id" type="hidden" value="<?php echo e($v->user_id); ?>">
          </li>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php else: ?>
          <!-- 无数据时 -->
          <li class="fly-none">消灭零回复</li>
          <?php endif; ?>
        </ul>
        
        <div class="layui-form layui-form-pane">
          <form  method="post">
            <div class="layui-form-item layui-form-text">
              <a name="comment"></a>
              <div class="layui-input-block">
                <textarea id="L_content" name="content"  placeholder="请输入内容"  class="layui-textarea fly-editor" style="height: 150px;"></textarea>
              </div>
            </div>
            <div class="layui-form-item">
              <input type="hidden" name="article_id" value="<?php echo e($detail->article_id); ?>">
              <input type="hidden" id="reply_user_id" name="reply_user_id" value="0">
              <input type="hidden" id="reply_nick_name" name="reply_nick_name" value="">
              <button class="layui-btn" lay-filter="add" lay-submit>提交评论</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    <?php echo $__env->make('Blog.Common.right_module', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
  <script>
    layui.use("layer",function(){
      //相册层
      $(".d_content img").click(function () {
        var json = {
          title: "图片信息",
          id: "merchantManage",
          data: getPictureURL()
        }
        layer.photos({
          photos: json //格式见API文档手册页
          ,anim: 5 //0-6的选择，指定弹出图片动画类型，默认随机
        });
      });
    })

    function getPictureURL(){
      var photos = new Array();
      $(".d_content img").each(function(index){
        var photo = {
          pid: index,
          src: $(this).attr("src"),
          thumb: ''
        }
        photos.push(photo);
      });
      return photos;
    }

    layui.use('layedit', function(){
      var layedit = layui.layedit,
              form = layui.form;
      layedit.set({
        uploadImage: {
          url: '<?php echo e(url('upload_image')); ?>' //接口url
          ,type: 'post' //默认post
        }
      });
      var index = layedit.build('L_content',{
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
        $.post("<?php echo e(url('add_comment')); ?>",data.field,function(res){
          if(res.code == '1'){
            layer.msg(res.msg, {icon: 1},function () {
              window.location.reload();
            });
          }else if(res.code == -1){
            window.location.href="<?php echo e(url('/login')); ?>"
          }else if(res.code == -2){
            window.location.href="<?php echo e(url('/check_email')); ?>"
          }else{
            layer.msg(res.msg, function () {
              //window.location.reload();
            });
          }
        },'json');
        return false;
      });


      $(document).on('click','.reply',function(){
        var reply_nick_name =  $(this).parents('li').find('.nick_name').html();
        layedit.setContent(index, '@'+reply_nick_name+'&nbsp;&nbsp;');
        var reply_user_id =  $(this).parents('li').find('#comment_user_id').val();
        $("#reply_user_id").val(reply_user_id);
        $("#reply_nick_name").val(reply_nick_name);

      });

      $(document).on('click','#collect',function(){
        var name = $(this).html();
        if(name == '已收藏'){
          $(this).removeClass('layui-bg-blue');
          $(this).css('background','#c6c6c6');
          $(this).html('收藏');
        }else{
          $(this).addClass('layui-bg-blue');
          $(this).html('已收藏');
        }
        $.post("<?php echo e(url('collect')); ?>",{'article_id':<?php echo e($detail->article_id); ?>},function(res){
          if(res.code == '1'){
            layer.msg(res.msg, {icon: 1},function () {
              //window.location.reload();
            });
          }else if(res.code == -1){
            window.location.href="<?php echo e(url('/login')); ?>"
          }else if(res.code == -2){
            window.location.href="<?php echo e(url('/check_email')); ?>"
          }else{
            layer.msg(res.msg, function () {
              //window.location.reload();
            });
          }
        },'json');
      });
    });
    
    function zan(id,obj) {
      var cla = $(obj).attr('class');
      var num = $(obj).find('em').html();
      if(cla == 'jieda-zan'){
        $(obj).addClass('zanok');
        $(obj).find('em').html(Number(num)+Number(1));
        $.get("<?php echo e(url('zan')); ?>",{'id':id},function(res){
          res = $.parseJSON(res);
            if(res.code == 2){
              layer.msg(res.msg, function () {
              });
            }else if(res.code == -1){
              window.location.href="<?php echo e(url('/login')); ?>"
            }else if(res.code == -2){
              window.location.href="<?php echo e(url('/check_email')); ?>"
            }
        });
      }else{
        layer.msg('你已经点过赞了', function () {
        });
      }
    }

  </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('Blog.Common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>