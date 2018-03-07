<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CommentController extends Controller
{

    /**
     * Function for creation of a new comment on a post
     *
     * @param Request $request
     * @param Post $post
     * @return Response
     */
    public function postCreateComment(Request $request, Post $post)
    {
        $this->validate($request, [
           'comment' => 'required|max:255'
        ]);

        $comment = new Comment();
        $comment->setAttribute('comment', $request->input('comment'));
        $comment->setAttribute('user_id', Auth::id());

        $post->comments()->save($comment);

        return redirect()->route('dashboard');
    }

    /**
     * @param Comment $comment
     * @return JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function getDeleteComment(Comment $comment): JsonResponse
    {
        if (Auth::user() != $comment->user){
            return redirect()->back();
        }

        $comment->delete();

        return response()->json(['message' => 'Commentaire supprimé'], JsonResponse::HTTP_OK);

    }
}
