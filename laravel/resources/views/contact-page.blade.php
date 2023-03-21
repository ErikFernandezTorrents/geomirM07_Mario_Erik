@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css"
     integrity="sha256-kLaT2GOSpHechhsozzB+flnD+zUyjE2LlfWPgU04xyI="
     crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"
     integrity="sha256-WBkoXOwTeyKclOHuWtc+i2uENFpDZ9YPdf5Hf+D7ewM="
     crossorigin=""></script>

<style>
    ::-webkit-scrollbar {
        display: none;
    
    }
   
</style>
<script src="https://cdn.jsdelivr.net/npm/ol@v7.2.2/dist/ol.js"></script>
<div class="contacto-flex">
    <div class="contenedor-fondo">
        <video src="./audio/videoContact.mp4" class="video" autoplay="true" muted="true" loop="true"></video>
        <div class="texto-arriba">Contacta amb Geo - Mir</div>
        <div class="texto-arriba2">Envians un missatge</div>
        <button class="boton-contacto">Formulari de contacte</button>
        <button class="boton-contacto" id ="botonVoz"><i class="bi bi-mic"></i></button>
        <div id="diagnostic"></div>
    </div>
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
                
            </script>
        </div>

    <footer class="pie-de-pagina">
        <div class="grupo-3">
            <div class="box">
                <div class="contenedor-logo">
                    <img src="./images/logo_geomir.ico" alt="Logo de Geomir">
                </div>
            </div>
            <div class="caja">
                <h2>Informació corporativa</h2>
                <p>Geolocalitza els teus amics, i llocs d'interès gràcies a les publicacions de la gent del teu volant.</p>
                <p><i class="bi bi-geo-alt"></i> Av. de Vilafranca del Penedès, 08800 Vilanova i la Geltrú, Barcelona</p>
            </div>
            <div class="caja">
                <h2>Xarxes Socials</h2>
                <div class="red-social">
                    <a href="https://es-la.facebook.com"><i class="bi bi-facebook"></i></a>
                    <a href="https://www.instagram.com" ><i class="bi bi-instagram"></i></a>
                    <a href="https://twitter.com"><i class="bi bi-twitter"></i></a>
                    <a href="https://www.twitch.com"><i class="bi bi-twitch"></i></a>
                </div>
            </div>
        </div>
        <a href="https://www.w3.org/WAI/WCAG2A-Conformance" title="Explanation of WCAG 2 Level A Conformance">
                <img height="32" width="88"src="https://www.w3.org/WAI/WCAG21/wcag2.1A-v" alt="Level A conformance,W3C WAI Web Content Accessibility Guidelines 2.1">
        </a>
    </footer>
    <script>
        var boton = document.getElementById('botonVoz');
        var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
        var SpeechGrammarList = SpeechGrammarList || window.webkitSpeechGrammarList
        var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent

        var palabras = ["sube","baja","zoom","baja zoom"];

        var recognition = new SpeechRecognition();
        if (SpeechGrammarList) {
            var speechRecognitionList = new SpeechGrammarList();
            var grammar = '#JSGF V1.0; grammar palabras; public <palabra> = ' + palabras.join(' | ') + ' ;'
            speechRecognitionList.addFromString(grammar, 1);
            recognition.grammars = speechRecognitionList;
        }
        recognition.continuous = false;
        recognition.lang = 'es-ES';
        recognition.interimResults = false;
        recognition.maxAlternatives = 1;

        boton.addEventListener("click",function() {
            recognition.start();
            console.log("Listo para recibir órdenes.");
        });

        recognition.onresult = function(event) {
            var palabra = event.results[0][0].transcript;
            var diagnostic = document.getElementById('diagnostic'); // variable diagnostic definida
            diagnostic.textContent = 'Resultado recibido: ' + palabra + '.';
            console.log('Confianza: ' + event.results[0][0].confidence);
            
            if (palabra.toLowerCase() === "sube") {
                window.scrollBy(0, -window.innerHeight);
            } else if (palabra.toLowerCase() === "baja") {
                window.scrollBy(0, window.innerHeight);
            } else if (palabra.toLowerCase() === "zoom") {
                var match = document.body.style.transform.match(/scale\((.*?)\)/);
                var zoom = match ? parseFloat(match[1]) : 1;
                document.body.style.transform = `scale(${zoom + 0.1})`;
            } else if (palabra.toLowerCase() === "baja zoom") {
                var match = document.body.style.transform.match(/scale\((.*?)\)/);
                var zoom = match ? parseFloat(match[1]) : 1;
                document.body.style.transform = `scale(${zoom - 0.1})`;
            }
        };

        recognition.onnomatch = function(event) {
            var diagnostic = document.getElementById('diagnostic'); // variable diagnostic definida
            diagnostic.textContent = "No puedo reconocer esa palabra.";
        };

        recognition.onerror = function(event) {
            var diagnostic = document.getElementById('diagnostic'); // variable diagnostic definida
            diagnostic.textContent = 'Ha ocurrido un error en el reconocimiento: ' + event.error;
        };

        document.addEventListener('keydown', function(event) {
        // Combinación de teclas: Ctrl + Alt + R (82 en ASCII)
        if (event.ctrlKey && event.altKey && event.keyCode === 82) {
            // Restaurar scroll
            window.scrollTo(0, 0);
            // Restaurar zoom
            document.body.style.transform = 'scale(1)';
        }
        });

    </script>
</div>
@endsection