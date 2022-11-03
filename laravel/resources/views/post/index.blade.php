@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Posts') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                           <tr>
                               <td scope="col">ID</td>
                               <td scope="col">body</td>
                               <td scope="col">file_id</td>
                               <td scope="col">latitude</td>
                               <td scope="col">longitude</td>
                               <td scope="col">author_id</td>
                               <td scope="col">crated_at</td>
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
                               <td>{{ $post->crated_at }}</td>
                               <td><a class="btn btn-primary" href=""role="button">show</a></td>
                           </tr>
                           @endforeach
                       </tbody>
                   </table>
                   <a class="btn btn-primary" href="" role="button">Add new post</a>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
