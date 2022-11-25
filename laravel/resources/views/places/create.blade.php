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
                       <form id="create" method="post" action="{{ route('places.store') }}" enctype="multipart/form-data">
                        @csrf
                        @vite('resources/js/places/create.js')

                        <div class="form-group">

                            <div id="upload">
                                <label for="upload">File:</label>
                                <input type="file" class="form-control" name="upload"/>
                                <div class="alert"></div>
                            </div>  

                            <div id="name">
                                <label for="name">Name:</label>
                                <input type="txt" class="form-control" name="name"/>
                                <div class="alert"></div>
                            </div>

                            <div id="description">
                                <label for="description">Description:</label>
                                <input type="txt" class="form-control" name="description"/>
                                <div class="alert"></div>
                            </div>

                            <div id="latitude">
                                <label for="latitude">Latitude:</label>
                                <input type="number" class="form-control" name="latitude"/>
                                <div class="alert"></div>
                            </div>

                            <div id="longitude">
                                <label for="longitude">Longitude:</label>
                                <input type="number" class="form-control" name="longitude"/>
                                <div class="alert"></div>
                            </div>
                            
                            <div id="category_id">
                                <label for="category_id">Category_id:</label>
                                <input type="number" class="form-control" name="category_id"/>
                                <div class="alert"></div>
                            </div>

                            <div id="visibility_id">
                                <label for="visibility_id">Visibility_id:</label>
                                <input type="number" class="form-control" name="visibility_id"/>
                                <div class="alert">   </div>
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
