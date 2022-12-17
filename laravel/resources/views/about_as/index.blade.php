@extends('layouts.app')
 
@section('content')
@include('partials.menu')
    <div class="aboutAs">
        <div class="cajaPersona" id="persona1">
                <div class="imagenPersona">
                    <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg" alt="">
                </div>
                <div class="infoPersona">
                    <div class="nombrePersona">
                            <h1>Nombre1</h1>
                    </div>

                </div>
        </div>
        <div class="cajaPersona" id="persona2">
                <div class="imagenPersona">
                    <img src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg" alt="">
                </div>
                <div class="infoPersona">
                    <div class="nombrePersona">
                        <h1>Nomre2</h1>   
                    </div>

                </div>
        </div>
    </div>
@endsection
