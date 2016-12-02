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
                <div style="text-align:center; margin-top:10px;">
                  <a href=""><img src="{{ URL::asset('img/android.png') }}" style="margin-right:20px;"></a>
                  <a href=""><img src="{{ URL::asset('img/win.png') }}"></a>
                </div>
            </div>
            <div class="six columns">
                <a href="{{ route('formation.list') }}"><div class="homebox"><p>Plateforme - <span class="colorB">Partage de connaissances</span></p></div></a>
                <div style="text-align:center; margin-top:10px;">
                  <a href=""><img src="{{ URL::asset('img/android.png') }}" style="margin-right:20px;"></a>
                  <a href=""><img src="{{ URL::asset('img/win.png') }}"></a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer">
        <div class="content">
            <h3>Accueil - I'm Human</h3>
        </div>
    </div>
@endsection
