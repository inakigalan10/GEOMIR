@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ $post->id}}</div>
               <div class="card-body">
                   <table class="table">
                       <tbody>
                           
                           <tr>
                                <td scope="col">Body</td>
                                <td>{{ $post->body }}</td> 
                           </tr>
                          
                           <tr>
                                <td scope="col">Latitude</td>
                                <td>{{ $post->latitude }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">Longitude</td>
                                <td>{{ $post->longitude }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">Author:</td>
                                <td>{{ $user->name }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">File id:</td>
                                <td>{{ $post->file_id }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">img</td>
                                <td> <img class="img-fluid" src="{{asset('storage/'. $post->file->filepath)}}" /></td> 
                           </tr>
                           <tr>
                               <td>
                                   <form method="post" action="" enctype="multipart/form-data">
                                       @method('DELETE')
                                       @csrf
                                       <button type="submit" class="btn btn-primary">Delete</button>
                                       <a class="btn btn-primary" href="{{ route('posts.edit',$post) }}" role="button">Upadte</a>
                                       <a class="btn btn-primary" href="{{ url('/posts') }}" role="button">Index</a> 
                                    </form>
                                    
                                </td>
                           </tr>
                          

                       </tbody>
                   </table>
                   
               </div>
           </div>
       </div>
   </div>
</div>
@endsection