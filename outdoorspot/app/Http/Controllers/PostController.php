<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
   public function getHome()
   {
       $posts = Post::all();
       return view('/home/home' , ['posts' => $posts]);
   }


    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
           'body' => 'required|max:1000'
        ]);
        $post = new Post();
        $post->description = $request['body'];
        $post->user_id = 1;
        $message ='error with your post';
//      $request->user()->posts()->save($post);
        if ($post->save())
        {
            $message = 'Post successfully created';
        }


        return redirect()->route('home')->with(['message'=>$message]);

    }

    public function getDeletePost($post_id)
    {
       $post = Post::find($post_id)->first();
       $post->delete();
       return redirect()->route('home')->with(['message'=>'successfully deleted']);
    }

};