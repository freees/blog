<?php


namespace App\Http\Models\Blog;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CommentModel extends Model
{
    public $table = 'comment';
    public $timestamps = false;
    public function getComment($where){
        DB::enableQueryLog();
        $list = $this->from('comment as c')
            ->join('user as u','c.user_id','=','u.user_id','left')
            ->join('user as r','c.reply_user_id','=','r.user_id','left')
            ->select('c.*','u.nick_name','u.face_img','r.nick_name as reply_nick_name')
            ->where($where)
            ->orderBy('c.create_time','asc')
            ->get();
        $sql= DB::getQueryLog();
        return $list;
    }
}