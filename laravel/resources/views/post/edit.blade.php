@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ $post->id}}</div>
               <div class="card-body">
               <table class="table">
                       <thead>
                       <form method="post" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="upload">File:</label>
                            <input type="file" class="form-control" name="upload" value="{{ asset('storage/{$file->filepath}') }}"/>
                            <label for="name">Body:</label>
                            <input type="txt" class="form-control" name="body" value='{{ $post->body }}' />
                            <label for="latitude">Latitude:</label>
                            <input type="number" class="form-control" name="latitude" value='{{ $post->latitude }}' />
                            <label for="longitude">Longitude:</label>
                            <input type="number" class="form-control" name="longitude" value='{{ $post->longitude }}'/>
                            
                        </div>
                        <button type="submit" class="btn btn-primary">Edit</button>
                        </form>
                       </thead>
                       
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
