@extends('master')

@section('content')

    <!- View du dashboard ->
<div id="content">
    <div class="row">
        <div class="col-sm-8 offset-sm-2 all">
        @foreach($posts as $post)
            <article class="post" data-postid="{{$post->getAttribute('id')}}">
                <span class="account">
                    <img class='nano-image' src="{{asset('storage/'.$post->user['user_image'])}}"/>
                    <b>{{strtolower($post->user['pseudo'])}}</b>
                </span>
                <img src="{{asset('storage/'.$post->file)}}" class="spot-img"/>
                <div class="under-picture test">
                    <b>{{$post->place}}</b>
                    <span>
                        <span>{{count($post->likes->where('like','=','1'))}}</span> J'aime
                        <a href="#" class="like" id="like-post-{{$post->id}}">
                            @if((isset($post->likes->where('user_id','=',Auth::id())->pluck('like')[0])) && ($post->likes->where('user_id','=',Auth::id())->pluck('like')[0] === 1))
                                <i class="fas fa-heart like-color"></i>
                                @else
                                <i class="far fa-heart like-color"></i>
                            @endif
                        </a>
                    </span>
                </div>
                <div class="edit-delete test">
                    <span>
                        <a href="#" class="map-info" data-postid="{{$post->id}}" title="Localiser">
                            <i class="fas fa-map-marker fa-1x"></i> Localiser
                        </a>
                    </span>
                    @if(Auth::user() == $post->user)
                    <span>
                        <a href="#" class="edit" data-postid="{{$post->id}}" title="Modifier"><i class="fas fa-edit"></i></a>
                        <a href="{{route('post.delete', ['post' => $post->id])}}" class="delete" title="Supprimer"><i class="fas fa-times"></i></a>
                    </span>
                    @endif
                </div>
                <div class="description">{{$post->description}}</div>
                <div class="commentaires">
                    @foreach($post->comments as $comment)
                    <article data-postid="{{$comment->id}}" id="comment{{$comment->id}}" class="test block-commentaire">
                        <span>
                            <b>{{strtolower($comment->user['pseudo'])}}</b> {{$comment->comment}}
                        </span>
                        @if(Auth::user() == $comment->user)
                            <a href="#" id="{{$comment->id}}" class="commentaire"><i class="fas fa-times"></i></a>
                        @endif
                    </article>
                    @endforeach
                    <i class="posted">{{$post->getAttribute('created_at')->diffForHumans()}}</i>
                    <form action="{{route('comment.create', ['post' => $post->id])}}" method="post" class="test com-form">
                        <input type="text" class="form-control input-com" name="comment" id="comment" placeholder="Ajouter un commentaire">
                        <button type="submit" class="btn btn-light"><i class="far fa-comment"></i></button>
                        {{csrf_field()}}
                    </form>
                </div>
            </article>
        @endforeach
        </div>

        <!- Modal de modification d'un post ->
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
                        @csrf
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

        <!- Modal d'affichage de la carte ->
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

    <!- Code JS spour affichage de la carte->
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