@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ $file->filepath }}</div>
               <div class="card-body">
                   <table class="table">
                       <tbody>
                           
                           <tr>
                                <td scope="col">ID</td>
                                <td>{{ $file->id }}</td> 
                           </tr>
                          
                           <tr>
                                <td scope="col">Filesize</td>
                                <td>{{ $file->filesize }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">Created</td>
                                <td>{{ $file->created_at }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">Updated</td>
                                <td>{{ $file->updated_at }}</td> 
                           </tr>
                           <tr>
                                <td scope="col">img</td>
                                <td> <img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" /></td> 
                           </tr>
                           <tr>
                               <td>
                                   <form method="post" action="" enctype="multipart/form-data">
                                       @method('DELETE')
                                       @csrf
                                       <button type="submit" class="btn btn-primary">Delete</button>
                                       <a class="btn btn-primary" href="{{ route('files.edit',$file) }}" role="button">Upadte</a>
                                    </form>
                                   <a class="btn btn-primary" href="{{ url('/files') }}" role="button">Index</a>  
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
