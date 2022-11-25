<!--
@if ($errors->any())
<div class="alert alert-danger">
   <ul>
       @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
       @endforeach
   </ul>
</div>
@endif
-->

@extends('layouts.app')
 
@section('content')
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card">
               <div class="card-header">{{ __('Files') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                       <form id="create" method="post" action="{{ route('files.store') }}" enctype="multipart/form-data">
                        @csrf
                        @vite('resources/js/files/create.js')
                        <div class="form-group">
                            <label for="upload">File:</label>
                            <input type="file" class="form-control" name="upload"/>
                            
                            <div id ="alert">  
                                
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                        </form>
                       </thead>
                       
                   </table>
               </div>
           </div>
       </div>
   </div>
</div>
@endsection
