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
            <button class="button_contacte">
                <h1>Envianos un formulario para contactarnos</h1>
            </button>
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
                <div>
                    <i class="fa-brands fa-instagram" ></i>
                </div>
                <div>
                    <i class="fa-brands fa-facebook"></i>
                </div>
                <div>
                    <i class="fa-brands fa-linkedin-in"></i>
                </div>
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


// Verifica si el navegador soporta el reconocimiento de voz
if ('webkitSpeechRecognition' in window) {
  // Crea un objeto de reconocimiento de voz
  const recognition = new webkitSpeechRecognition();
  // Establece el idioma del reconocimiento de voz en español de España
  recognition.lang = 'es-ES';

  // Cuando se recibe un resultado del reconocimiento de voz
  recognition.onresult = function(event) {
    // Obtiene la transcripción del primer resultado
    const result = event.results[0][0].transcript;
    console.log(result);
    // Si la transcripción incluye las palabras "bajar" o "abajo", hace un scroll hacia abajo
    if (result.includes('bajar') || result.includes('abajo')) {
      window.scrollBy(0, 100);
    // Si la transcripción incluye las palabras "subir" o "arriba", hace un scroll hacia arriba
    } else if (result.includes('subir') || result.includes('arriba')) {
      window.scrollBy(0, -100);
    // Si la transcripción incluye las palabras "ampliar", "aumentar" o "acercar", aumenta el zoom del cuerpo del documento al 150%
    } else if (result.includes('ampliar') || result.includes('aumentar') || result.includes('acercar')) {
      document.body.style.zoom = '150%';
    // Si la transcripción incluye las palabras "reducir", "disminuir" o "alejar", disminuye el zoom del cuerpo del documento al 50%
    } else if (result.includes('reducir') || result.includes('disminuir') || result.includes('alejar')) {
      document.body.style.zoom = '50%';
    // Si la transcripción incluye las palabras "restaurar", "inicial" o "inicio", establece el zoom del cuerpo del documento al 100% y hace scroll hasta arriba
    } else if (result.includes('restaurar') || result.includes('inicial') || result.includes('inicio')) {
      document.body.style.zoom = '100%';
      window.scrollTo(0, 0);
    }
  }

  // Cuando ocurre un error en el reconocimiento de voz
  recognition.onerror = function(event) {
    console.error(event.error);
  }

  // Cuando termina el reconocimiento de voz
  recognition.onend = function() {
    console.log('Speech recognition ended.');
  }

  // Función para iniciar el reconocimiento de voz cuando se presiona Alt + S
  const startRecognition = function() {
    recognition.start();
    console.log('Speech recognition started.');
  }

  // Escucha el evento de teclado para iniciar el reconocimiento de voz cuando se presiona Alt + S
  document.addEventListener('keydown', function(event) {
    if (event.code === 'KeyS' && event.altKey) {
      startRecognition();
    }
  });
} else {
  console.log('Speech recognition not supported.');
}

</script> 
@endsection
