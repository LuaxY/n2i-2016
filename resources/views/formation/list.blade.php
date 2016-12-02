@extends('layout.layout')
@section('title') Formations @endsection
@section('content')
<h1 style="padding:10px;">FORMATIONS</h1>
@if (empty($formations))
    Aucun post n'est disponible... Veuillez réessayer ultérieurement.
@else
    @foreach ($formations as $array)
        <div class="item">
            <h4>{{ $array->title }}</h4>
        </div>
    @endforeach
@endif
@endsection