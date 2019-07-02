<?php


namespace App\Http\Models\Blog;


use Illuminate\Database\Eloquent\Model;

class NavigationModel extends Model
{
    public $table = 'navigation';
    public $timestamps = false;

    public function getNavList($type){
        $list = $this->where('type',$type)
                    ->where('status',0)
                    ->orderBy('sort','asc')
                    ->get();
        return $list;
    }
}