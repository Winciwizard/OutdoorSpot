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
    public function postLike(Post $post)
    {
        //TODO: Gerer le like pour user::Auth et les autres
        $like = Like::where('user_id', '=', Auth::id())->where('post_id','=', $post->id)->first();

        if(!isset($like))
        {

            $like = new Like();
            $like->setAttribute('like',Like::LIKE );
            $like->setAttribute('user_id',Auth::id());
            $post->likes()->save($like);
            return response()->json($like, 200);
        }


        if($like->like === Like::UNLIKE){

            $like->setAttribute('like', Like::LIKE);
        }
        elseif ($like->like === Like::LIKE){

            $like->setAttribute('like', Like::UNLIKE);
        }

        $like->update();
        return response()->json($like,200);
    }
}
