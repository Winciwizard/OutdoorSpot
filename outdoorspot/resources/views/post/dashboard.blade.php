@extends('master')

@section('content')
<div id="content">
    <h1>DERNIERS SPOTS</h1>
    <div class="row">
        <div class="col-md-12">

        @foreach($posts as $post)

            <article class="post" data-postid="{{$post->getAttribute('id')}}">
                <h2>{{$post->place}}</h2>
                <img src="{{asset('storage/'.$post->file)}}" class="spot-img"/>
                <div class="under-picture test">
                    <span class="info">
                        <img class='nano-image' src="{{asset('storage/'.$post->user['user_image'])}}"/>
                        {{strtoupper($post->user['pseudo'])}} on {{$post->getAttribute('created_at')->diffForHumans()}}
                    </span>
                    <span>
                        <span>{{count($post->likes->where('like','=','1'))}}</span>
                        <a href="#" class="like" id="like-post-{{$post->id}}">
                            @if($post->likes->where('user_id','=',Auth::id())->pluck('like')[0] === 1)
                                <i class="fas fa-heart love"></i>
                                @else
                                <i class="far fa-heart love"></i>
                                @endif
                        </a>
                    </span>
                </div>
                <div class="edit-delete test">
                    <a href="#" class="map-info" data-postid="{{$post->id}}" title="Modifier">Où</a>
                    @if(Auth::user() == $post->user)
                    <a href="#" class="edit" data-postid="{{$post->id}}" title="Modifier">Modifier</a>
                    <a href="{{route('post.delete', ['post' => $post->id])}}" class="delete" title="Supprimer">Supprimer</a>
                    @endif
                </div>
                <h3>{{$post->description}}</h3>
                @foreach($post->comments as $comment)
                <article data-postid="{{$comment->id}}" id="comment{{$comment->id}}" class="test block-commentaire">
                    <span>
                        {{$comment->comment}}
                        <small>{{strtoupper($comment->user['pseudo'])}}-{{$comment->created_at->diffForHumans()}}</small>
                    </span>
                    @if(Auth::user() == $comment->user)
                        <a href="#" id="{{$comment->id}}" class="commentaire">X</a>
                    @endif

                </article>
                @endforeach
                <form action="{{route('comment.create', ['post' => $post->id])}}" method="post" class="test">
                    <input type="text" class="form-control" name="comment" id="comment" placeholder="Ajouter un commentaire">
                    <button type="submit" class="btn btn-light"><i class="far fa-comment"></i></button>
                    {{csrf_field()}}
                </form>
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
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="post-body">Modifier la description</label>
                                <textarea class="form-control" name="post-body" id="post-body" rows="5"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" id="modal-save">Modifier</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>



        <div class="modal" tabindex="-1" role="dialog" id="map-modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Où est ce spot</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form>
                        <div class="modal-body">
                            <div class="form-group">
                                <div id="map"></div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
<script>
    var token = '{{csrf_token()}}';

    function initMap(lat, lng) {
        lat = (lat !== undefined) ? lat : -25.363;
        lng = (lng !== undefined) ? lng : 131.044;
        var uluru = {lat: lat, lng: lng};
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 9,
            center: uluru
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }
</script>

@endsection