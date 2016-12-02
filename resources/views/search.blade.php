@extends('layout.layout')
@section('title') Formations @endsection
@section('content')
<a href="{{ route('formation.list') }}"><img src="{{ URL::asset('img/back.png') }}" width="48" class="backLogo"></a>
<h1 style="padding:10px;display:inline;">RECHERCHE</h1>
<p style="margin-left:10px;"><a href="{{ route('logout') }}">Déconnexion ?</a></p>
<div class="search">
  <form class="" action="{{ URL::route('search') }}" method="post">
      <p style="display:inline;">Recherche: </p><input type="text" name="query" value="">
  </form>
</div>
@if (count($formations) <= 0 && count($pages) <= 0 && count($comments) <= 0)
    <p>Aucun post n'est disponible... Veuillez réessayer ultérieurement.</p>
@else
    @if (count($formations) > 0) <h3>Par Formations</h3> @endif
    @foreach ($formations as $formation)
        <div class="item">
            <a href="{{ route('formation.view', [$formation->id]) }}">
                <h4>{{ $formation->title }}</h4>
            </a>
        </div>
    @endforeach
    <br>
    @if (count($pages) > 0) <h3>Par Pages</h3> @endif
    @foreach ($pages as $page)
        <div class="item">
            <a href="{{ route('page.view', [0, $page->id]) }}">
                <h4>{{ $page->title }}</h4>
            </a>
        </div>
    @endforeach
    <br>
    @if (count($comments) > 0) <h3>Par Forums</h3> @endif
    @foreach ($comments as $comment)
        @if (isset($comment->formation_id))
        <div class="item">
            <a href="{{ route('formation.forum', [$comment->formation_id]) }}">
                <h4>{{ $comment->formation()->first()->title }}: {{ str_limit($comment->text, 25) }}...</h4>
            </a>
        </div>
        @else
        <div class="item">
            <a href="{{ route('page.forum', [0, $comment->page_id]) }}">
                <h4>{{ $comment->page()->first()->formation()->first()->title }} - {{ $comment->page()->first()->title }}: {{ str_limit($comment->text, 25) }}...</h4>
            </a>
        </div>
        @endif

    @endforeach
@endif
@endsection
