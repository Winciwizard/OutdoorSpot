<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use http\Env\Response;
use Illuminate\Http\Request;


class CommentController extends Controller
{

    /**
     * Function for creation of a new comment on a post
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function postCreateComment(Request $request, Post $post): Response
    {
        $this->validate($request, [
           'comment' => 'required|max:255'
        ]);

        $comment = new Comment();
        $comment->setAttribute('comment', $request->input('comment'));

        $post->comments()->save($comment);

        return redirect()->route('dashboard');
    }
    //TODO: Gestion de la suppression des commentaires
}
