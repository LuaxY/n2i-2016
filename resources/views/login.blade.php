@extends('layout.layout')
@section('title') Connexion @endsection
@section('content')
<div class="container">
  <div class="cadre">
    <form method="POST" action="">
        <div class="row">
            <div class="center" style="margin-top:-20px;"><img src="{{ URL::asset('img/logo.png') }}" width="220"></div>
            <h3 class="center">Se connecter</h3>
            <div class="twelve columns">
                <label for="mailInput">Email</label>
                <input name="email" class="u-full-width" type="email" placeholder="email@operator.com" id="mailInput">
            </div>
            <div class="twelve columns">
                <label for="passwordInput">Mot de Passe</label>
                <input name="password" class="u-full-width" type="password" placeholder="*********" id="passwordInput">
            </div>
        </div>
        <div class="center" style="margin-top:35px;"><input type="submit" value="Connexion"></div>
        {{ csrf_field() }}
    </form>
    <div class="center"><p>Pas inscrit ? <a href="register">S'inscrire</a></p></div>
  </div>
</div>

<div class="footer">
  <div class="content">
    <h3>Partage de connaissance</h3>
  </div>
</div>
@endsection
