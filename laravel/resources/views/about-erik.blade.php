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
        width: 30%;
        height: 35%;
        margin: 20px;
        border-radius: 6px;
        overflow: hidden;
        cursor: default;
        transition: all 400ms ease;

    }

    .card:hover{
        box-shadow: 5px 5px 20px black;
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
        height: 35%;
    }
</style>

<h1 id="h1About">Meet Geo-Mir team</h1>
<div class="divAbout">
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
        <div class="card">
            
            <!-- <audio id="mySoundClip"> autoplay -->
            <source src="../audio/PUNTO40.wav" type="audio/wav">
            <div class="contenedor-imagenes">
                <a type="button"data-bs-toggle="modal" data-bs-target="#exampleModalCenter">
                    <div class="fotoSeria"></div>
                </a>
            </div>
            <div class="contenido">
                <h2>Erik Fernandez</h2>
                <button class="cargo"></button>
                
            </div>
        </div>
        <div class="card">
            <div class="contenedor-imagenes">
                <div class="fotoSeria"></div>
                
            </div>
            <div class="contenido">
                <h2>Erik Fernandez</h2>
                <button class="cargo"></button>
                <a href="#">Vídeo</a>

            </div>
        </div>
    </div>
</div>
<script> 
    var audio = $("#mySoundClip")[0];
    $("div .card").mouseenter(function() {
        audio.pause();
    });
    
</script>
@endsection