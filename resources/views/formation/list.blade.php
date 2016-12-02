@extends('layout.layout')
@section('title') Formations @endsection
@section('content')
<a href=""><img src="{{ URL::asset('img/back.png') }}" width="48" class="backLogo"></a>
<h1 style="padding:10px;display: inline;">FORMATIONS</h1>
<p style="margin-left:10px;"><a href="{{ route('logout') }}">Déconnexion ?</a></p>
<div class="search">
  <form class="" action="{{ URL::route('search') }}" method="post">
      <p style="display:inline;">Recherche: </p><input type="text" name="query" value="">
  </form>
</div>
@if (empty($formations))
    <p>Aucun post n'est disponible... Veuillez réessayer ultérieurement.</p>
@else
    @foreach ($formations as $formation)
        <div class="item">
            <a href="{{ route('formation.view', [$formation->id]) }}">
                <h4>{{ $formation->title }}</h4>
            </a>
        </div>
    @endforeach
@endif
@endsection
