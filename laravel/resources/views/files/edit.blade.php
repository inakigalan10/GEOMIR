@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ $file->filepath }}</div>
               <div class="card-body">
               <table class="table">
                       <thead>
                       <form method="post" action="{{ route('files.update', $file) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="upload">File:</label>
                            <input type="file" class="form-control" name="upload"/>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>

                        </form>
                       </thead>
                       
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
