@extends('layout.layout')
@section('title') {{ $topic->title }} @endsection
@section('content')
    <div class="center"><h1 style="padding:10px;">Forum</h1></div>
    <div class="search">
      <form class="" action="{{ URL::route('search') }}" method="post">
          <p style="display:inline;">Recherche: </p><input type="text" name="query" value="">
      </form>
    </div>
    <div class="itemArticle">
        Forum: {{ $topic->title }}
    </div>
    @foreach ($comments as $comment)
        <div class="item">
            {{ $comment->author()->first()->email }}: {{ $comment->text }}
        </div>
    @endforeach
    <br>
    <div align="center">
        <h4>Ajouter un message</h4>
        <textarea name="comment" rows="8" cols="80" style="height:200px"></textarea>
    </div>
@endsection