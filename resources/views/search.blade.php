@extends('layout.layout')
@section('title') Formations @endsection
@section('content')
<h1 style="padding:10px;">RECHERCHE</h1>
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
