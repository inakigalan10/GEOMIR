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
                        @if(empty(comprobar_favorite($place))))
                            <form method="post" action="{{route('place.favorite', $place)}}" enctype="multipart/form-data">
                                @csrf      
                                <div class ="item_post">
                                    <button type="submit"><i class="fa-solid fa-star h4"></i></button>
                                </div>
                            </form>
                        @else
                            <form method="delete" action="" enctype="multipart/form-data">
                                @csrf      
                                <div class ="item_post">
                                    <button type="submit"><i class="fa-solid fa-star"></i></button>
                                </div>
                            </form>
                        @endif
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
