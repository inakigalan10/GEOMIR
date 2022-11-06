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
                        <form method="post" action="{{ route('post.store') }}" enctype="multipart/form-data">
                         @csrf
                         <div class="form-group">
                             
                             <input type="file" class="form-control" name="upload"/>
                         </div>
                         <div class="form-group">
                             <label for="upload">Body:</label>
                             <input type="string" class="form-control" name="body"/>
                         </div>
                         <div class="form-group">
                             <label for="upload">Latitude:</label>
                             <input type="string" class="form-control" name="latitude"/>
                         </div>
                         <div class="form-group">
                             <label for="upload">Longitude:</label>
                             <input type="string" class="form-control" name="longitude"/>
                         </div>
                         <br>
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
 