@extends('masterLogout')

@section('content')
<div class="row" id="login">
    <div class="col-md-6 offset-md-3">
        <form id="inscription">
            <div id="title">
                <i class="fab fa-hooli fa-6x"></i>
                <h2>Bienvenue sur Hooli</h2>
                <h5>Trouvez de nouveaux lieux à découvrir</h5>
            </div>
            <div class="title">
                Inscription
            </div>
            <div class="form-group">
                <label for="email-inscription">E-mail</label>
                <input type="email" class="form-control" id="email-inscription" aria-describedby="emailHelp" placeholder="Votre email">
            </div>
            <div class="form-group">
                <label for="password-inscription">Mot de passe</label>
                <input type="password" class="form-control" id="password-inscription" placeholder="Mot de passe">
            </div>
            <button type="submit" class="btn btn-danger">S'inscrire</button>
        </form>
        <form id="connexion">
            <div class="title">
                Connexion
            </div>
            <div class="form-group">
                <label for="email-connexion">E-mail</label>
                <input type="email" class="form-control" id="email-connexion" aria-describedby="emailHelp" placeholder="Votre email">
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