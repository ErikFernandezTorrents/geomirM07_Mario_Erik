@extends('layouts.app')
@section('content')
<style>
    .divAbout{
    display: flex;
    align-items: center;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 15vh;
    
    }

    .container{
        display: flex;
        width: 100%;
        justify-content: space-between;
        

    }
    .contenido{
        display: flex;
        flex-direction: column;
    }
    .card{
        width: 40vh;
        height: 35% !important;
        margin: 20px;
        border-radius: 6px;
        overflow: hidden;
        cursor: default;
        transition: all 400ms ease;

    }

    .card:hover{
        box-shadow: 5px 5px 20px #694abb;
        transform: translateY(-4%);
    }

    .card .contenido{
        padding: 15px;
        text-align: center;
    }

    .container .contenido h2{
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-weight:bold ;
        margin-bottom: 4%;
    }

    .container .contenido a{
        text-decoration: none;
        display: inline-block;
        padding: 3%;
        margin-top: 3%;
        color: black;
        border-radius: 4px;
        transition: all 400ms ease;

    }

    .container .contenido a:hover{
        background-color: #1f9eff;
        color: white;

    }

    .contenedor-imagenes{
        position: relative;
        height: 35vh;
        cursor: pointer;
    }

    .contenedor-imagenes div{
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .fotoSeria{
        background-image: url(../images/ErikSerio.jpg);
        background-size: 100% 100%;
        filter: grayscale(100%);
        transition: transform .3s;
    }
    .fotoSeria:hover{

        background-image: url(../images/ErikDiber.jpeg);
        background-size: 100% 100%;
        filter:contrast(150%);
        transition:.3s;
        transform: rotate(360deg);

    }

    .fotoSeriaMario{
        background-image: url(../images/MarioSerio.jpeg);
        background-size: 100% 100%;
        filter: grayscale(100%);
        transition: transform .3s;
    }
    .fotoSeriaMario:hover{

        background-image: url(../images/MarioDiber.jpeg);
        background-size: 100% 100%;
        filter:contrast(100%);
        transition:.3s;
        transform: rotate(360deg);

    }

    .cargo{

        padding: 1.5rem 5rem;
        background-color: #e6e5db;
        border: 0;
        cursor: default;
        position: relative;
        overflow: hidden;
    }

    .cargo::before{
        content: 'Web devoloper';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: grey;
        transition: .3s ease;
        
    }

    .cargo::after{
        content: 'Veure pelis';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        color: grey;
        transition: .2s ease;
        opacity: 0;
    }

    .cargo2::after{
        content: 'Jugar a futbol';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        color: grey;
        transition: .2s ease;
        opacity: 0;
    }

    .cargo:hover::before{
        transform: translate(-50%, -50%) scale(3);
        opacity: 0;    
    }

    .cargo:hover::after{
        transform: translate(-50%, -50%) scale(1);
        opacity: 1;    
    }
    #h1About{
        margin-top:3%;
        text-align:center;
        font-family: 'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
        font-weight:bold ;
        color:#694abb;
    }
    #mySoundClip{
        height: 100px !important;
        display: block !important;
    }
</style>

<h1 id="h1About">Meet Geo-Mir team</h1>
<div class="divAbout">
    <!-- Erik -->
    <div class="container">
        <div class="modal fade" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Video presentació</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"  aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <video width="500" height="300"  controls autoplay muted>
                                    <source src="../audio/video1.mp4" type="video/mp4">
                                    
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="carousel-item">
                                <video width="500" height="300"  controls muted>
                                    <source src="../audio/video1.mp4" type="video/mp4"> 
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
        <!-- Mario -->
        <div class="modal fade" id="exampleModalCenter2" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Video presentació</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="carouselExampleIndicators2" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide-to="0" class="active"  aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <video width="500" height="300"  controls autoplay muted>
                                    <source src="../audio/videoMario.mp4" type="video/mp4">
                                    
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                            <div class="carousel-item">
                                <video width="500" height="300"  controls muted>
                                    <source src="../audio/videoMario2.mp4" type="video/mp4"> 
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators2" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
                </div>
            </div>
        </div>
        <div id="div1" draggable="true" class="card"> 
            <div class="contenedor-imagenes">
                <a type="button"data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                    <div class="fotoSeria">
                        <audio id="mySoundClip">
                            <source src="../audio/PUNTO40.wav" type="audio/wav">
                        </audio>
                    </div>
                </a>
            </div>
            <div class="contenido">
                <h2>Erik Fernandez</h2>
                <button class="cargo"></button>
            </div>
        </div>
        <div id="div2" draggable="true" class="card cardaudio">
            <div class="contenedor-imagenes">
                <a type="button"data-bs-toggle="modal" data-bs-target="#exampleModalCenter2">
                    <div class="fotoSeriaMario">
                        <audio id="mySoundClip2">
                            <source src="../audio/SelfLove.wav" type="audio/wav">
                        </audio>
                    </div>
                </a>
            </div>
            <div class="contenido">
                <h2>Mario Estarlich</h2>
                <button class="cargo2 cargo"></button>
            </div>
        </div>
    </div>
</div>
<script>

    var myDiv = document.querySelector('.card');
    var myDiv2 = document.querySelector('.cardaudio');

    // Crear un nuevo objeto Audio
    var audio = document.getElementById('mySoundClip');
    var audio2 = document.getElementById('mySoundClip2');

    // Agregar un manejador de evento mouseover al div
    myDiv.addEventListener('mouseover', function() {
        // Reproducir el sonido
        audio.play();
    });

    myDiv2.addEventListener('mouseover', function() {
        // Reproducir el sonido
        audio2.play();
    });

    myDiv.addEventListener('mouseout', function() {
        // Reproducir el sonido
        audio.pause();
    });

    myDiv2.addEventListener('mouseout', function() {
        // Reproducir el sonido
        audio2.pause();
    });

    var div1 = document.getElementById("div1");
    var div2 = document.getElementById("div2");

    div1.addEventListener("dragstart", dragStart);
    div2.addEventListener("dragstart", dragStart);

    div1.addEventListener("dragover", dragOver);
    div2.addEventListener("dragover", dragOver);

    div1.addEventListener("drop", drop);
    div2.addEventListener("drop", drop);

    function dragStart(event) {
        event.dataTransfer.setData("divID", event.target.id);
    }
    function dragOver(event) {
        event.preventDefault();
    }

    function drop(event) {
        var data = event.dataTransfer.getData("divID");
        event.target.appendChild(document.getElementById(data));
    }
</script>
@endsection