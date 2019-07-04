@extends('Blog.Common.base')
@section('resources')
<style>
  .prompt{width: 50%;background: #c6c6c6;margin: auto;color: white;text-align: center}
  .send_but{position: absolute; right: 6%;bottom: 1%}
  .show_content{height: 300px;width: 86%;margin: auto;overflow:auto;}
  .send_content{width: 90%;margin: auto;margin-top: 20px}
  .send_content textarea{height: 260px;display: none}
  .my_sms{width: 100%;height: 30px;margin: 8px 0 8px 0}
  .my_sms img{width: 30px;height:30px;border-radius: 2px;float: right}
  .my_sms div{height: 30px;background: lawngreen;padding: 0 5px 0 5px;width: max-content;float: right;border-radius: 5px;line-height: 30px;}
  .obj_sms{width: 100%;height: 30px;margin: 5px 0 5px 0}
  .obj_sms img{width: 30px;height:30px;border-radius: 2px;float: left}
  .obj_sms div{height: 30px;background: #fff;padding: 0 5px 0 5px;width: max-content;float: left;border-radius: 5px;line-height: 30px;border: 1px solid #e6e6e6;}
</style>
@endsection
@section('main')
<div class="layui-container fly-marginTop fly-user-main">
  @include('Blog.Common.user_nav')
  <div class="fly-panel fly-panel-user" pad20>
    <ul class="layui-tab-title" style="width: 93%;margin: auto">
      <li class="layui-this">@if($to_user_no != 'all'){{$to_nick_name}} @else 群聊（<span id="onlie_count"></span>）@endif</li>
    </ul>
	  <div class="layui-tab layui-tab-brief" lay-filter="user" id="" style="margin-top: 15px;">
	    <div class="fly-edit show_content" id="chat_content">

        </div>
        <div class="send_content">
          <textarea id="content" name="content" lay-verify="content" class="layui-textarea fly-editor" ></textarea>
        </div>
        <button type="button" class="layui-btn send_but"  id="send">发送</button>
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
        url: '{{url('upload_chat_image')}}' //接口url
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

      $(document).on('click','#send',function(){
        var chat_content = layedit.getContent(index);
        var send_chat_content = chat_content.replace(/"/g, '\\"').replace(/\n/g,'\\n').replace(/\r/g, '\\r')
        var info = '{"type":"say","user_no":"'+user_no+'","face_img":"'+face_img+'","nick_name":"'+nick_name+'","to_user_no":"'+to_user_no+'","chat_content":"'+send_chat_content+'"}';
        ws.send(info);
        layedit.setContent(index, '', false);
        var my_sms = '<div class="my_sms"><img src="'+face_img+'" ><div>'+chat_content+'</div></div>';
        $("#chat_content").append(my_sms);
      });
     // return false;


  });
</script>
<script>
  $(function () {
    connect();
  });
  if (typeof console == "undefined") {this.console = { log: function (msg) {  } };}
  // 如果浏览器不支持websocket，会使用这个flash自动模拟websocket协议，此过程对开发者透明
  //WEB_SOCKET_SWF_LOCATION = "/swf/WebSocketMain.swf";
  // 开启flash的websocket debug
  WEB_SOCKET_DEBUG = true;
  var ws, name,client_list={};
  var to_user_no = '{{$to_user_no}}';
  var user_no = '{{$user->user_no}}';
  var nick_name = '{{$user->nick_name}}';
  var face_img = '{{$user->face_img}}';

  // 连接服务端
  function connect() {
    // 创建websocket
    ws = new WebSocket("ws://127.0.0.1:8282");
    ws.onopen = onopen;
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
  function onopen() {
    var info = '{"type":"login","user_no":"'+user_no+'","nick_name":"'+nick_name+'","to_user_no":"'+to_user_no+'"}';
    ws.send(info);
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

      // 登录 更新用户列表
      case 'login':
        login(data.prompt);
        if(to_user_no == 'all'){
            $("#onlie_count").html(data.onlie_count+'人在线')
        }
        console.log(data.nick_name+"登录成功");
        break;
      // 发言
      case 'say':
        say(data.face_img, data.nick_name,data.time,data.chat_content);
        break;
        // 用户退出 更新用户列表
      case 'logout':
        login(data.prompt);
    }
    if(data['client_list']){
      client_list = data['client_list'];
    }
  }

  function login(prompt) {
    $('#chat_content').append('<div class="prompt">'+prompt+'</div>')
  }
  
  // 发言
  function say(face_img, nick_name, time, content){
    //解析新浪微博图片
   var sms = '<div class="obj_sms"><img src="'+face_img+'"><div >'+content+'</div></div>';
    $("#chat_content").append(sms);
  }
</script>
@endsection