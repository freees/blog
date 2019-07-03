<?php $__env->startSection('main'); ?>

<div class="layui-container fly-marginTop fly-user-main">
  <?php echo $__env->make('Blog.Common.user_nav', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  <div class="fly-panel fly-panel-user" pad20>
    <ul class="layui-tab-title" style="width: 93%;margin: auto">
      <li class="layui-this"><?php echo e($to_nick_name); ?></li>
    </ul>
	  <div class="layui-tab layui-tab-brief" lay-filter="user" id="" style="margin-top: 15px;">

        <div>

        </div>
	    <div style="height: 300px;width: 86%;margin: auto;" class="fly-edit">

        </div>
        <div style="width: 90%;margin: auto;margin-top: 20px">
          <textarea id="content" name="content" lay-verify="content" class="layui-textarea fly-editor" style="height: 260px;display: none"></textarea>
        </div>
        <button type="button" class="layui-btn" style="position: absolute; right: 6%;bottom: 1%">发送</button>
	  </div>
	</div>
</div>
<script>
  layui.use(['layedit'], function(){
    var layedit = layui.layedit,
            form = layui.form;
    var element = layui.element;
    layedit.set({
      uploadImage: {
        url: '<?php echo e(url('upload_image')); ?>' //接口url
        ,type: 'post' //默认post
      }
    });
    var index = layedit.build('content',{
      height: 120,
      width:260,
      tool: [
        'image' //插入图片
        ,'strong' //加粗
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
<script>
  $(function () {
    connect();
  });
  if (typeof console == "undefined") {    this.console = { log: function (msg) {  } };}
  // 如果浏览器不支持websocket，会使用这个flash自动模拟websocket协议，此过程对开发者透明
  //WEB_SOCKET_SWF_LOCATION = "/swf/WebSocketMain.swf";
  // 开启flash的websocket debug
  WEB_SOCKET_DEBUG = true;
  var ws, name,info,info_json,to_user_info,user_info, client_list={};

  // 连接服务端
  function connect() {
    // 创建websocket
    ws = new WebSocket("ws://127.0.0.1:8282");
    // 当socket连接打开时，输入用户名
    ws.onopen = onopen;
    // 当有消息时根据消息类型显示不同信息
    ws.onmessage = onmessage;
    ws.onclose = function() {
      console.log("连接关闭，定时重连");
      connect();
    };
    ws.onerror = function() {
      console.log("出现错误");
    };
  }
  // 连接建立时发送登录信息
  function onopen()
  {
    $.ajax({
      type:'post',
      url:'<?php echo e(url('get_user_info')); ?>',
      async:false,
      data:{'to_user':'<?php echo e($to_user_no); ?>'},
      success:function (res) {
        info_json = res;
      }
    });
    var info = JSON.parse(info_json);
    console.log("websocket握手成功，发送登录数据:"+ info );
    //console.log("通讯对象数据:"+to_user);
    ws.send(JSON.stringify(info_json));
    //ws.send(data);
  }

  // 提交对话
  function onSubmit() {
    var input = document.getElementById("textarea");
    var to_client_id = $("#client_list option:selected").attr("value");
    var to_client_name = $("#client_list option:selected").text();
    ws.send('{"type":"say","to_client_id":"'+to_client_id+'","to_client_name":"'+to_client_name+'","content":"'+input.value.replace(/"/g, '\\"').replace(/\n/g,'\\n').replace(/\r/g, '\\r')+'"}');
    input.value = "";
    input.focus();
  }

  // 服务端发来消息时
  function onmessage(e)
  {
    console.log(e.data);
    var data = JSON.parse(e.data);

    switch(data['type']){
            // 服务端ping客户端
      case 'ping':
        ws.send('{"type":"pong"}');
        break;
            // 登录 更新用户列表
      case 'login':
        //{"type":"login","client_id":xxx,"client_name":"xxx","client_list":"[...]","time":"xxx"}
        say(data['client_id'], data['nick_name'],  data['nick_name']+'加入了群聊', data['time'], data['face_img']);

        console.log(data['client_name']+"登录成功");
        break;
            // 发言
      case 'say':
        //{"type":"say","from_client_id":xxx,"to_client_id":"all/client_id","content":"xxx","time":"xxx"}
        say(data['from_client_id'], data['from_nick_name'], data['content'], data['time'],data['from_face_img']);
        break;
            // 用户退出 更新用户列表
      case 'logout':
        //{"type":"logout","client_id":xxx,"time":"xxx"}
        //say(data['from_client_id'], data['from_client_name'], data['from_client_name']+' 退出了', data['time']);
        delete client_list[data['from_client_id']];
    }
    if(data['client_list']){
      client_list = data['client_list'];
      flush_client_list();
    }
  }

  // 刷新用户列表框
  function flush_client_list(){
    var  html = " <option value=\"all\">所有人</option>";
    for(var i = 0;i<client_list.length;i++){
      html+="<option value="+client_list[i]['client_id']+" >"+client_list[i]['nick_name']+"</option>";
    }
    $("#client_list").html(html);
  }

  // 发言
  function say(from_client_id, from_client_name, content, time,face_img){
    //解析新浪微博图片

    $("#dialog").append('<div class="speech_item"><img src="'+face_img+'" style="width: 20px;height: 20px" /> '+from_client_name+time+'<div style="clear:both;"></div><p class="triangle-isosceles top">'+content+'</p> </div>');
  }
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('Blog.Common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>