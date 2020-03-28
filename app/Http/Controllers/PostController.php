<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\User;

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
        $users = User::all();
        
        return view('posts.create', [
            'users' => $users
        ]);
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


        //validate request user is in database users
        $users = User::all();
        foreach($users as $user){
            $users_id[]= $user->id;
        }

        $user_id=request()->user_id;
        
        if(in_array($user_id , $users_id)){

        //store the request data in the GET
        Post::create(request()->all());

        }
        else dd("ya 7ramy ya les");

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
