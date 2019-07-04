<?php


namespace App\Http\Controllers\Blog;

use App\Http\Models\Blog\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Http\Models\Blog\ArticleModel;

class UserController extends Controller
{
    protected $userModel;
    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function register(Request $request){
        if(request()->ajax()){
            $data = $request->input();
            //验证验证码
            if (! captcha_check($data['captcha'])) {
                return json_encode(['msg'=>'验证码错误','code'=>'2']);
            }
            //验证邮箱
            $arr = $this->userModel->select('*')->where('email',$data['email'])->first();
            if($arr){
                return json_encode(['msg'=>'邮箱已被注册','code'=>'2']);
            }
            //删除多余数据，直接存入数据库
            unset($data['password2']);
            unset($data['captcha']);
            //默认头像
            $k = mt_rand(1,4);
            $face_img = [
                asset('upload/face_img/default_face_img1.png'),
                asset('upload/face_img/default_face_img2.png'),
                asset('upload/face_img/default_face_img3.jpeg'),
                asset('upload/face_img/default_face_img4.png'),
                ];
            $data['face_img'] = $face_img[$k];
            $data['password'] = md5($data['password']);
            $data['create_time'] = time();
            $data['user_no'] = makeNo(uniqid('U'),5);
            //存入并获取ID
            $user_id = $this->userModel->insertGetId($data);

            if($user_id){
                //发送邮箱验证邮件
                Mail::send('Blog.Common.email',['user_no' => $data['user_no'],'nick_name' => $data['nick_name']],function ($message) {
                    $message->to($_POST['email']);
                    $message->subject('技术社区激活邮件');
                });
                return json_encode(['msg'=>'注册成功','code'=>'1']);exit;
            }
        }
        return view('Blog.User.register');
    }

    public function login(Request $request){
        if(request()->ajax()){
            $data = $request->input();
            if (!captcha_check($data['captcha'])) {
                return json_encode(['msg'=>'验证码错误','code'=>'2']);
            }
            $arr = $this->userModel->select('*')->where('email',$data['email'])->first();
            if(!$arr){
                return json_encode(['msg'=>'用户不存在','code'=>'2']);
            }

            if($arr['password'] == md5($data['password'])){
//                if($arr['email_is_check'] == '0'){
//                    return json_encode(['msg'=>'您的邮箱还未激活','code'=>'2']);
//                }
              //  $this->user = $arr;
                $loginToken = makeLoginToken();
                session(['user_id' => $arr['user_id']]);
                session(['user_no' => $arr['user_no']]);
                session(['nick_name' => $arr['nick_name']]);
                session(['face_img' => $arr['face_img']]);
                session(['login_token' => $loginToken['user_token']]);

                $this->userModel->where('user_id', $arr['user_id'])->update(['login_time' =>time(),'login_token'=>$loginToken['service_token']]);
                if($arr['email_is_check'] == 1){
                    return json_encode(['msg'=>'登录成功','code'=>'1']);
                }else{
                    return json_encode(['msg'=>'登录成功','code'=>'3']);
                }
                return json_encode(['msg'=>'登录成功','code'=>'1']);
            }else{
                return json_encode(['msg'=>'密码错误','code'=>'2']);
            }
        }
        return view('Blog.User.login');
    }

    function forget(Request $request){
        if(request()->ajax()){
            $data = $request->input();
            if($data['code'] != session('code')){
                return json_encode(['msg'=>'验证码错误','code'=>'2']);
            }
            $arr = $this->userModel->select('*')->where('email',$data['email'])->first();
            if(!$arr){
                return json_encode(['msg'=>'用户不存在','code'=>'2']);
            }
            $result = $this->userModel->where('email', $data['email'])->update(['password' => md5($data['password'])]);
            if($result){
                return json_encode(['msg'=>'密码重置成功','code'=>'1']);
            }else{
                return json_encode(['msg'=>'密码重置失败','code'=>'2']);
            }
        }
        return view('Blog.User.forget');
    }

    public function checkEmail(Request $request){
        $user_no = $request->input('user_no');
        if($user_no){
            $result = $this->userModel->where('user_no', $user_no)->update(['email_is_check' => 1]);
            if(!$result){
                return view('Blog.Common.404');
            }
        }

        $user = getUserInfo(session('user_id'));
        return view('Blog.User.check_email')->with('user',$user);
    }

    public function sendEmail(){
        Mail::send('Blog.Common.email',['user_no' => session('user_no'),'nick_name' => session('nick_name')],function ($message) {
            $user = getUserInfo(session('user_id'));
            $message->to($user['email']);
            $message->subject('Free社区激活邮件');
        });
        echo true; exit;
    }

    public function getCode(){
        $code = rand(1000,9999);
        session(['code' => $code]);
        Mail::send('Blog.Common.forget_email',['code' => $code],function ($message) {
            $message->to($_GET['email']);
            $message->subject('获取验证码');
        });
    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect('login');
    }

    public function set(Request $request){
        $user = getUserInfo(session('user_id'));
        if(request()->ajax()){
            $data = $request->input();
            if(array_key_exists('email',$data)){
                if($user['email'] != $data['email']){
                    $old = $this->userModel->where('email',$data['email'])->first();
                    if($old){
                        return json_encode(['msg'=>'邮箱已存在','code'=>'2']);
                    }
                    $data['email_is_check'] = 0;
                }
            }
            if(array_key_exists('nowpass',$data)){
                if(md5($data['nowpass']) == $user['password']){
                    unset($data['nowpass']);
                    unset($data['password2']);
                }else{
                    return json_encode(['msg'=>'原密码错误','code'=>'2']);
                }
            }
            $res = $this->userModel->where('user_no',session('user_no'))->update($data);
            if($res){
                return json_encode(['msg'=>'修改成功','code'=>'1']);
            }else{
                return json_encode(['msg'=>'修改失败','code'=>'2']);
            }
        }
        return view('Blog.User.set')->with('user',$user);
    }

    public function setFace(Request $request){
        $path = $request->file('file')->store('face_img');
        $path = asset('upload/'.$path);
        $res = $this->userModel->where('user_no',session('user_no'))->update(['face_img'=>$path]);
        if($res){
            session(['face_img'=>$path]);
            $data = ['code'=>'1','msg'=>'上传成功','src'=>"$path"];
        }else{
            $data = ['code'=>'0','msg'=>'上传失败','src'=>""];
        }

        return  json_encode($data);

    }
    public function myArticle(){
        $ArticleModel = new ArticleModel();
        $article_list = $ArticleModel->where('user_no',session('user_no'))->paginate(12,['*'],'page1')->setPageName('page1');
        $collectInfo = DB::table('collect')->where('user_no',session('user_no'))->first();
        if($collectInfo) {
            $collectInfo = json_decode(json_encode($collectInfo), true);
            $collectAll = json_decode($collectInfo['collect'], true);
            $article_ids = array_column($collectAll,'article_id');
            $collect = $ArticleModel->whereIn('article_id',$article_ids)->paginate(12,['*'],'page2')->setPageName('page2');

        }else{
            $collect = [];
        }
        return view('Blog.User.my_article')->with('article_list',$article_list)->with('collect',$collect);
    }
    public function userHome(Request $request){
        $user_no = $request->input('user_no');
        $userInfo = $this->userModel->where('user_no', $user_no)->first();
        $ArticleModel = new ArticleModel();
        $article_list = $ArticleModel->where('user_no',$user_no)->get();
        $friend = DB::table('friend')->where('user_no',session('user_no'))->where('friend_no',$user_no)->first();
        return view('Blog.User.user_home')->with('userInfo',$userInfo)->with('article_list',$article_list)->with('friend',$friend);
    }

    public function chat(){
        return view('Blog.User.chat');
    }
    public function message(Request $request){
        $to_user_no = $request->input('to_user_no');
        $to_nick_name = '群聊';
        if($to_user_no != 'all'){
            $to_user = $this->userModel->where('user_no', $to_user_no)->first();
            $to_user_no = $to_user['user_no'];
            $to_nick_name = $to_user['nick_name'];
        }
        $user = getUserInfo(session('user_id'));
        return view('Blog.User.message')->with('to_user_no',$to_user_no)->with('to_nick_name',$to_nick_name)->with('user',$user);
    }
    public function addFriend(Request $request){
        if(request()->ajax()){
            $friend_id = $request->input('friend_id');
            $friend_no = $request->input('friend_no');
            $data1 = [
                'user_id'=>session('user_id'),
                'user_no'=>session('user_no'),
                'friend_id'=>$friend_id,
                'friend_no'=>$friend_no,
                'create_time'=>time(),
            ];
            $data2 = [
                'user_id'=>$friend_id,
                'user_no'=>$friend_no,
                'friend_id'=>session('user_id'),
                'friend_no'=>session('user_no'),
                'create_time'=>time(),
            ];
            DB::beginTransaction();
            try{
                DB::table('friend')->insert($data1);
                DB::table('friend')->insert($data2);
                DB::commit();
                return json_encode(['msg'=>'添加成功','code'=>'1']);
            }catch (Exception $e){
                DB::rollBack();
                return json_encode(['msg'=>'添加失败','code'=>'2']);
            }

        }

    }


    public function getUserInfo(Request $request){
        $data['client_id'] = $request->input('client_id');
        $to_user = $request->input('to_user');
        if($data['client_id']){
            $this->userModel->where('user_no', session('user_no'))->update($data);
        }
        $userInfo = $this->userModel->where('user_no', session('user_no'))->first();
        if($to_user != 'all'){
            $toUserInfo = $this->userModel->where('user_no', $to_user)->first();
            $info['toUserInfo'] = $toUserInfo;
        }else{
            $info['toUserInfo'] = 'all';
        }

        $info['userInfo'] = $userInfo;

        return json_encode($info);
    }

    //聊天图片
    public function uploadImage(Request $request){
        $path = $request->file('file')->store('chat');
        $path = asset('upload/'.$path);
        $data = ['code'=>0,'msg'=>'上传成功','data'=>['src'=>"$path"]];
        return  json_encode($data);
    }

}