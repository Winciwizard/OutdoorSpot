<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class LikeController
 * @package App\Http\Controllers
 *
 * @property Like Likes
 */
class LikeController extends Controller
{
    /**
     * Function of like change
     *
     * @param Request $request
     * @param Post $post
     * @return JsonResponse
     */
    public function postLike(Request $request, Post $post): JsonResponse
    {
        //TODO: Gérer l'utilisateur
        $this->Likes = DB::table('likes');
        $like = $this->Likes->where('post_id',$request['id'])->get();


        if($like[0]->like === Like::UNLIKE){

            $post->likes()->update(['like' => Like::LIKE]);
            return response()->json(['newlike' => Like::getLike(Like::LIKE)], 200);
        }
        elseif ($like[0]->like === Like::LIKE){

            $post->likes()->update(['like' => Like::UNLIKE]);
            return response()->json(['newlike' => Like::getLike(Like::UNLIKE)], 200);
        }
    }
}
