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
                <i class="far fa-thumbs-up"></i>
            </a>
        </span>
        </div>
        <h3>{{$post->description}}</h3>
        <div>
            <a href="#" class="edit">Modifier</a>
            <a href="{{route('post.delete', ['post' => $post->id])}}" class="delete">Supprimer</a>
        </div>
    </article>
    @endforeach

</div>

@endsection