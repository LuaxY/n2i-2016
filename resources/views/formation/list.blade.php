@extends('layout.layout')
@section('title') Formations @endsection
@section('content')
<h1 style="padding:10px;">FORMATIONS</h1>
<div class="search">
  <form class="" action="{{ URL::route('search') }}" method="post">
      <p style="display:inline;">Recherche: </p><input type="text" name="query" value="">
  </form>
</div>
@if (empty($formations))
    Aucun post n'est disponible... Veuillez réessayer ultérieurement.
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
