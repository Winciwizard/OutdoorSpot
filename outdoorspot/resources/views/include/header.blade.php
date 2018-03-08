

{{--BARRE DE NAV--}}


<header>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">


        <div class="collapse navbar-collapse interaction" id="navbarNav">
            <ul class="navbar-nav">

                <li class="{{ Request::is('/') ? 'active' : '' }}">
                    <a class="navbar-brand " href="{{url('home')}}">
                        <i class="fas fa-leaf" style="font-size:20px; color:forestgreen"></i>
                        OutDoorSpot
                    </a>
                </li>
                <li class="nav-item" style="font-size:20px;">
                    <a class="nav-link" data-toggle="modal" data-target="#post-modal">
                        Post
                    </a>
                </li>
                <li class="nav-item" style="font-size:20px;">
                    <a class="nav-link" href="#">
                        Parameter
                    </a>
                </li>
                <li class="nav-item" style="font-size:20px;">
                    <a class="nav-link " href="#">
                        Search
                    </a>
                </li>
            </ul>
        </div>
    </nav>

</header>

{{--MODAL DE POST--}}

<div class="modal" tabindex="-1" role="dialog" id="post-modal">
    <div class="post-modal" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Post</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <section class="row new-post ">
                    <div class="col-6 ">
                        <header><h3>New post</h3></header>
                        <form action="{{route('post.create')}}" method="post"  enctype="multipart/form-data">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="title">Titre du Post
                                    <input name="title" id="title" cols="20" rows="5" class="form-control" placeholder="title">
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Description
                                    <textarea name="body" id="body" cols="40" rows="5" class="form-control"
                                              placeholder="Post your whatever"></textarea>
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
            </div>
        </div>

    </div>
</div>



