<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{

    public function postCreateComment(Request $request, Post $post){
        $this->validate($request,[
           'comment' => 'required|max:255'
        ]);

        $comment = new Comment();
        $comment->comment = $request['comment'];


        $post->comments()->save($comment);

        return redirect()->route('dashboard');
    }
}
