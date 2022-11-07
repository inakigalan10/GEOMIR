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
               <div class="card-header">{{ __('Places') }}</div>
               <div class="card-body">
                   <table class="table">
                       <thead>
                       <form method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="upload">File:</label>
                            <input type="file" class="form-control" name="upload"/>
                            <label for="name">Name:</label>
                            <input type="txt" class="form-control" name="name"/>
                            <label for="description">Description:</label>
                            <input type="txt" class="form-control" name="description"/>
                            <label for="latitude">Latitude:</label>
                            <input type="number" class="form-control" name="latitude"/>
                            <label for="longitude">Longitude:</label>
                            <input type="number" class="form-control" name="longitude"/>
                            <label for="category_id">Category_id:</label>
                            <input type="number" class="form-control" name="category_id"/>
                            <label for="visibility_id">Visibility_id:</label>
                            <input type="number" class="form-control" name="visibility_id"/>
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
