@extends('master')

@section('content')
<div class="row">
    <div class="col-md-8 offset-md-2 marge-haute">
        <h2>Parametres du compte</h2>
        <form action="{{route('user.update')}}" method="post"  enctype="multipart/form-data">
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudonyme" value="{{ $user->pseudo }}">
            </div>
            <div class="form-group">
                <label for="nom">Nom</label>
                <input type="text" class="form-control" name="nom" id="nom" placeholder="Votre nom de famille" value="{{ $user->nom }}">
            </div>
            <div class="form-group">
                <label for="prenom">Prénom</label>
                <input type="text" class="form-control" name="prenom" id="prenom" placeholder="Votre prénom" value="{{ $user->prenom }}">
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control" name="description" id="description" placeholder="Votre description" rows="5">{{ $user->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Votre Email" value="{{ $user->email }}">
            </div>
            <div class="form-group">
                <label for="image">Photo de profil</label>
                <input type="file" class="form-control-file" name="image" id="image">
                <small id="imageHelp" class="form-text text-muted"><i class="fas fa-exclamation-triangle"></i>Uniquement des images en .jpg</small>
            </div>
            <div class="form-group">
                <label for="oldpass">Ancien mot de passe</label>
                <input type="password" class="form-control" name="oldpass" id="oldpass" placeholder="Tapez votre ancien mot de passe">
            </div>
            <div class="form-group">
                <label for="newpass">Nouveau mot de passe</label>
                <input type="password" class="form-control" name="newpass" id="newpass" placeholder="Tapz votre nouveau mot de passe">
            </div>
            <div class="form-group">
                <label for="password">Nouveau mot de passe</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Confirmez votre nouveau mot de passe">
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary">Mettre à jour</button>
            </div>
            {{csrf_field()}}
        </form>
    </div>
</div>
@endsection