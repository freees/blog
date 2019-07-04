<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//注册
Route::any('/register','Blog\\UserController@register');
//登录
Route::any('/login','Blog\\UserController@login');
//退出
Route::get('/logout','Blog\\UserController@logout');
//忘记密码
Route::any('/forget','Blog\\UserController@forget');
//获取验证码
Route::get('/getcode','Blog\\UserController@getCode');
//激活邮箱
Route::get('/check_email','Blog\\UserController@checkEmail')->middleware('user');
//首页
Route::get('/','Blog\\IndexController@index')->name('index');
Route::get('/index','Blog\\IndexController@index')->name('index');
//发贴
Route::any('/add_article','Blog\\ArticleController@addArticle')->middleware('user')->name('add_article')->middleware('email');
//上传图片
Route::post('/upload_image','Blog\\ArticleController@uploadImage');
//聊天图片
Route::post('/upload_chat_image','Blog\\UserController@uploadImage');
//文章列表
Route::any('/article_list','Blog\\ArticleController@articleList')->name ('article_list') ;
//文章详情
Route::any('/article_detail','Blog\\ArticleController@articleDetail')->name ('article_detail') ;
//评论
Route::any('/add_comment','Blog\\ArticleController@addComment')->name('add_comment')->middleware('user')->middleware('email');
//收藏
Route::any('/collect','Blog\\ArticleController@collect')->middleware('user')->middleware('email');
//点赞
Route::any('/zan','Blog\\ArticleController@zan')->middleware('user')->middleware('email')->name('zan');
//用户中心
Route::get('/chat','Blog\\UserController@chat')->middleware('user');
Route::get('/send_email','Blog\\UserController@sendEmail')->middleware('user');
Route::get('/my_article','Blog\\UserController@myArticle')->middleware('user');
Route::get('/user_home','Blog\\UserController@userHome')->name('user_home')->middleware('user');
Route::get('/message','Blog\\UserController@message')->middleware('user')->name('message')->middleware('email');
Route::any('/set','Blog\\UserController@set')->middleware('user');
Route::any('/set_face','Blog\\UserController@setFace')->middleware('user');
Route::any('/add_friend','Blog\\UserController@addFriend')->middleware('user');
Route::post('/get_user_info','Blog\\UserController@getUserInfo')->name('get_user_info');
