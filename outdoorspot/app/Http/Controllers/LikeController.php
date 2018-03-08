<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use http\Env\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

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
     * @param Post $post
     * @return JsonResponse
     */
    public function postLike(Post $post) :JsonResponse
    {
        /** @var Like $like */
        $like = Like::where('user_id', '=', Auth::id())->where('post_id','=', $post->id)->first();

        /** Instance a like when it is unexciting */
        if(!isset($like))
        {

            $like = new Like();
            $like->setAttribute('like',Like::LIKE );
            $like->setAttribute('user_id',Auth::id());
            $post->likes()->save($like);
            return response()->json($like, 200);
        }

        /** Change dislike to like */
        if($like->like === Like::UNLIKE){

            $like->setAttribute('like', Like::LIKE);
        }
        /** Change like to dislike */
        elseif ($like->like === Like::LIKE){

            $like->setAttribute('like', Like::UNLIKE);
        }

        $like->update();
        return response()->json($like,200);
    }
}
