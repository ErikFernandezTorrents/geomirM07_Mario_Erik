@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="crossorigin=""/>

<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
crossorigin=""></script>

<style>
    ::-webkit-scrollbar {
        display: none;
    
    }
   
</style>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.2.2/dist/ol.js"></script>
<div class="flex-contact">
    <div class="fondo-cont">
        <video src="./audio/videoContact.mp4" class="video-que-miras" autoplay="true" muted="true" loop="true"></video>
        <div class="texto-encima">Contacta amb Geo - Mir</div>
        <div class="texto-encima2">Envians un missatge</div>
        <button class="boton-contacto">Formulari de contacte</button>
    </div>

    <div class="mapa-Contacto">
        <div id="map">
            <script>
                
                var map = L.map('map').setView([41.231391, 1.728118],17);
                L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                }).addTo(map);
                var marker = L.marker([41.231391, 1.728118]).addTo(map);
                var circle = L.circle([41.231391, 1.728118], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: 200
                }).addTo(map);
                

                marker.bindPopup("<b>Seu de Geo-Mir</b>").openPopup();
                circle.bindPopup("Area propera a nosaltres");
                var popup = L.popup()
                    .setLatLng([41.231391, 1.728118])
                    .setContent("Localitazió de la nostra seu")
                    .openOn(map);

                navigator.geolocation.getCurrentPosition(showPosition);
                function showPosition(position)
                {
                    var marker = L.marker([position.coords.latitude, position.coords.longitude]).addTo(map);
                    var popup = L.popup()
                    .setLatLng([position.coords.latitude, position.coords.longitude])
                    .setContent("Tu ets aquí!!")
                    .openOn(map);
                
                }
                
                key('ctrl+alt+c', function(){ alert('stopped reload!'); return false });
                
            </script>
        </div>
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