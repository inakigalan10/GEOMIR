@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ $place->name }}</div>
               <div class="card-body">
                   <table class="table">
                       <tbody>
                           
                           <tr>
                                <td scope="col">ID:</td>
                                <td>{{ $place->id }}</td> 
                           </tr>
                          
                           <tr>
                                <td scope="col">Description:</td>
                                <td>{{ $place->description }}</td> 
                           </tr>
                           <tr>
                            <tr>
                                <td scope="col">Author:</td>
                                <td>{{ $user->name }}</td> 
                           </tr>
                                <td scope="col">Created:</td>
                                <td>{{ $place->created_at }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">Updated:</td>
                                <td>{{ $place->updated_at }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">img:</td>
                                <td> <img class="img-fluid" src="{{ asset('storage/{$file->filepath}') }}" /></td> 
                           </tr>
                           <tr>
                               <td>
                                   <form method="post" action="" enctype="multipart/form-data">
                                       @method('DELETE')
                                       @csrf
                                       <button type="submit" class="btn btn-primary">Delete</button>
                                       <a class="btn btn-primary" href="{{ route('places.edit',$place) }}" role="button">Upadte</a>
                                       <a class="btn btn-primary" href="{{ url('/places') }}" role="button">Index</a> 
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
