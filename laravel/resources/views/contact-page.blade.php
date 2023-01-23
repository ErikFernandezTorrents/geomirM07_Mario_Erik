@extends('layouts.app')

@section('content')


<style>
    ::-webkit-scrollbar {
    display: none;
}
</style>
<div class="flex-contact">
    <div class="fondo-cont">
        <video src="./audio/videoContact.mp4" class="video-que-miras" autoplay="true" muted="true" loop="true"></video>
        <div class="texto-encima">Contacta amb Geo - Mir</div>
        <div class="texto-encima2">Envians un missatge</div>
        <button class="boton-contacto">Formulari de contacte</button>
    </div>
        
    <div class="mapa-contact">
        <iframe id="iframe" src="../my-app/index.html"></iframe>

    </div>

    <footer class="pie-pagina">
        <div class="grupo-1">
            <div class="box">
                <div class="logo-cont">
                    <img src="./images/logo_geomir.ico" alt="Logo de Geomir">
                </div>
            </div>
            <div class="box">
                <h2>Informació corporativa</h2>
                <p>Geolocalitza els teus amics, i llocs d'interès gràcies a les publicacions de la gent del teu volant.</p>
                <p><i class="bi bi-geo-alt"></i> Av. de Vilafranca del Penedès, 08800 Vilanova i la Geltrú, Barcelona</p>
            </div>
            <div class="box">
                <h2>Xarxes Socials</h2>
                <div class="red-social">
                    <a href="https://es-la.facebook.com"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com" ><i class="bi bi-instagram"></i></a>
                    <a href="https://twitter.com"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.witch.com"><i class="bi bi-twitch"></i></a>
                </div>
            </div>
        </div>
    </footer>
</div>
@endsection