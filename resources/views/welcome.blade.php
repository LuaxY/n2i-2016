@extends('layout.layout')
@section('title') Accueil @endsection
@section('content')
    <div class="headWelcome">
        <h1>Welcome Human !</h1>
        <br />
        <p>Choose your tools.</p>
    </div>
    <div class="container">
        <div class="row">
            <div class="six columns">
                <a href="{{ route('formation.list') }}"><div class="homebox"><p>Service - <span class="colorB">WeeCop</span></p></div></a>
            </div>
            <div class="six columns">
                <a href="{{ route('formation.list') }}"><div class="homebox"><p>Plateforme - <span class="colorB">Partage de connaissances</span></p></div></a>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="content">
            <h3>Accueil - I'm Human</h3>
        </div>
    </div>
@endsection
