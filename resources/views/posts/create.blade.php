@extends('layouts/app')

@section('content')
    <h1>Create Post</h1>

    <form method="POST" action="{{ action('PostsController@store')}}" enctype="multipart/form-data">
        {{ csrf_field() }}

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" placeholder="post title"/>
        </div><br />
        <div class="form-group">
            <label for="body">Body</label>
            <textarea name="body" id="article-ckeditor" class="form-control" placeholder="project body"></textarea>
        </div>
        <div class="form-group">
            <input type="file" class="form-control-file" name="cover_image">
        </div>
        <div style="text-align:right; margin-bottom:1em;">
            <button type="submit" class="btn btn-primary">Create Post</button>
        </div>
    </form>

@endsection
