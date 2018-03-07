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
                  <label for="title">Titre du Post
                      <input name="title" id="title" cols="20" rows="5" class="form-control" placeholder="title">
                  </label>
              </div>
            <div class="form-group">
                <label>Description
               <textarea name="body" id="body" cols="40" rows="5" class="form-control" placeholder="Post your whatever"></textarea>
                </label>
            </div>
              <div class="form-group">
                  <label for="image">Only JPG
                      <input type="file" name="image" class="form-control" id="image">
                  </label>
              </div>
            <button type="submit" class="btn btn-primary">Post</button>
         </form>
      </div>

   </section>

   <section class="row posts">
      <div class="col">

          @foreach($posts as $post)
         <article class="post">
             <h3 id="view-title">{{$post->post_title}}</h3>
            <p id="view-body">
                {{$post->description}}
            </p>
            <div class="info">Posted {{$post->created_at}}
            </div>
            <div class="interaction">
               <a href="#">like</a>
               <a href="#">Dilike</a>
               <a href="" class="edit"  data-postid="{{$post->id}}" >Edit</a>
               <a href="{{route('post.delete', ['post_id' =>$post->id])}}" class="delete">Delete</a>
            </div>
         </article>

         @endforeach
      </div>
   </section>

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
                 <form >


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
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
             </div>
          </div>
       </div>
    </div>

<script>




</script>


@endsection

