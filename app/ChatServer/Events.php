<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * 用于检测业务代码死循环或者长时间阻塞等问题
 * 如果发现业务卡死，可以将下面declare打开（去掉//注释），并执行php start.php reload
 * 然后观察一段时间workerman.log看是否有process_timeout异常
 */
//declare(ticks=1);
use \GatewayWorker\Lib\Gateway;

/**
 * 主逻辑
 * 主要是处理 onConnect onMessage onClose 三个方法
 * onConnect 和 onClose 如果不需要可以不用实现并删除
 */
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */
    public static function onConnect($client_id)
    {
        // 向当前client_id发送数据
       // Gateway::sendToClient($client_id, json_encode($msg));
        // 向所有人发送
      // Gateway::sendToAll( json_encode($msg));
    }
    



    public static function onMessage($client_id, $message)
    {
        // 客户端传递的是json数据
        $message_data = json_decode($message, true);
        if(!$message_data)
        {
            return ;
        }
        //绑定当前用户id
        Gateway::bindUid( $client_id,$message_data['user_no']);
        $_SESSION['nick_name'] = $message_data['nick_name'];
        $_SESSION['to_user_no'] = $message_data['to_user_no'];
        // 根据类型执行不同的业务
        switch($message_data['type'])
        {
            case 'login':
                if($message_data['to_user_no'] == 'all'){
                    //获取分组当前在线成连接数
                    $onlie_count = Gateway::getClientIdCountByGroup(1);
                    $new_message = [
                        'type'=>$message_data['type'],
                        'nick_name'=>htmlspecialchars($message_data['nick_name']),
                        'time'=>date('Y-m-d H:i:s'),
                        'prompt'=>$message_data['nick_name']."加入了群聊",
                        'onlie_count'=>$onlie_count+1,
                    ];
                    $room_id = 1;
                    Gateway::joinGroup($client_id, $room_id);
                    //群发消息，并排除当前ID
                    Gateway::sendToGroup($room_id, json_encode($new_message));
                    return;
                }else{
                    $to_user_no = $message_data['to_user_no'];
                    $is_online = Gateway::isUidOnline($to_user_no);
                    $prompt = $is_online== '1' ? '对方在线状态，可发送实时消息' : '对方离线状态，暂不支持离线消息';
                    $new_message = [
                        'type'=>$message_data['type'],
                      //  'nick_name'=>htmlspecialchars($nick_name),
                        'time'=>date('Y-m-d H:i:s'),
                        'prompt'=>$prompt
                    ];
                    Gateway::sendToClient($client_id, json_encode($new_message));
                    return;
                }
            case 'say':
                if($message_data['to_user_no'] == 'all'){
                    $new_message = [
                        'type'=>$message_data['type'],
                        'face_img'=>$message_data['face_img'],
                        'nick_name'=>htmlspecialchars($message_data['nick_name']),
                        'time'=>date('Y-m-d H:i:s'),
                        'chat_content'=>$message_data['chat_content']
                    ];
                    $room_id = 1;
                    //群发消息，并排除当前ID
                    Gateway::sendToGroup($room_id, json_encode($new_message),[$client_id]);
                    return;
                }else{
                    $to_user_no = $message_data['to_user_no'];
                    $new_message = [
                        'type'=>$message_data['type'],
                        'face_img'=>$message_data['face_img'],
                        'nick_name'=>htmlspecialchars($message_data['nick_name']),
                        'time'=>date('Y-m-d H:i:s'),
                        'chat_content'=>$message_data['chat_content']
                    ];
                    Gateway::sendToUid($to_user_no,json_encode($new_message));
                    return;
                }
        }
    }

   
   /**
    * 断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
//       if($_SESSION['to_user_no'] =='all'){
//           $new_message = [
//               'type'=>'logout',
//               'nick_name'=>htmlspecialchars($_SESSION['nick_name']),
//               'time'=>date('Y-m-d H:i:s'),
//               'prompt'=>$_SESSION['nick_name']."离开了群聊"
//           ];
//           //群发消息，并排除当前ID
//           Gateway::sendToGroup(1, json_encode($new_message),[$client_id]);
//           return;
//       }else{
//           $new_message = [
//               'type'=>'logout',
//               'nick_name'=>htmlspecialchars($_SESSION['nick_name']),
//               'time'=>date('Y-m-d H:i:s'),
//               'prompt'=>$_SESSION['nick_name']."下线了"
//           ];
//           //群发消息，并排除当前ID
//           Gateway::sendToUid($_SESSION['to_user_no'], json_encode($new_message),[$client_id]);
//           return;
//       }

   }
}
