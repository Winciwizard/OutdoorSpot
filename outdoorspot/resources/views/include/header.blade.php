<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('css/main.css')}}">


</head>

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
                <li class="nav-item" style="font-size:20px;">
                    <a class="nav-link " href="{{route('disconnect')}}">
                        Disconnect
                    </a>
                </li>
            </ul>
        </div>
    </nav>

</header>

{{--MODAL DE POST--}}

<div class="modal fade" tabindex="-1" role="dialog" id="post-modal">
    <div class="post-modal" role="document">
        <div class="modal-content">
            <div class="row">
                <div class="col-6">

            <h5 class="modal-title ">Post</h5>
                </div>
            </div>

            <div class="modal-header">

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
                                    <input type="text" name="title" id="title" cols="20" rows="5" class="form-control"  placeholder="title">
                                    @if($errors->has('title'))
                                        @foreach($errors->all() as $error)
                                            <p class="error-post"> {{$error}} </p>

                                        @endforeach

                                    @endif
                                </label>
                            </div>
                            <div class="form-group">
                                <label>Description
                                    <textarea  type="text" name="body" id="body" cols="40" rows="5" class="form-control"
                                              placeholder="Post ce que tu veux"></textarea>
                                    @if($errors->has('body'))
                                        <p class="error-post">{{$errors}}</p>
                                    @endif
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
<script
        src="https://code.jquery.com/jquery-3.3.1.js"
        integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60="
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>

</html>
