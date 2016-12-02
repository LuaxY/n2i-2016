@extends('layout.layout')
@section('title') {{ $page->formation()->first()->title }} : {{ $page->title }} @endsection
@section('content')
<a href="{{ route('formation.view', [$page->formation()->first()->id]) }}"><img src="{{ URL::asset('img/back.png') }}" width="48" class="backLogo"></a>
    <div class="center"><h1 style="padding:10px;">{{ $page->formation()->first()->title }} : {{ $page->title }}</h1></div>
    <div class="search">
        <form class="" action="{{ URL::route('search') }}" method="post">
            <p style="display:inline;">Recherche: </p><input type="text" name="query" value="">
        </form>
    </div>
    <div class="itemArticle">
        <iframe width="560" height="315" src="{{ $page->video_link }}" frameborder="0" allowfullscreen></iframe>
        <br>
        <a href="{{ route('page.forum', [0, $page->id]) }}"><button style="color:#fff">Réagir sur le forum</button></a>
        <br>
        {!! $page->text !!}
    </div>
@endsection
