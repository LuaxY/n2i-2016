@extends('layout.layout')
@section('title') Formations @endsection
@section('content')
<h1 style="padding:10px;">FORMATIONS</h1>
<form class="" action="{{ URL::route('search') }}" method="post">
    Recherche: <input type="text" name="query" value="">
</form>
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