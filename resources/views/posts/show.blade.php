@extends('layouts/app')

@section('content')
    <a href="{{url('/posts')}}" class="btn btn-primary" style="margin-bottom:1em;">Go back</a>
    <div class="jumbotron">
        <h1>{{ $posts->title }}</h1>
        <img style="width:80%;" src="{{ url('/storage/cover_image/' . $posts->cover_image) }}">
        <div>
            <p>
                {!! $posts->body !!}
            </p>
        </div>
        <hr />
        <small> Written on : {{ $posts->created_at }} by {{ $posts->user->name }}</small>
    </div>

    <hr />

<!-- /****** only logged in user can see this part -->

    @if (!Auth::guest())

    {{-- /****** User can only see his own post *******/ --}}
        @if (Auth::user()->id == $posts->user_id)
            <a href="{{ url('/posts/' . $posts->id . '/edit')}}" class="btn btn-primary"> Edit </a>

            <form method="POST" action="{{ action('PostsController@destroy', $posts->id) }}" class="delete_form">
                @method('DELETE')
                @csrf
                <div class="form-group">
                    <div class="" style="text-align:right;">
                        <button type="submit" class="btn btn-danger">Delete Post</button>
                    </div>
                </div>
            </form>
        @endif
    @endif

    <script>
        $(document).ready(function(){
            $('.delete_form').on('submit', function(){
                if (confirm("Are you sure you want to delete?"))
                {
                    return true;
                }
                else {
                    return false;
                }
            });
        });
    </script>

@endsection
