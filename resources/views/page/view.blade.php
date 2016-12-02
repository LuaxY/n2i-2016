@extends('layout.layout')
@section('title') {{ $formation->title }} : {{ $page->title }} @endsection
@section('content')
    <div class="center"><h1 style="padding:10px;">{{ $formation->title }} : {{ $page->title }}</h1></div>
    <div class="search">
        <form class="" action="{{ URL::route('search') }}" method="post">
            <p style="display:inline;">Recherche: </p><input type="text" name="query" value="">
        </form>
    </div>
    <div class="itemArticle">
        <iframe width="560" height="315" src="{{ $page->video_link }}" frameborder="0" allowfullscreen></iframe>
        <br>
        <a href="{{ route('page.forum', [0, $formation->id]) }}"><button style="color:#fff">Réagir sur le forum</button></a>
        <br>
        {!! $page->text !!}
    </div>
@endsection
