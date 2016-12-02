@extends('layout.layout')
@section('title') Connexion @endsection
@section('content')
<div class="header">
    <h1>CONNEXION AU PARTAGE</h1>
</div>
<div class="container">
    <form method="POST" action="">
        <div class="row">
            <h3 class="center">Se connecter</h3>
            <div class="twelve columns">
                <label for="mailInput">Email</label>
                <input class="u-full-width" type="email" placeholder="email@operator.com" id="mailInput">
            </div>
            <div class="twelve columns">
                <label for="passwordInput">Mot de Passe</label>
                <input class="u-full-width" type="password" placeholder="*********" id="passwordInput">
            </div>
        </div>
        <div class="center" style="margin-top:35px;"><input type="submit" value="Connexion"></div>
    </form>
</div>

<div class="footer">
    <p>test</p>
</div>
@endsection
