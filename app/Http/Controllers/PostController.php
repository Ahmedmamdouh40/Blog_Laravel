<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts= Post::all();
        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        //get the request data
       

         $request->validate([
            'title' => 'required|unique:posts|min:3',
            'description' => 'required|min:10',
         ],
        ['title.required'=> 'Write a TITLE',
         'title.min' => 'Title is too short',
         'description.required'=> 'Write a Description',
         'description.min' => 'Description is too short',
        ]);

        //store the request data in the db
        Post::create(request()->all());

        //redirect to /posts
        return redirect()->route('posts.index');
    }

    public function show()
    {
        $request = request();
        $postId = $request->post;
        $post = Post::find($postId);
        
        return view('posts.show',[
            'post' => $post,
        ]);
    }


    public function destroy()
    {
        $request = request();
        $postId = $request->post;
        Post::where('id', $postId)->delete();
        
        return redirect()->route('posts.index');
    }

    public function edit()
    {
        $request = request();
        $postId = $request->post;
        $post = Post::find($postId);
        
        return view('posts.edit',[
            'post' => $post,
        ]);
    }


    public function update($postId)
    {
        request()->validate([
            'title' => 'required|min:3',
            'description' => 'required|min:10'
        ],
        ['title.required'=> 'Write a TITLE',
         'title.min' => 'Title is too short',
         'description.required'=> 'Write a Description',
         'description.min' => 'Description is too short',
        ]);
        Post::where('id', $postId)->first()->update(request()->all());
        
        return redirect()->route('posts.index');
    }

}
