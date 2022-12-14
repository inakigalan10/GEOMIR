@extends('layouts.app')
 
 @section('content')
 <div class="container">
    <div class="row justify-content-center">
            <div class="post">
                <div>
                    <table class="post_table">
                        <thead>
                        <form method="post" id="create" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                         @csrf
                         @vite('resources/js/post/create_post.js')
                         <div id="upload" class="form-group">
                            <label for="file">Imagen:</label>
                             <input type="file" class="input_post" name="upload"/>
                             <div class="alert">  </div>
                         </div>
                         
                         <div id="latitude" class="form-group">
                             <label for="latitude">Latitude:</label>
                             <input type="string" class="input_post" name="latitude"/>
                             <div class="alert">  </div>


                        </div>
                        <div id="longitude" class="form-group">    
                            <label for="longitude">Longitude:</label>
                            <input type="string" class="input_post" name="longitude"/>
                            <div class="alert">  </div>
                        </div>
                        <div id="vidibility" class="form-group">    
                            <label for="visibility">Visibility: </label>
                            <select class="form-group" name="visibility" id="visibility_post_add">
                                <option value="">---------Seleciona una visiblidad para el post---------</option>
                                <option value="1">public</option>
                                <option value="2">contacts</option>
                                <option value="3">private</option>
                            </select>
                            <div class="alert">  </div>
                        </div>

                        <div id="body" class="form-group">
                             <label for="body">Descripcion:</label>
                             <textarea cols="30" rows="8" type="string" class="input_post" name="body"></textarea>
                             <div class="alert">  </div>
                       </div>

                         <br>
                         <button type="submit" class="btn btn-primary" >Create</button>
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
 