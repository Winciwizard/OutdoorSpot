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
                        Posted by invited on {{$post->getAttribute('created_at')->diffForHumans()}}
                    </span>
                </div>
                @foreach($post->likes as $like)
                    @if($like)
                    <span class="like">
                        <a href="#" id="{{$post->id}}">
                            {{ \App\Like::getLike($like['like']) }}
                        </a>
                    </span>
                    @endif
                @endforeach

                <div class="edit-delete test">
                    <a href="#" class="edit" data-postid="{{$post->id}}" title="Modifier">Modifier</a>
                    <a href="#" class="map-info" data-postid="{{$post->id}}" title="Modifier">Où</a>
                    <a href="{{route('post.delete', ['post' => $post->id])}}" class="delete" title="Supprimer">Supprimer</a>
                </div>
                <h3>{{$post->description}}</h3>

                @foreach($post->comments as $comment)
                <article data-postid="{{$comment->id}}" class="test">
                    <span>{{$comment->comment}}</span><small>{{$comment->created_at->diffForHumans()}}</small>
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