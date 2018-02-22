@extends('master')

@section('title')
   Home page
@endsection

@section('content')
   <section class="row new-post ">

      <div class="col-6 ">

         <header><h3>New post</h3></header>
         <form action="{{route('post.create')}}" method="post">
             {{csrf_field()}}
            <div class="form-group">
               <textarea name="body" id="new-post" cols="20" rows="5" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Post</button>

         </form>
      </div>

   </section>
   <section class="row posts">
      <div class="col">
         <header> <h3>Description</h3> </header>
         <article class="post">
            <p>
               Une fable est un court récit en vers ou en prose qui vise à donner de façon plaisante une leçon de vie.
               Elle se caractérise souvent par un récit fictif de composition naïve et allégorique mettant en scène des animaux qui parlent,
               des êtres humains ou d’autres entités à l'aspect animal mais personnifiées1.
               Une morale est généralement exprimée à la fin ou au début de la fable. Celle-ci est parfois implicite, le lecteur devant la dégager lui-même.
               Buste de l'époque hellénistique censé représenter Ésope, le créateur du genre.
            </p>
            <div class="info">Posted by bob 20/50/9456</div>
            <div class="interaction">
               <a href="#">like</a>
               <a href="#">Dilike</a>
               <a href="#">Edit</a>
               <a href="#">Delete</a>
            </div>
         </article>
         <article class="post">
            <p>
               Une fable est un court récit en vers ou en prose qui vise à donner de façon plaisante une leçon de vie.
               Elle se caractérise souvent par un récit fictif de composition naïve et allégorique mettant en scène des animaux qui parlent,
               des êtres humains ou d’autres entités à l'aspect animal mais personnifiées1.
               Une morale est généralement exprimée à la fin ou au début de la fable. Celle-ci est parfois implicite, le lecteur devant la dégager lui-même.
               Buste de l'époque hellénistique censé représenter Ésope, le créateur du genre.
            </p>
            <div class="info">Posted by bob 20/50/9456</div>
            <div class="interaction">
               <a href="#">like</a>
               <a href="#">Dilike</a>
               <a href="#">Edit</a>
               <a href="#">Delete</a>
            </div>
         </article>
      </div>

   </section>
@endsection