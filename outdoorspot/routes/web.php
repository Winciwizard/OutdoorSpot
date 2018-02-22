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

Route::get("/post/{post}.json",[
    'uses' => 'PostController@getPostJson',
    'as' => 'post.getjson'
]);
