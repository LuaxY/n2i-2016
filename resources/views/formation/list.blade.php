@extends('layout.layout')
@section('title') Formations @endsection
@section('content')
<h1 style="padding:10px;">FORMATIONS</h1>
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
