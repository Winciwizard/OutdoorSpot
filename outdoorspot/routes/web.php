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
Route::group(['middleware' => ['web']], function () {

    Route::get('/home' , [
        'uses' => 'PostController@getHome',
        'as' => 'home'
    ]);

    Route::post('/post/create', [
        'uses' => 'PostController@postCreatePost',
        'as' => 'post.create'
    ]);

    Route::get('/delete-post/{post_id}', [
        'uses' => 'Postcontroller@getDeletePost',
        'as' => 'post.delete'
    ]);

    Route::post('/edit/{post_id}', [
        'uses' => 'PostController@postEditPost',
        'as' => 'edit'
    ]);

    Route::get('/inscription' , [
        'uses' => 'UserController@getInscription',
        'as' => 'inscription'
    ]);

    Route::post('/signup', [
        'uses' => 'UserController@postSignUp',
        'as' => 'signup'

    ]);


    Route::post('/signin', [
        'uses' => 'UserController@postSignIn',
        'as' => 'signin'

    ]);
    Route::get('/disconnect', [
        'uses' => 'UserController@getDisconnect',
        'as' => 'disconnect'

    ]);



});
