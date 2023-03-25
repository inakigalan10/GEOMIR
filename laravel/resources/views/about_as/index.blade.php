@extends('layouts.app')
 
@section('content')
@include('partials.menu')
    <div class="aboutAs" ondragover="allowDrop(event)" ondrop="drop(event)">
        
            <button type="button" class="cajaPersona btn btn-primary" id="persona1"  data-toggle="modal" data-target="#myModal" draggable="true" ondragstart="drag(event)">
                <div class="imagenPersona">
                        <img id="img1" src="https://media.sproutsocial.com/uploads/2022/06/profile-picture.jpeg" alt="">
                    </div>
                    <div class="infoPersona">
                        <div class="nombrePersona">
                                <h1>Iñaki Galan</h1>
                        </div>
                    <h2 id="puesto1">CEO</h2>
                    </div>
            </button>
       
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Vídeo de presentació</h5>
                        <button type="button" class="close btn btn-primary" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="carousel-container">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="9999999">
                        <!-- Slides -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <video src="/video/video1p1.mp4" muted controls alt="Diapositiva 1"></video>

                                </div>
                                <div class="carousel-item">
                                    <video src="/video/video2p1.mp4" controls alt="Diapositiva 2"></video>
                                </div>
                                <!-- Más diapositivas aquí -->
                            </div>
                        
                        <!-- Controles -->

                            <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>

                            <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <button type="button" class="cajaPersona btn btn-primary" id="persona2"  data-toggle="modal" data-target="#myModal2" draggable="true" ondragstart="drag(event)">
                <div class="imagenPersona">
                    <img id="img2" src="/img/aaronSeria.jpeg" alt="">
                </div>
                <div class="infoPersona">
                    <div class="nombrePersona">
                        <h1>Aaron Gonzalez</h1>
                    </div>
                    <h2 id="puesto2">CEO&#178</h2>
                </div>
        </button>

        <div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel">Vídeo de presentació</h5>
                        <button type="button" class="close btn btn-primary" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="carousel-container">
                        <div id="myCarousel2" class="carousel slide" data-ride="carousel" data-interval="9999999">
                        <!-- Slides -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <video src="/video/video1p2.mp4" muted controls alt="Diapositiva 1"></video>

                                </div>
                                <div class="carousel-item">
                                    <video src="/video/video2p2.mp4" controls alt="Diapositiva 2"></video>
                                </div>
                                <!-- Más diapositivas aquí -->
                            </div>
                        
                        <!-- Controles -->

                            <a class="carousel-control-prev" href="#myCarousel2" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Anterior</span>
                            </a>

                            <a class="carousel-control-next" href="#myCarousel2" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Siguiente</span>
                            </a>
                        
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>

    <script>
        const cajaPersona = document.getElementById("persona1");
        const audio = new Audio();

        audio.src = "/audio/audio1.mp3";

        cajaPersona.addEventListener("mouseenter", function() {
        audio.play();
        });

        cajaPersona.addEventListener("mouseleave", function() {
        audio.pause();
        });


        const cajaPersona2 = document.getElementById("persona2");
        const audio2 = new Audio();

        audio2.src = "/audio/audio2.mp3";

        cajaPersona2.addEventListener("mouseenter", function() {
        audio2.play();
        });

        cajaPersona2.addEventListener("mouseleave", function() {
        audio2.pause();
        });
    </script>

    <script>
    const videos = document.getElementsByTagName("video");
    const videos1 = [videos[0], videos[1]]
    const videos2 = [videos[2], videos[3]]
    const prevBtn = document.getElementsByClassName("carousel-control-prev")[0]
    const nextBtn = document.getElementsByClassName("carousel-control-next")[0]
    const prevBtn1 = document.getElementsByClassName("carousel-control-prev")[1]
    const nextBtn1 = document.getElementsByClassName("carousel-control-next")[1]
    var modal = document.querySelector('#myModal');
    var modal2 = document.querySelector('#myModal2');

    var cur = 0
    const max = videos1.length
    const max2 = videos2.length
    console.log("🎬 Total videos: " + (max+max2))
    
    const playVideos = function(){
    // Pause all videos
    for (v=0; v<max; v++) {
        videos1[v].pause();
    }
    // Play current video
    console.log("🎬 PLAY VIDEO " + cur)
    videos1[cur].play()
    }

    const playVideos2 = function(){
    // Pause all videos
    for (v=0; v<max2; v++) {
        videos2[v].pause();
    }
    // Play current video
    console.log("🎬 PLAY VIDEO " + cur)
    videos2[cur].play()
    }

    modal.addEventListener('hidden.bs.modal', function (e) {
        for (v=0; v<max; v++) {
            videos1[v].pause();
        }
    });


    modal2.addEventListener('hidden.bs.modal', function (e) {
        for (v=0; v<max2; v++) {
                videos2[v].pause();
        }
    });

    prevBtn.addEventListener("click", function(){
    cur = (cur-1 >= 0) ? cur-1 : max
    playVideos()
    })
    
    nextBtn.addEventListener("click", function(){
    cur = (cur+1 < max) ? cur+1 : 0
    playVideos()
    })

    prevBtn1.addEventListener("click", function(){
    cur = (cur-1 >= 0) ? cur-1 : max
    playVideos2()
    })
    
    nextBtn1.addEventListener("click", function(){
    cur = (cur+1 < max) ? cur+1 : 0
    playVideos2()
    })


</script>
<script>

    function drag(event) {
        event.stopPropagation();
        event.dataTransfer.setData("text", event.target.id);
        
    }

    function allowDrop(event) {
        event.stopPropagation();
        event.preventDefault();
    }

    function drop(event) {
        event.stopPropagation();
        var id = event.dataTransfer.getData("text");
        var elementoArrastrado = document.getElementById(id);
        event.target.appendChild(elementoArrastrado);
    }
    //funcion de cuando le das click suena el nombre y el puesto de la persona1  
    const miDiv = document.getElementById("persona1");
    miDiv.addEventListener("click", () => {
    const mensaje = new SpeechSynthesisUtterance("Iñaki Galan Puesto en la empressa CEO");
    window.speechSynthesis.speak(mensaje);
    });

    //funcion de cuando le das click suena el nombre y el puesto de la persona2  
    const miDiv2 = document.getElementById("persona2");
    miDiv2.addEventListener("click", () => {
    const mensaje = new SpeechSynthesisUtterance("Aaron Gonzalez Puesto en la empressa CEO");
    window.speechSynthesis.speak(mensaje);
    });

   
    //funcion de cuando le das al 4 suena toda la pagina 
    document.addEventListener("keypress", (event) => {
    if (event.key === "4") {
        const contenido = document.body.innerText;
        const mensaje = new SpeechSynthesisUtterance(contenido);
        window.speechSynthesis.speak(mensaje);
    }
    });

</script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection