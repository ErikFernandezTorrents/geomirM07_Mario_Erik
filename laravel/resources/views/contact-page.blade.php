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
    <button class="w3-btn w3-blue w3-round" onclick=getLocation()>Try It</button>
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
             
                function getLocation()
                {
                    if (navigator.geolocation)
                        {
                            navigator.geolocation.getCurrentPosition(showPosition,showError);
                        }
                    else{x.innerHTML="Geolocation is not supported by this browser.";}
                }
                marker.bindPopup("<b>Seu de Geo-Mir</b>").openPopup();
                circle.bindPopup("Area propera a nosaltres");
                var popup = L.popup()
                    .setLatLng([41.231391, 1.728118])
                    .setContent("Localitazió de la nostra seu")
                    .openOn(map);

                function showPosition(position)
                {
                    var lat=position.coords.latitude;
                    var lon=position.coords.longitude;
                    var latlon=(lat, lon)
                    var mapholder=document.getElementById('map')
                    mapholder.style.height='250px';
                    mapholder.style.width='100%';

                    var myOptions={
                        center:latlon,zoom:14,
                        mapTypeId:map.MapTypeId.ROADMAP,
                        mapTypeControl:false,
                        navigationControlOptions:{style:map.NavigationControlStyle.SMALL}
                    };
                    var map=new map.Map(document.getElementById("map"),myOptions);
                    var marker=new map.Marker({position:latlon,map:map,title:"You are here!"});
                
                }
                
                function showError(error)
                {
                    switch(error.code) 
                        {
                        case error.PERMISSION_DENIED:
                        x.innerHTML="User denied the request for Geolocation."
                        break;
                        case error.POSITION_UNAVAILABLE:
                        x.innerHTML="Location information is unavailable."
                        break;
                        case error.TIMEOUT:
                        x.innerHTML="The request to get user location timed out."
                        break;
                        case error.UNKNOWN_ERROR:
                        x.innerHTML="An unknown error occurred."
                        break;
                        }
                }
                
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