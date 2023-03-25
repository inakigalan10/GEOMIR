@extends('layouts.app')
 
@section('content')
@include('partials.menu')
<div class="container">
   
               @foreach ($posts as $post)
                <div class="feed">
                    <div class="caja_post">
                        <div class="cabecera_post">
                            <div class="usuario_post">
                            @if(!empty($post->file->filepath))   
                                <img src="https://plantillasdememes.com/img/plantillas/imagen-no-disponible01601774755.jpg" alt=""> 
                            @else
                                <img src="perfil.png" alt="">
                            @endif     
                            
                            <p>{{ $post->user->name }}</p></div>
                            @if(auth()->user()->id == $post->author_id){
                                <p >@include('partials.show-post')</p>
                            }
                            @endif
                            @if(auth()->user()->role == "1"){
                               <p>post: {{ $post->id}}</p>
                            }
                            @endif
                            
                            <div class="info_post">
                                <div class ="ubicacion_post"><p>{{ $post->latitude }}, {{ $post->longitude }}</p></div>
                                <div class ="fecha_post"><p>{{ $post->created_at }}</p></div>
                            </div>
                            
                        </div> 
                        <div class="img_post"> 
                            @foreach($files as $file)
                                @if($file->id == $post->file_id)   
                                    <img class="img-fluid" src="{{ asset("storage/{$file->filepath}") }}" />
                                
                                @endif 

                            @endforeach                                          
                        </div>
                        <div class="info_post">
                        <div class ="cont_icono_post">
                        <div>
                            <p>{{$post->contador_like()}}</p>
                        </div>
                            @if($post->comprobar_like())
                            <form action="{{route('post.like', $post)}}" method="post" enctype="multipart/form-data">
                                @csrf       
                                <div class ="item_post">
                                    <button type="submit" >
                                        
                                        <i class="fa-regular fa-heart"></i>
                                    </button>
                                </div>
                            </form>
                            @else
                            <form action="{{route('post.unlike', $post)}}" method="post" enctype="multipart/form-data">
                                @method('DELETE')
                                @csrf       
                                <div class ="item_post">
                                    <input type="submit" > <i class="fa-solid fa-heart"></i> </imput>
                                </div>
                            </form>
                            @endif
                            </div>
                            <div class ="item_post"><button><i class="fa-solid fa-comment"></i></button></a></div>
                            <div class="item_post"><button><i class="fa-solid fa-share-nodes"></i></button></div>
                        </div>
                        <div class="descripcion_post"><p>{{ $post->body }}</p></div>
                            <div class="caja_comentarios_post">
                            @if(!empty($post->file->filepath))   
                                <img src="https://plantillasdememes.com/img/plantillas/imagen-no-disponible01601774755.jpg" alt=""> 
                            @else
                                <img src="perfil.png" alt="">
                            @endif         
                            
                            <p>comentarios_post</p></div>
                            <div class="enlace_comenatrios_post"><a href="#">enlace_comenatrios_post</a></div>
                        
                        <div class="add_comentarios_post">
                            <div class="input_add_comentario_post"><input type="text" placeholder="Añade un comentario"></div>
                            
                            <div class="boton_add_comentario_post"><a href="#">añadir</a></div>
                        </div>
                    </div>
                </div>
                @endforeach
                <div class="add_btn">
                    @include('partials.add-post')
                </div>        

   </div>
</div>
@endsection
