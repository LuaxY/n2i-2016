@extends('layout.layout')
@section('title') {{ $formation->title }} @endsection
@section('content')
    <div class="center"><h1 style="padding:10px;">{{ $formation->title }}</h1></div>
    <div class="search">
      <form class="" action="{{ URL::route('search') }}" method="post">
          <p style="display:inline;">Recherche: </p><input type="text" name="query" value="">
      </form>
    </div>
    <div class="itemArticle">
        {{ $formation->description }}
    </div>
    @foreach ($formation->pages()->get() as $page)
        <div class="item">
            <a href="{{ route('page.view', [$formation->id, $page->id]) }}">
                <h4>{{ $page->title }}</h4>
            </a>
        </div>
    @endforeach
@endsection
