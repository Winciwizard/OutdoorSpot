<?php

namespace App\Http\Controllers;

use App\Http\Resources\LikeResource;
use App\Like;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LikeApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return LikeResource::collection(Like::all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $like = new Like();

        $like->setAttribute('like', $request->like);
        $like->setAttribute('user_id',$request->user_id);
        $like->setAttribute('post_id',$request->post_id);

        $like->save();

        return response()->json($like, JsonResponse::HTTP_OK);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return LikeResource
     */
    public function show($id)
    {
        return new LikeResource(Like::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Like $like)
    {
        $like->setAttribute('like', $request->like);

        $like->update();

        return response()->json($like, JsonResponse::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Like $like
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Like $like)
    {
        $like->delete();

        return response()->json(['message' => 'like supprimé'], JsonResponse::HTTP_OK);
    }
}
