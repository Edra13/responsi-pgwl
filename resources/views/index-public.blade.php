@extends('layouts.template')

    @section('styles')
        <style>
            html, body { 
                height: 100%; 
                width: 100%; 
                margin: 0;
            }
            #map { 
                height: calc(100vh - 56px);
                width: 100%; 
                margin: 0;
            }
            /* .nav-link i, .navbar-brand i {
                margin-right: 10px;  */
                /* Memberikan jarak antara ikon di navbar dengan label */
            /* } */
        </style>
    @endsection

    @section('content')

	 <!-- Toast Notification -->
	 <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="myToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header bg-primary text-white">
                <img src="{{ asset('storage/logo1.png') }}" class="rounded me-2" alt="..." width="40px">
                <strong class="me-auto">Mataram Traffic Aware</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body text-center">
                Selamat Datang! Silahkan Login untuk melaporkan gangguan lalu lintas di lokasi anda!
            </div>
        </div>
    </div>

    <div id="map"></div>

    @endsection

    @section('script')
    <script>
    var map = L.map('map').setView([-8.587801, 116.110949], 14);

    // Basemap layers
    var stadiaMaps = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
            minZoom: 0,
            maxZoom: 20,
            attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            ext: 'png'
        }).addTo(map);

        var stadiaAlidadeSatellite = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_satellite/{z}/{x}/{y}{r}.{ext}', {
            minZoom: 0,
            maxZoom: 20,
            attribution: '&copy; CNES, Distribution Airbus DS, © Airbus DS, © PlanetObserver (Contains Copernicus Data) | &copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            ext: 'jpg'
        });

        // Layer control
        var baseMaps = {
            "Stadia Maps": stadiaMaps,
            "Stadia Alidade Satellite": stadiaAlidadeSatellite
        };

        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);

     /* GeoJSON Point */

     var customIcon = L.icon({
    iconUrl: 'storage/marker.png', // Ganti dengan path ke ikon kustom Anda
    iconSize: [40], // Ukuran ikon [lebar, tinggi]
    iconAnchor: [20, 40], // Titik anchor (koordinat dalam ikon) untuk menentukan lokasi ikon di peta
    popupAnchor: [0, -40] // Titik anchor untuk menentukan lokasi popup di atas ikon
});

var point = L.geoJson(null, {
    pointToLayer: function(feature, latlng) {
        return L.marker(latlng, {
            icon: customIcon
        });
    }
});

        // Ambil data GeoJSON dari URL atau sumber lainnya
        $.getJSON("{{route('api.points')}}", function (data) {
            point.addData(data);

            // Tambahkan event click untuk menampilkan popup
            point.on('click', function (e) {
                var feature = e.layer.feature;
                var popupContent = `
                    <div class="text-center">
                        <h5 class="fw-bold">${feature.properties.name}</h5>
                        ${feature.properties.description ? `${feature.properties.description}` : ''}
                        <p><img src="{{ asset('storage/images/') }}/${feature.properties.image}" class="img-fluid img-thumbnail mt-2" alt="Image" style="width: 200px;"> </p>
                        <p class="mt-2 text-bs-tertiary-color"><b>${feature.properties.created_at}</b></p> <!-- Tambahkan waktu pembuatan laporan -->
                        <div class="d-flex flex-row justify-content-end mt-2">
                        </div>
                    </div>
                `;

                e.layer.bindPopup(popupContent).openPopup();
            });

            map.addLayer(point);
        });

                // Ambil data GeoJSON dari URL atau sumber lainnya
                $.getJSON("{{route('api.points')}}", function (data) {
                    point.addData(data);
                    map.addLayer(point);
                });


    /* GeoJSON Polyline */
			// var polyline = L.geoJson(null, {
			// 	onEachFeature: function (feature, layer) {
			// 		var popupContent = "Name: " + feature.properties.name + "<br>" +
            //             "Description: " + feature.properties.description + "<br>" +
            //             "<img src='{{ asset('storage/images/') }}/" + feature.properties.image + "' class='img-thumbnail' alt='...' style='width: 200px;'>"
                
            //             ;
			// 		layer.on({
			// 			click: function (e) {
			// 				polyline.bindPopup(popupContent);
			// 			},
			// 			mouseover: function (e) {
			// 				polyline.bindTooltip(feature.properties.name);
			// 			},
			// 		});
			// 	},
			// });
			// $.getJSON("{{route('api.polylines')}}", function (data) {
			// 	polyline.addData(data);
			// 	map.addLayer(polyline);
			// });


    /* GeoJSON Polygon */
			// var polygon = L.geoJson(null, {
			// 	onEachFeature: function (feature, layer) {
			// 		var popupContent = "Name: " + feature.properties.name + "<br>" +
            //         "Description: " + feature.properties.description + "<br>" +
            //         "<img src='{{ asset('storage/images/') }}/" + feature.properties.image + "' class='img-thumbnail' alt='...' style='width: 200px;'>"
                
            //         ;
			// 		layer.on({
			// 			click: function (e) {
			// 				polygon.bindPopup(popupContent);
			// 			},
			// 			mouseover: function (e) {
			// 				polygon.bindTooltip(feature.properties.name);
			// 			},
			// 		});
			// 	},
			// });
			// $.getJSON("{{route('api.polygons')}}", function (data) {
			// 	polygon.addData(data);
			// 	map.addLayer(polygon);
			// });

            // Layer Control 
            var overlayMaps = {
				"Titik Gangguan Lalu Lintas": point,
                // "Polylines": polyline,
                // "Polygons": polygon
            };

            var layerControl = L.control.layers(null, overlayMaps, {collapsed: false}).addTo(map);
    </script>

	<script>
        document.addEventListener('DOMContentLoaded', function () {
            var toastEl = document.getElementById('myToast');
            var toast = new bootstrap.Toast(toastEl);
            toast.show();
        });
    </script>

    @endsection