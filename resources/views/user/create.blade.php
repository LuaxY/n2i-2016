<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Inscription</title>

    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('css/skeleton.css') }}" rel="stylesheet" type="text/css">
</head>
<body>
  <div class="header">
      <h1>INSCRIPTION AU PARTAGE</h1>
  </div>
  <div class="container">
    <div class="cadre">
      <form method="POST" action="">
          <div class="row">
              <div class="center" style="margin-top:-20px;"><img src="{{ URL::asset('img/logo.png') }}" width="220"></div>
              <h3 class="center">S'inscrire</h3>
              <div class="twelve columns">
                  <label for="mailInput">Email</label>
                  <input class="u-full-width" type="email" placeholder="email@operator.com" id="mailInput">
              </div>
              <div class="twelve columns">
                  <label for="passwordInput">Mot de Passe</label>
                  <input class="u-full-width" type="password" placeholder="*********" id="passwordInput">
              </div>
              <div class="twelve columns">
                  <label for="passwordInput">Confirmation Mot de Passe</label>
                  <input class="u-full-width" type="password" placeholder="*********" id="passwordInput">
              </div>
          </div>
          <div class="center" style="margin-top:35px;"><input type="submit" value="Connexion"></div>
      </form>
    </div>
  </div>

  <div class="footer">
    <div class="content">
      <h3>Partage de connaissance</h3>
      <ul>
        <li><a href="">Accueil</a></li>
        <li><a href="">Formation</a></li>
        <li><a href="">Déconnexion</a></li>
      </ul>
    </div>
  </div>
</body>
</html>
