<?php

namespace App\Http\Controllers;

use App\Post;

use App\Http\Requests\UserRequest;

use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function getHome()
    {
        $posts = Post::all();
        return view('/home/home', ['posts' => $posts]);
    }


    public function postCreatePost(UserRequest $request)

    {

        $post = new Post();
        $post->description = $request['body'];
        $post->setAttribute('description', $request['body']);
        $post->post_title = $request['title'];
        $post->user_id = 1;
        $message = 'error with your post';
//      $request->user()->posts()->save($post);

        $file = $request->file('image');
        if($file){

            $filename = "image-".md5(uniqid()).".jpg";
            $file->storeAs("public",$filename);


        $post->post_image = $filename;

        }
        if ($post->save()) {
            $message = 'Post successfully created';
            return redirect()->route('home')->with(['message' => $message]);
        }
        if ($post === 0)
        {
            $message= "image invalide";
            return redirect()->route('home')->with(['message' => $message]);
        }


    }


    public function getDeletePost($post_id)
    {



        $post = Post::find($post_id)->first();
        $post->delete();
        Storage::delete($post->post_title);
        return redirect()->route('home')->with(['message' => 'successfully deleted']);
    }

    public function postEditPost(UserRequest $request)


    {


        $post = Post::find($request['postID'])->first();
        $post->description = $request['body'];
        $post->post_title = $request['title'];
        $post->update();
        return response('', 200);


    }


}

;