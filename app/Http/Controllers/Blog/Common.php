<?php
/*公共函数*/
use App\Http\Models\Blog\UserModel;
/*
 * 获取用户信息根据ID
 */

function getUserInfo($user_id = 1){
    $UserModel = new UserModel();
    $userInfo = $UserModel->where('user_id',$user_id)->first();
    return $userInfo;
}
/**
 * 生成No(含字母)
 * @param $len NO长度
 */
function makeNo($code,$len=5,$seed='L1992'){
    $str = md5($code.$seed);
    $jy_code = substr($str,0,$len);
    return $code.$jy_code;
}

/**
 * 生成login_token数组
 */
 function makeLoginToken(){
    $time = time();
    $salt1 = makeStr(36);
    $salt2 = makeStr(36);
    $salt3 = makeStr(36);
    $user_token = sha1($salt1.$salt2.$salt3);
    $seed = sha1($salt3.$time.$salt2.$salt1);
    $first = hexdec(substr($seed,0,1));
    $rand = rand(1, 15);
    $end = dechex($rand);
    $k = abs($first)%$rand;
     $service_token = '';
    for($i=0,$j=$k; $i<=39; $i=$i+$j,$j++){
        $service_token .=  substr($seed,$i,$j) . substr($user_token,$i,$j);
    }
    $token['service_token'] = $user_token;
    $token['user_token'] = $service_token.$end;
    $token['timestamp'] = $time;
    return $token;
}

/**
 * 校验login_token合法性
 */
 function checkLoginToken($user_token,$service_token){
    //echo $user_token;die;
    $first = hexdec(substr($user_token,0,1));
    $end = hexdec(substr($user_token,80,1));
    $k = abs($first)%$end;
    //echo $first.','.$end.','.$k.'<br>';
    $count = 0;
    $temp = '';
    for ($i=0,$j=$k; $i<=79; $i=$i+2*$j,$j++) {
        if(($count+$j)>40){$j=40-$count;}
        $count += $j;
        $temp .= substr($user_token,$i+$j,$j);
    }
    //echo $temp.'<br>';
    if($temp==$service_token){
        return 1;
    }else{
        return 0;
    }
}

/**
 * 生成随机字符串
 * @param $count 随机字符串长度 默认10 取值范围1-36
 */
function makeStr($count=10){
    $str = 'QWERTYUIOPASDFGHJKLZXCVBNM1234567890qwertyuiopasdfghjklzxcvbnm';
    $from = rand(0, 25);
    return substr(str_shuffle($str),$from,$count);
}


//防SQL注入，防XSS攻击
function preventAttacks($data){
    $data['check_code'] = '1';
    foreach ($data as $k => $v){
        $data[$k] = addslashes($data[$k]);
        $data[$k] = htmlentities($data[$k],ENT_QUOTES);//将字符内容转化为html实体
        $str = '/select|insert|update|CR|document|LF|eval|delete|or|and|script|alert|union|into|load_file|outfile/';
        if(preg_match($str,$data[$k])) {
            $data['check_code'] = '2';
            return $data;
        }
    }
    return $data;
}