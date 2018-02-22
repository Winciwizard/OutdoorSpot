@extends('master')

@section('title')
   Home page
@endsection

@section('content')

    @include('include.message_erreur')

   <section class="row new-post ">

      <div class="col-6 ">
         <header><h3>New post</h3></header>
         <form action="{{route('post.create')}}" method="post">
             {{csrf_field()}}
            <div class="form-group">
               <textarea name="body" id="new-post" cols="20" rows="5" class="form-control" placeholder="Post your whatever"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
         </form>
      </div>

   </section>

   <section class="row posts">
      <div class="col">
         <header> <h3>Description</h3> </header>
          @foreach($posts as $post)
         <article class="post">
            <p>
                {{$post->description}}
            </p>
            <div class="info">Posted {{$post->created_at}}</div>
            <div class="interaction">
               <a href="#">like</a>
               <a href="#">Dilike</a>
               <a href="#">Edit</a>
               <a href="{{route('post.delete', ['post_id' =>$post->id])}}" class="delete">Delete</a>
            </div>
         </article>
   </section>
         @endforeach
      </div>


@endsection