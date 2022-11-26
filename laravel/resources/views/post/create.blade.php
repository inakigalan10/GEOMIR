@extends('layouts.app')
 
 @section('content')
 <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Post') }}</div>
                <div class="card-body">
                    <table class="post_table">
                        <thead>
                        <form method="post" id="create" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                         @csrf
                         @vite('resources/js/post/create_post.js')
                         <div id="upload" class="form-group">
                             <input type="file" class="form-control" name="upload"/>
                             <div class="alert">  </div>
                         </div>
                         <div id="body" class="form-group">
                             <label for="body">Body:</label>
                             <input type="string" class="form-control" name="body"/>
                             <div class="alert">  </div>
                       </div>
                         <div id="latitude" class="form-group">
                             <label for="latitude">Latitude:</label>
                             <input type="string" class="form-control" name="latitude"/>
                             <div class="alert">  </div>


                        </div>
                         <div id="longitude" class="form-group">    
                             <label for="longitude">Longitude:</label>
                             <input type="string" class="form-control" name="longitude"/>
                             <div class="alert">  </div>
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
 