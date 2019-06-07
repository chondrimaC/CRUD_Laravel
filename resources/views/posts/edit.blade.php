@extends('layouts/app')

@section('content')
    <h1>Edit Post</h1>

    <form method="POST" action="{{ action('PostsController@update', $posts->id)}}" enctype="multipart/form-data">
      @method('PATCH')
      {{ csrf_field() }}

      <div class="form-group">
        <label for="title">Title</label>
        <input type="text" name="title" class="form-control" value="{{$posts->title}}"/>
      </div><br />
      <div class="form-group">
        <label for="body">Body</label>
        <textarea name="body" id="article-ckeditor" class="form-control"> {{$posts->body}} </textarea>
      </div>
      <div class="form-group">
          <input type="file" class="form-control-file" name="cover_image">
      </div>
      <div style="margin-bottom:1em;">
        <button type="submit" class="btn btn-primary">Submit</button>
      </div>
    </form>



@endsection
