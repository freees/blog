<?php

namespace App\Providers;

use App\Http\Models\Blog\ArticleModel;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //view()->share('key', 'value');//不限制模板
        View()->composer('Blog.Common.right_module',function ($view){
            $ArticleModel = new ArticleModel();
            //发帖榜
            $article_num = $ArticleModel->articleNum();
            //热议
            $hot_list = $ArticleModel->getArticleList([['comment_num','<>','0']],'comment_num','desc',config('blog.comment_page_size'));
            //小广告
            $ad = DB::table('link')->where('type',4)->where('status',0)->where('end_time','>',time())->get();
            //友情链接
            $link = DB::table('link')->where('type',1)->where('status',0)->where('end_time','>',time())->get();
            //温馨通道
            $aisle = DB::table('link')->where('type',2)->where('status',0)->where('end_time','>',time())->get();
            $view->with('article_num', $article_num)->with('hot_list',$hot_list)->with('ad',$ad)->with('link',$link)->with('aisle',$aisle);
        });
        View()->composer('Blog.Common.user_nav',function ($view){
            $friends = DB::table('friend as f')->where('f.user_no',session('user_no'))->join('user as u','f.friend_id','=','u.user_id')->select('u.nick_name','u.face_img','f.*')->get();
            $view->with('friends', $friends);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
