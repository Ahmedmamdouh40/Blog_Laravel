<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Post;
use App\User;
use App\Http\Resources\PostResource;


class PostController extends Controller
{
    public function index()
    {
        return PostResource::collection(
            Post::with('user')->paginate(10)
        );
    }

    public function show()
    {
        return new PostResource
        (
            Post::find(request()->post)
        );
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

        
    }
}
