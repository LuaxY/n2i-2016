@extends('layout.layout')
@section('title') {{ $formation->title }} @endsection
@section('content')
    <div class="center"><h1 style="padding:10px;">{{ $formation->title }}</h1></div>
    <div class="itemArticle">
        {{ $formation->description }}
    </div>
@endsection