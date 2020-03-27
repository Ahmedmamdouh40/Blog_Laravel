@extends('layouts.app')

@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


<form method="POST" action="{{route('posts.update',['post' => $post->id])}}">
    @csrf
    {{method_field('PUT')}}
    <div class="form-group">
      <label >Title</label>
      <input name="title" type="text" class="form-control" aria-describedby="emailHelp" value="{{$post->title}}">
    </div>
    <div class="form-group">
      <label for="exampleInputPassword1">Description</label>
      <textarea name="description" class="form-control">
      {{ $post->description }}
      </textarea>
    </div>

   
    <button type="submit" class="btn btn-primary">Update</button>
  </form>
@endsection