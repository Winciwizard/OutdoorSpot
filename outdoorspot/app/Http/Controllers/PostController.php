<?php

namespace App\Http\Controllers;

use App\Post;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function getHome()
    {

        if (Auth::check()) {
            $posts = Post::all();
            return view('/home/home', ['posts' => $posts]);
        } else {
            return redirect()->back();
        }


    }


    public function postCreatePost(Request $request)

    {
        $this->validate($request,[

            'body' => 'required|between:3,70',
            'title'=> 'required|max:20'

        ]);



        $post = new Post();
        $post->description = $request['body'];
        $post->setAttribute('description', $request['body']);
        $post->post_title = $request['title'];

        $file = $request->file('image');
        if ($file) {

            $filename = "image-" . md5(uniqid()) . ".jpg";
            $file->storeAs("public", $filename);


            $post->post_image = $filename;

        }
        $request->user()->posts()->save($post);
        if ($post->save()) {
            $message = 'Post successfully created';
            return redirect()->route('home')->with(['message' => $message]);
        }
        if ($post === 0) {
            $message = "error with your post";
            return redirect()->route('home')->with(['message' => $message]);
        }


    }


    public function getDeletePost($post_id)
    {
        $post = Post::find($post_id)->first();

        $file = $post->post_image;
        Storage::disk('local')->delete('public/' . $file);
        $post->delete();

        return redirect()->route('home')->with(['message' => 'successfully deleted']);
    }

    public function postEditPost(Request $request)


    {
        $this->validate($request, [
            'title' => 'required|unique:posts|max:255',
            'body' => 'required',
        ]);


        $post = Post::find($request['postID'])->first();
        $post->description = $request['body'];
        $post->post_title = $request['title'];
        $post->update();
        return response('', 200);


    }


}

;