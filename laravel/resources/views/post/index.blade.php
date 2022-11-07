@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Post') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <td scope="col">ID</td>
                               <td scope="col">body</td>
                               <td scope="col">file_id</td>
                               <td scope="col">latitude</td>
                               <td scope="col">longitude</td>
                               <td scope="col">author id</td>
                               <td scope="col">created at</td>
                           </tr>
                       </thead>
                       <tbody>
                           @foreach ($posts as $post)
                           <tr>
                               <td>{{ $post->id }}</td>
                               <td>{{ $post->body }}</td>
                               <td>{{ $post->file_id }}</td>
                               <td>{{ $post->latitude }}</td>
                               <td>{{ $post->longitude }}</td>
                               <td>{{ $post->author_id }}</td>
                               <td>{{ $post->created_at }}</td>
                               <td><a class="btn btn-primary" href="{{ route ('posts.show', $post)}}"role="button">show</a></td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <a class="btn btn-primary" href="{{ route('posts.create') }}" role="button">Add new post</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
