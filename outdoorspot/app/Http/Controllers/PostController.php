<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function getDashboard()
    {
        $posts = Post::orderBy('created_at','desc')->get();
        return view('post/dashboard', ['posts' => $posts]);
    }

    public function getPostJson(Post $post){
        return $post->jsonSerialize();
    }

    public function postCreatePost(Request $request)
    {
        $this->validate($request, [
            'place' => 'required|max:100',
            'description' => 'required|max:255',
            'image' => 'required|image|max:100240'
        ]);

        $file = $request->file('image');
        $cover = 'cover/'.md5(uniqid()).'.jpg';
        if($file) {
            Storage::disk('local')->put('public/'.$cover, File::get($file));
        }

        $post = new Post();
        $post->place = $request['place'];
        $post->description = $request['description'];
        $post->file = $cover;
        $post->save();

        return redirect()->back();
    }

    public function postEditPost(){

    }

    public function getDeletePost(Post $post){
        $post->delete();
        return redirect()->route('dashboard');
    }
}
