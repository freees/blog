<?php


namespace App\Http\Controllers\Blog;


use App\Http\Controllers\Controller;
use App\Http\Models\Blog\ArticleModel;
use App\Http\Models\Blog\NavigationModel;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request){
        $create_time = $request->input('create_time');
        $page_views = $request->input('page_views');
        $comment_num = $request->input('comment_num');
        $is_fine = $request->input('is_fine');

        $order = 'create_time';
        if($page_views){
            $order = 'page_views';
        }
        if($comment_num){
            $order = 'comment_num';
        }
        if($is_fine){
            $order = 'is_fine';
        }
        $ArticleModel = new ArticleModel();
        //置顶文章
        $top_list =  $ArticleModel->getArticleList(['is_top'=>1],'a.create_time','desc',config('blog.top_page_size'));
        //下方文章
        $artile_list =  $ArticleModel->getArticleList([['is_top','<>','1']],$order,'desc',config('blog.article_page_size'));
        //分类
        $NavigationModel = new NavigationModel();
        $nav_list_2 = $NavigationModel->getNavList(2);
        return view('Blog.Index.index')->with('nav_list_2',$nav_list_2)->with('artile_list',$artile_list)->with('top_list',$top_list)->with('order',$order);
    }
}