@extends('layouts.app')
 
 @section('content')
 <div class="container">
    <div class="row justify-content-center">
            <div class="post">
                <div>
                    <table class="post_table">
                        <thead>
                        <form method="post" id="create" action="{{ route('posts.update', $post) }}" enctype="multipart/form-data">
                         @csrf
                         @vite('resources/js/post/create_post.js')
                         @method('PUT')
                         <div id="upload" class="form-group">
                            <label for="file">Imagen:</label>
                             <input type="file" class="input_post" name="upload"  value="{{ asset('storage/{$file->filepath}') }}/>
                             <div class="alert">  </div>
                         </div>
                         
                         <div id="latitude" class="form-group">
                             <label for="latitude">Latitude:</label>
                             <input type="string" class="input_post" name="latitude" value='{{ $post->longitude }}'/>
                             <div class="alert">  </div>


                        </div>
                        <div id="longitude" class="form-group">    
                            <label for="longitude">Longitude:</label>
                            <input type="string" class="input_post" name="longitude"  value='{{ $post->longitude }}'/>
                            <div class="alert">  </div>
                        </div>
                        <div id="vidibility" class="form-group">    
                            <label for="visibility">Visibility: </label>
                            <select class="form-group" name="visibility" id="visibility_post_add">
                            @foreach(App\Models\Visibility::all() as $visibility)
                                @if($visibility->id == $post->visibility_id)
                                    <option value="{{ $visibility->id }}" selected>
                                        {{ __($visibility->name) }}
                                    </option>
                                @else
                                    <option value="{{ $visibility->id }}">
                                        {{ __($visibility->name) }}
                                    </option>
                                @endif
                            @endforeach
                            </select>
                            <div class="alert">  </div>
                        </div>

                        <div id="body" class="form-group">
                             <label for="body">Descripcion:</label>
                             <input type="string" class="input_post" name="body" value='{{ $post->body }}' />
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