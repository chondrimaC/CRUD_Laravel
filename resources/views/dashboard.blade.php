@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <a href="{{url('/posts/create')}}" class="btn btn-primary" style="margin-bottom:1em;">Create Post</a>
                    <h3>Your Blog Posts</h3>

                    @if (count($posts) > 0)
                      <table class="table">
                          <thead>
                            <tr>
                              <th scope="col">Title</th>
                              <th scope="col"></th>
                              <th scope="col"></th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach ($posts as $post)
                              <tr>
                                <td>{{ $post->title }}</td>
                                <td><a href="{{ url('/posts/' . $post->id . '/edit')}}" class="btn btn-link">Edit</a></td>
                                <td>
                                  <form method="POST" action="{{ action('PostsController@destroy', $post->id) }}" class="delete_form">
                                    @method('DELETE')
                                    @csrf
                                      <div class="form-group">
                                        <div class="" style="text-align:right;">
                                          <button type="submit" class="btn btn-link">Delete Post</button>
                                        </div>
                                      </div>
                                  </form>
                                </td>
                              </tr>
                            @endforeach
                          </tbody>
                      </table>
                    @else
                      <p>
                        You have no post!
                      </p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>

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
