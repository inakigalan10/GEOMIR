@extends('layouts.app')
 
@section('content')
@include('partials.menu')
    <a href="http://127.0.0.1:8000/" accesskey="F">Home</a>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>

<dic class="contacto">
    <video id="video_contacto" src="https://carontestudio.com/img/f4.mp4" autoplay="true" muted="true" loop="true" poster="https://carontestudio.com/img/contacto.jpg"></video>
    <div id="header_contacto">
        
        <div id="txt_video_contacto">
            <h1 class="titulo_contacto">Sección primera</h1>
            <h2 class="subtitulo_contacto">Sección segunda</h2>
            <h2 class="subtitulo_contacto">Sección tercera</h2>
        </div>
    </div>
    <div id="mapa_container">
        <div id="txt_mapa">
            <h1 class="titulo_mapa_contacto">Vols visitar-nos?</h1>
            <h2 class="subtitulo_mapa_contacto">Ubica'ns al mapa</h1>
        </div>
        <div id="map">
            
        </div>
    </div>
        <div id="footer_contacto">
            <div id="txt_footer_contacto">
                <h2>Segueix-nos a xarxes!</h2>
            </div>
            <div id="iconos_footer_contacto">
                <h2>Segueix-nos a xarxes!</h2>
            </div>  
        </div>
    </div>
</div>
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>

     <script>
var map = L.map('map').setView([41.2312199011308, 1.7280981210849504], 13);
var marker = L.marker([41.2312199011308, 1.7280981210849504]).addTo(map);
marker.bindPopup("<b>Estem aqui!!<br>").closePopup();


function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    console.log("Geolocation is not supported by this browser.");
  }
}
getLocation()

function showPosition(position) {
    var markerUser = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
    markerUser.bindPopup("<b>Tu estas aqui!!<br>").closePopup();
}


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);
</script> 
@endsection