<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;


class PostController extends Controller
{
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

}

;