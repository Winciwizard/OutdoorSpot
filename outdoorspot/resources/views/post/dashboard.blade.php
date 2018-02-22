@extends('master')

@section('content')
<div id="content">
    <h1>DERNIERS SPOTS</h1>

    @foreach($posts as $post)
    <article class="post" data-postid="{{$post->id}}">
        <h2>{{$post->place}}</h2>
        <img src="{{asset('storage/'.$post->file)}}" class="spot-img"/>
        <div class="under-picture">
            <span class="info">
                Posted by invited on {{$post->created_at->diffForHumans()}}
            </span>
            <span class="like">
            <a href="#">
                <i class="far fa-heart"></i>
            </a>
        </span>
        </div>
        <h3>{{$post->description}}</h3>
        <div>
            <a href="#" class="edit" data-postid="{{$post->id}}">Modifier</a>
            <a href="{{route('post.delete', ['post' => $post->id])}}" class="delete">Supprimer</a>
        </div>
    </article>
    @endforeach
</div>
<div class="modal" tabindex="-1" role="dialog" id="edit-modal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modification du post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="post-body">Modifier la description</label>
                        <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="modal-save">Modifier</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
            </div>
        </div>
    </div>
</div>
@endsection