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

Route::get('/login',[
    function (){
    return view('auth/login');
},'as' => 'login'
]);

Route::post('/user/create',[
    'uses' => 'UserController@postUserCreate',
    'as' => 'user.create'
]);

Route::post('/user/connect',[
    'uses' => 'UserController@postUserConnect',
    'as' => 'user.connect'
]);

Route::group(['middleware' => 'auth'], function()
{
    Route::get('user/parameter',[
        'uses' => 'UserController@getParameter',
        'as' => 'parameter'
    ]);

    Route::post('/user/update',[
        'uses' => 'UserController@postUserUpdate',
        'as' => 'user.update'
    ]);

    Route::get('/', [
        'uses' => 'PostController@getDashboard',
        'as' => 'dashboard'
    ]);

    Route::get('/post/dashboard', [
        'uses' => 'PostController@getDashboard',
        'as' => 'dashboard'
    ]);

    Route::post('/post/create', [
        'uses' => 'PostController@postCreatePost',
        'as' => 'post.create'
    ]);

    Route::get('/post/delete/{post}', [
        'uses' => 'PostController@getDeletePost',
        'as' => 'post.delete'
    ]);

    Route::get('/post/{post}.json',[
        'uses' => 'PostController@getPostJson',
        'as' => 'post.getjson'
    ]);

    Route::post('/post/edit/{post}', [
        'uses' => 'PostController@postEditPost',
        'as' => 'post.edit'
    ]);

    Route::post('/comment/create/{post}', [
        'uses' => 'CommentController@postCreateComment',
        'as' => 'comment.create'
    ]);

    Route::get('/comment/delete/{comment}', [
       'uses' => 'CommentController@getDeleteComment',
       'as' => 'comment.delete'
    ]);

    Route::post('/like/{post}', [
        'uses' => 'LikeController@postLike',
        'as' => 'like'
    ]);

    Route::get('/logout', [
        'uses' => 'UserController@getLogout',
        'as' => 'logout'
    ]);
});