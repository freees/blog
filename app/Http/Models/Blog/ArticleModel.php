<?php


namespace App\Http\Models\Blog;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class ArticleModel extends Model
{
    public $table = 'article';
    public $timestamps = false;

    public function getArticleList($where,$order,$sc='desc',$pageSize){
        DB::enableQueryLog();
        $db = $this->from('article as a')
                     ->join('navigation as n','a.nav_id','=','n.nav_id')
                     ->join('user as u','a.user_id','=','u.user_id')
                     ->select('a.*','n.name','u.nick_name','u.face_img');
        if($where){
            $db->where($where);
        }
        if($order){
            $db->orderBy($order,$sc);
        }
        $list = $db->paginate($pageSize);
        if($order){
            $list->appends([$order => $sc])->links();
        }
        $sql= DB::getQueryLog();
        return $list;
    }

    //发帖榜
    public function articleNum(){
        $list = $this->from('article as a')
                    ->join('user as u','a.user_id','=','u.user_id')
                    //->select(DB::raw('count(*) as num'))
                    ->selectRaw('count(*) as num,nick_name,face_img,blog_u.user_no' )
                   //->select('nick_name','face_img','u.user_no')
                    ->groupBy('u.nick_name','u.face_img','u.user_no')
                    ->get();
        return $list;
    }

    public function getArticleDetail($where){
        $data = $this->from('article as a')
            ->join('navigation as n','a.nav_id','=','n.nav_id')
            ->join('user as u','a.user_id','=','u.user_id')
            ->select('a.*','n.name','u.nick_name','u.face_img')
            ->where($where)
            ->first();
        return $data;
    }
}