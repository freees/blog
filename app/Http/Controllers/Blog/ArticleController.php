<?php


namespace App\Http\Controllers\Blog;

use App\Http\Models\Blog\ArticleModel;
use App\Http\Models\Blog\CommentModel;
use App\Http\Models\Blog\NavigationModel;
use App\Http\Models\Blog\UserModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
class ArticleController extends Controller
{
    protected $articleModel;
    public function __construct()
    {
        $this->articleModel = new ArticleModel();
    }

    public function addArticle(Request $request){
        if(request()->ajax()){
            $data = $request->input();
            //验证验证码
            if (! captcha_check($data['captcha'])) {
                return json_encode(['msg'=>'验证码错误','code'=>'2']);
            }
            unset($data['captcha']);
            unset($data['file']);
            $data['user_id'] = session('user_id');
            $data['user_no'] = session('user_no');
            $data['create_time'] = time();
            $result = $this->articleModel->insert($data);
            if($result){
                return json_encode(['msg'=>'发布成功','code'=>'1']);
            }else{
                return json_encode(['msg'=>'发布失败','code'=>'2']);
            }
        }
        $NavigationModel = new NavigationModel();
        $nav_list = $NavigationModel->getNavList(2);
        return view('Blog.Article.add_article')->with('nav_list',$nav_list);
    }

    public function articleList(Request $request){
        $nav_id = $request->input('nav_id');
        $title = $request->input('title');
        $create_time = $request->input('create_time');
        $page_views = $request->input('page_views');
        $comment_num = $request->input('comment_num');
        $is_fine = $request->input('is_fine');
        //$page = $request->input('page');
        $where = '';
        $order = '';
        if($nav_id){
            $where['a.nav_id'] = $nav_id;
        }
        if($title){
            $where['title'] = $title;
        }
        if($create_time){
            $order = 'create_time';
        }
        if($page_views){
            $order = 'page_views';
        }
        if($comment_num){
            $order = 'comment_num';
        }
        if($is_fine){
            $order = 'is_fine';
        }
        $list = $this->articleModel->getArticleList($where,$order,'desc',config('blog.article_page_size'));
        $NavigationModel = new NavigationModel();
        $nav_list_2 = $NavigationModel->getNavList(2);
        //防止下一页时分类颜色丢失
        if($nav_id) {
            $list->appends(['nav_id' => $nav_id])->links();
        }
        return view('Blog.Article.article_list')->with('article_list',$list)->with('nav_list_2',$nav_list_2)->with('nav_id',$nav_id)->with('order',$order);
    }

    public function articleDetail(Request $request){
        $article_id = $request->input('article_id');
        $nav_id = $request->input('nav_id');
        $NavigationModel = new NavigationModel();
        $nav_list_2 = $NavigationModel->getNavList(2);
        $detail = $this->articleModel->getArticleDetail(['article_id'=>$article_id]);
        $this->articleModel->where('article_id',$article_id)->increment('page_views');
        $CommentModel = new CommentModel();
        $comment_list = $CommentModel->getComment(['article_id'=>$article_id]);
        $collectInfo = DB::table('collect')->where('user_no',session('user_no'))->first();
        if($collectInfo){
            $collectInfo =json_decode(json_encode($collectInfo), true);
            $collectAll = json_decode($collectInfo['collect'],true);
            $article_ids = array_column($collectAll,'article_id');
            if(in_array($article_id,$article_ids)){
                $detail['collect'] = 1;//已收藏
            }else{
                $detail['collect'] = 0;
            }
        }
        return view('Blog.Article.article_detail')->with('nav_list_2',$nav_list_2)->with('detail',$detail)->with('nav_id',$nav_id)->with('comment_list',$comment_list);
    }

    public function addComment(Request $request){
        $data = $request->input();
        $data['user_id'] = session('user_id');
        $data['user_no'] = session('user_no');
        $data['create_time'] = time();
        $UserModel = new UserModel();
        $replyUser = $UserModel->where('user_id',$data['reply_user_id'])->first();
        $nick_name = mb_substr($data['content'],mb_strpos($data['content'],'@')+1, mb_strlen($replyUser['nick_name']));
        if($replyUser['nick_name'] != $nick_name){
            return json_encode(['msg'=>'回复昵称错误,请刷新页面','code'=>'0']);
        }
        if($data['user_id'] == $data['reply_user_id']){
            return json_encode(['msg'=>'不可以自言自语喔','code'=>'0']);
        }
        unset($data['file']);
        unset($data['reply_nick_name']);
        DB::beginTransaction();
        try{
            DB::table('comment')->insert($data);
            $this->articleModel->where('article_id',$data['article_id'])->increment('comment_num');
            DB::commit();
            return json_encode(['msg'=>'评论成功','code'=>'1']);
        }catch (Exception $e){
            DB::rollBack();
            return json_encode(['msg'=>'评论失败','code'=>'2']);
        }

    }

    public function collect(Request $request){
        $article_id = $request->input('article_id');
        $collect = ['article_id'=>$article_id,'create_time'=>time()];
        $collectInfo = DB::table('collect')->where('user_no',session('user_no'))->first();
        $collectAll = [];
        if($collectInfo){
            $collectInfo =json_decode(json_encode($collectInfo), true);
            $collectAll = json_decode($collectInfo['collect'],true);
            foreach ($collectAll as $k => $v){
                if($article_id == $v['article_id']){
                    unset($collectAll[$k]);
                    $data = ['collect'=>json_encode($collectAll)];
                    $res = DB::table('collect')->where('user_no',session('user_no'))->update($data);
                    if($res){
                        return json_encode(['msg'=>'取消收藏成功','code'=>'1']);
                    }else{
                        return json_encode(['msg'=>'服务器错误','code'=>'2']);
                    }
                }
            }
            $collectAll[] = $collect;
            $data = ['collect'=>json_encode($collectAll)];
            $res = DB::table('collect')->where('user_no',session('user_no'))->update($data);
        }else{
            $collectAll[] = $collect;
            $data = [
                'user_id'=>session('user_id'),
                'user_no'=>session('user_no'),
                'collect'=>json_encode($collectAll),
            ];
            $res = DB::table('collect')->insert($data);
        }
        if($res){
            return json_encode(['msg'=>'收藏成功','code'=>'1']);
        }else{
            return json_encode(['msg'=>'收藏失败','code'=>'2']);
        }
    }

    public function zan(Request $request){
        $id = $request->input('id');
        $CommentModel = new CommentModel();
        $data = $CommentModel->where('id',$id)->first();
        if($data['like_user_id']){
            $update['like_user_id'] = ','.session('user_id');
        }else{
            $update['like_user_id'] = session('user_id');
        }
        $update['like_num'] = $data['like_num']+1;
        $res = $CommentModel->where('id',$id)->update($update);
        if($res){
            return json_encode(['msg'=>'点赞成功','code'=>'1']);
        }else{
            return json_encode(['msg'=>'服务器错误','code'=>'2']);
        }
    }

    /*
     *富文本图片上传
     */
    public function uploadImage(Request $request){
        $path = $request->file('file')->store('article');
        $path = asset('upload/'.$path);
        $data = ['code'=>0,'msg'=>'上传成功','data'=>['src'=>"$path"]];
        return  json_encode($data);
    }
}