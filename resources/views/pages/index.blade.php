@extends('layouts/app')

@section('content')
  <div class="jumbotron text-center">
    <h1>{{ $title }}</h1>
    <p>
      This is a laravel application from 'laravel from scratch youtube'.
    </p>
    <p>
      <a class="btn btn-primary btn-lg" href="#" role="button">Login</a>
      <a class="btn btn-success btn-lg" href="#" role="button">Register</a>
    </p>

  </div>
@endsection
