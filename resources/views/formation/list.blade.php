@extends('layout.layout')
@section('title') Formations @endsection
@section('content')
<h1 style="padding:10px;">FORMATIONS</h1>
<form class="" action="{{ URL::route('search') }}" method="post">
    Recherche: <input type="text" name="query" value="">
</form>
<?php
  for ($i=0; $i < 5 ; $i++) {
    echo'
      <div class="item">
        <h4>FormationTitle'.$i.'</h4>
      </div>
    ';
  }
?>
@endsection
