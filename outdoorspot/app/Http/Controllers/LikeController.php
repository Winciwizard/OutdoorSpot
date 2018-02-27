<?php

namespace App\Http\Controllers;

use App\Like;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function postLike(Request $request, Post $post){
        //@todo Gerer l'utilisateur
        $like = DB::table('likes')->where('post_id',$request['id'])->get();


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
