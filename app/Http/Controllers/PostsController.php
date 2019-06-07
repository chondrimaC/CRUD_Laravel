<?php

namespace blo\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use blo\Post;
use DB;

class PostsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $posts = Post::all();
        // $posts = Post::where('title','Post One')->get();
        // $posts = Post::orderBy('title','desc')->get();
        // $posts = DB::select('SELECT * FROM posts');

        $posts = Post::orderBy('created_at','desc')->paginate(2);
        return view('posts/index')->with('posts', $posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          'title' => 'required',
          'body' => 'required',
          'cover_image' => 'image|nullable|max:1999'
        ]);

        //************ Handle File upload ********************/
        if ($request->hasFile('cover_image')) {
            //Get Filename with Extension
            $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
            //Get just Filename
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            //Get just Extension
            $extension = $request->file('cover_image')->GetClientOriginalExtension();
            //Filename to Store
            $filenameToStore = $filename . '_' . time() . '.' . $extension;
            //Upload Image
            $path = $request->file('cover_image')->storeAs('public/cover_image', $filenameToStore);
        }
        else {
            $filenameToStore = "no_image.jpg";
        }

        $post = new Post;
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->cover_image = $filenameToStore;
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect('/posts')->with('success', 'Post created');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $posts = Post::find($id);
        return view('posts/show')->with('posts', $posts);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $posts = Post::find($id);

      /********** Check for correct user *********/
      if (auth()->user()->id !== $posts->user_id) {
          return redirect('/posts')->with('error', 'Unauthorized Post');
      }
      return view('posts/edit')->with('posts', $posts);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $this->validate($request, [
        'title' => 'required',
        'body' => 'required',
        'cover_image' => 'image|nullable|max:1999'
      ]);

      //************ Handle File upload ********************/
      if ($request->hasFile('cover_image')) {
          //Get Filename with Extension
          $filenameWithExt = $request->file('cover_image')->getClientOriginalName();
          //Get just Filename
          $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
          //Get just Extension
          $extension = $request->file('cover_image')->GetClientOriginalExtension();
          //Filename to Store
          $filenameToStore = $filename . '_' . time() . '.' . $extension;
          //Upload Image
          $path = $request->file('cover_image')->storeAs('public/cover_image', $filenameToStore);
      }

      $post = Post::find($id);
      $post->title = $request->input('title');
      $post->body = $request->input('body');
      if ($request->hasFile('cover_image'))
      {
          if ($post->cover_image != 'no_image.jpg')
          {
            Storage::delete('public/cover_image/'. $post->cover_image);
          }
          $post->cover_image = $filenameToStore;

      }
      $post->save();

      $posts = Post::find($id);

      // return redirect('/posts')->with('success' , 'Post updated');
      // return view('/posts/show')->with(['success' => 'Post updated','posts' => $posts]);
       // return view('/posts/show')->with(['posts' => $posts]);
       return redirect()->action('PostsController@show', $posts->id)->with('success' , 'Post updated');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      $post = Post::find($id);

      /********** Check for correct user *********/
      if (auth()->user()->id !== $post->user_id) {
          return redirect('/posts')->with('error', 'Unauthorized Post');
      }

      if ($post->cover_image != 'no_image.jpg') {
          // delete image
          Storage::delete('public/cover_image/' . $post->cover_image);
      }
      $post->delete();
      return redirect('/posts')->with('success' , 'Post deleted');
    }
}
