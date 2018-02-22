@extends('master')

@section('content')
<div id="content">
    <h1>FLUX HOOLI</h1>

    @foreach($posts as $post)
    <article class="post" data-postid="{{$post->id}}">
        <h2>{{$post->place}}</h2>
        <p>{{$post->description}}</p>
        <img src="{{asset('storage/'.$post->file)}}" class="spot-img"/>
        <div class="info">
            Posted by invited on {{$post->created_at->diffForHumans()}}
        </div>

    </article>
    @endforeach

</div>

@endsection