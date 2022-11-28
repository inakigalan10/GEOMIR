@extends('layouts.app')
 
@section('content')
<a class="btn btn-primary" href="{{ route('places.create') }}" role="button">Add new place</a>
@foreach ($places as $place)
<div class="container">
   <div class="row justify-content-center">
       <div class="col-md-8">
           <div class="card_place">
               <div class="card-body">    
                    <div class="place_head">
                        <h3>{{ $place->name }}</h3>
                        <div class="con_icono_place">
                        <div class="contador_fav">
                                <p>{{$place->contador_fav()}}</p>
                        </div>
                        @if($place->comprobar_favorite())
                        <form method="post" action="{{route('place.favorite', $place)}}" enctype="multipart/form-data">
                            @csrf      
                            <div class ="item_post">
                                <button type="submit"><i class="fa-solid fa-star h5"></i></button>
                            </div>
                        </form>
                        @else
                        <form method="post" action="{{route('place.unfavorite', $place)}}" enctype="multipart/form-data">
                            @method('DELETE')
                            @csrf      
                            <div class ="item_post">
                                <button type="submit"><i class="fa-solid fa-star"></i></button>
                            </div>
                        </form>
                        @endif
                    </div>
                    </div>
                    <p>{{ $place->latitude }} {{ $place->longitude }}</p>
                        <div class="contenedor_imagenes">
                            <div>
                                <img class="img-fluid" src="{{ asset('storage/' . $place->file->filepath) }}" />
                            </div>
                            <div>
                                <img class="img-fluid" src="{{ asset('storage/' . $place->file->filepath) }}" />
                            </div>
                            <div>
                                <img class="img-fluid" src="{{ asset('storage/' . $place->file->filepath) }}" />
                            </div>
                            <div>
                                <img class="img-fluid" src="{{ asset('storage/' . $place->file->filepath) }}" />
                            </div>
                        </div>
                    
                    <div class="btn_show">
                        <a href="{{ route('places.show', $place) }}">Ver todas las publicaciones.</a>
                    </div>
               </div>
           </div>
       </div>
   </div>
</div>
@endforeach
@endsection
