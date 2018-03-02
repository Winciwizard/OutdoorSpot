@extends('masterLogout')

@section('content')
<div class="row" id="login">
    <div class="col-md-6 offset-md-3">
        <form action="{{route('user.create')}}" method="post" id="inscription">
            @csrf
            <div id="title">
                <i class="fab fa-hooli fa-6x"></i>
                <h2>Bienvenue sur Hooli</h2>
                <h5>Trouvez de nouveaux lieux à découvrir</h5>
            </div>
            <div class="title">
                Inscription
            </div>
            <div class="form-group">
                <label for="email">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Votre email">
            </div>
            <div class="form-group">
                <label for="pseudo">Pseudo</label>
                <input type="text" class="form-control" name="pseudo" id="pseudo" placeholder="Votre pseudonyme">
            </div>
            <div class="form-group">
                <label for="password">Mot de passe</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Mot de passe">
            </div>
            <button type="submit" class="btn btn-danger">S'inscrire</button>
        </form>
        <form id="connexion"action="#" method="post">
            <div class="title">
                Connexion
            </div>
            <div class="form-group">
                <label for="pseudo-connexion">Pseudo</label>
                <input type="email" class="form-control" id="epseudo-connexion" aria-describedby="emailHelp" placeholder="Votre pseudonyme">
            </div>
            <div class="form-group">
                <label for="password-connexion">Mot de passe</label>
                <input type="password" class="form-control" id="password-connexion" placeholder="Mot de passe">
            </div>
            <button type="submit" class="btn btn-success">Se connecter</button>
        </form>
    </div>
</div>
@endsection