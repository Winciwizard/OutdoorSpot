@extends('master')

@section('title')
    Home page
@endsection
@include('include.header')
@section('content')






    @include('include.message_erreur')

            @foreach($posts as $post)

                <div class="container ">

                    <div class="row ">
                        <div class="col-md-6 offset-md-3">


                <article class="post ">

                    <h3 id="view-title">{{$post->post_title}}</h3>
                    <img  src="{{asset('storage/'. $post->post_image)}}" class="spot-img"/>
                    <p id="view-body">
                        {{$post->description}}
                    </p>
                    <div class="info">Posted {{$post->created_at}}
                    </div>
                    <div class="interaction border border-dark">


                        <a href="#">like</a>
                        <a href="#">Dilike</a>
                        <a href="" class="edit" data-postid="{{$post->id}}">Edit</a>
                        <a href="{{route('post.delete', ['post_id' =>$post->id])}}" class="delete">Delete</a>
                    </div>
                </article>
                        </div>
                    </div>
                </div>
            @endforeach


    {{--/*EDIT MODAL--}}

    <div class="modal" tabindex="-1" role="dialog" id="edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="post-title">Titre du Post
                                <input name="post-title" id="post-title" cols="20" rows="5" class="form-control" placeholder="title">
                            </label>
                        </div>
                        <div class="form-group">
                            <label for="post-body">Description
                                <textarea name="post-body" id="post-body" cols="20" rows="5" class="form-control" placeholder="Post your whatever"></textarea>
                            </label>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button href="" type="button" class="btn btn-primary" id="modal-save">Save changes</button>
                    <button type="button" class="btn btn-secondary close" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
















@endsection

