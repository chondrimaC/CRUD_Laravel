@extends('layouts/app')

@section('content')
  <h1>Posts</h1>

  @if (count($posts) > 0)
    @foreach ($posts as $post)
      <div class="card bg-light m-3 p-3">
        <div class="card-block">
            <div class="row">
                <div class="col-md-3">
                    <img style="width:100%; height:100px;" src="{{url('/storage/cover_image/' . $post->cover_image)}}">
                </div>
                <div class="col-md-9">
                    <h3 class="card-title"><a href="{{ url('/posts/' . $post->id) }}"> {{ $post->title }} </a></h3>
                    <small class="card-text"> Written on : {{ $post->created_at }} by {{ $post->user->name}}</small>
                </div>
            </div>
        </div>
      </div>
    @endforeach

    {{$posts->links()}}

  @else
    <p>
      No post found!
    </p>

  @endif

@endsection
