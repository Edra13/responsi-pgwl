@extends('layouts.template')

    @section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css">

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
    <div id="map"></div>

    <!-- Modal Create Point-->
    <div class="modal fade" id="PointModal" tabindex="-1" aria-labelledby="PointModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header bg-primary text-white">
            <h1 class="modal-title fs-5" id="PointModalLabel"><i class="fa-solid fa-map-pin"></i> Tambahkan Gangguan Lalu Lintas</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('store-point') }}" method="POST" enctype="multipart/form-data">
                @csrf <!--  security milik Laravel -->
                <div class="mb-3">
                <label for="name" class="form-label"><b>Gangguan/kejadian yang anda lihat atau alami</b></label>
                <input type="text" class="form-control" id="name" name = "name" placeholder="Isi tipe gangguan (misal. jalan rusak)">
                </div>
                <div class="mb-3">
                <label for="description" class="form-label"><b>Detail Kejadian</b></label>
                <textarea class="form-control" id="description" name = "description" rows="2" placeholder="(misal. terdapat lima lubang di jalan yang cukup besar)"></textarea>
                </div>
                <div class="mb-3">
                <label for="geom" class="form-label"><b>Koordinat Lokasi</b></label>
                <textarea class="form-control" id="geompoint" name = "geom" rows="1" readonly></textarea>
                </div>
                <div class="mb-3">
                <label for="image" class="form-label"><b>Unggah Foto</b></label>
                <input type="file" class="form-control" id="image_point" 
                name = "image" onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">
                </div>
                <div class="mb-3">
                    <img src="" alt= " Pratinjau" id="preview-image-point" 
                    class = "img-thumbnail" width="200">
                </div>
                <div class="modal-footer text-center py-2 bg-danger-subtle">
                <div class="container">
                    <div class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i><b> Laporan palsu akan ditindak sesuai UU ITE</b></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger">Laporkan</button>
            </form>
            </div>
        </div>
    </div>
    </div>

    <!-- Modal Create Polyline-->
    <!-- <div class="modal fade" id="PolylineModal" tabindex="-1" aria-labelledby="PolylineModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="PolylineModalLabel"><i class="fa-solid fa-chart-line"></i> Add Polyline</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('store-polyline') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="mb-3">
                <label for="name" class="form-label">Polyline Name</label>
                <input type="text" class="form-control" id="name" name = "name" placeholder="Fill with polyline name">
                </div>
                <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name = "description" rows="2"></textarea>
                </div>
                <div class="mb-3">
                <label for="geom" class="form-label">Geometry</label>
                <textarea class="form-control" id="geompolyline" name = "geom" rows="1" readonly></textarea>
                </div>
                <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image_polyline" 
                name = "image" onchange="document.getElementById('preview-image-polyline').src = window.URL.createObjectURL(this.files[0])">
                </div>
                <div class="mb-3">
                    <img src="" alt= "Preview" id="preview-image-polyline" 
                    class = "img-thumbnail" width="400">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Add Polyline</button>
            </form>
            </div>
        </div>
    </div>
    </div> -->

    <!-- Modal Create Polygon-->
    <!-- <div class="modal fade" id="PolygonModal" tabindex="-1" aria-labelledby="PolygonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="PolygonModalLabel"><i class="fa-solid fa-shapes"></i> Add Polygon</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('store-polygon') }}" method="POST" enctype="multipart/form-data">
                @csrf 
                <div class="mb-3">
                <label for="name" class="form-label">Polygon Name</label>
                <input type="text" class="form-control" id="name" name = "name" placeholder="Fill with polygon name">
                </div>
                <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name = "description" rows="2"></textarea>
                </div>
                <div class="mb-3">
                <label for="geom" class="form-label">Geometry</label>
                <textarea class="form-control" id="geompolygon" name = "geom" rows="3" readonly></textarea>
                </div>
                <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image_polygon" 
                name = "image" onchange="document.getElementById('preview-image-polygon').src = window.URL.createObjectURL(this.files[0])">
                </div>
                <div class="mb-3">
                    <img src="" alt= "Preview" id="preview-image-polygon" 
                    class = "img-thumbnail" width="400">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Add Polygon</button>
            </form>
            </div>
        </div>
    </div>
    </div> -->
    @endsection

    @section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://unpkg.com/terraformer@1.0.7/terraformer.js"></script>
    <script src="https://unpkg.com/terraformer-wkt-parser@1.1.2/terraformer-wkt-parser.js"></script>
    <script>
    var map = L.map('map').setView([-8.567987, 116.096130], 14);

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

    /* Digitize Function */
var drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);

var drawControl = new L.Control.Draw({
	draw: {
		position: 'topleft',
		polyline: true,
		polygon: false,
		rectangle: false,
		circle: false,
		marker: true,
		circlemarker: false
	},
	edit: false
});

map.addControl(drawControl);

map.on('draw:created', function(e) {
	var type = e.layerType,
		layer = e.layer;

     // Log the layer type to ensure it is being captured correctly
    console.log('Layer type:', type);

	console.log(type);

	var drawnJSONObject = layer.toGeoJSON();
	var objectGeometry = Terraformer.WKT.convert(drawnJSONObject.geometry);

	console.log(drawnJSONObject);
	console.log(objectGeometry);

	if (type === 'polyline') {
        // Set value geometry to input geom
        $("#geompolyline").val(objectGeometry);
        console.log('Showing PolylineModal');

        // Tambahkan alert untuk debugging
        alert('Showing PolylineModal');

        // Show Modal
        $("#PolylineModal").modal('show');
        console.log('__undefined__');

	} else if (type === 'polygon' || type === 'rectangle') {
         // Set value geometry to input geom
        $("#geompolygon").val(objectGeometry);

        // Show Modal
        $("#PolygonModal").modal('show');

	} else if (type === 'marker') {
		// Set value geomtery to input geom
        $("#geompoint").val(objectGeometry);

        // Show Modal
        $("#PointModal").modal('show');
	} else {
		console.log('__undefined__');
	}

	drawnItems.addLayer(layer);
});


    /* GeoJSON Point */

    var customIcon = L.icon({
            iconUrl: '{{ asset('storage/marker.png') }}', // Ganti dengan path ke ikon kustom Anda
            iconSize: [40], // Ukuran ikon
            iconAnchor: [16, 32], // Titik anchor (koordinat dalam ikon) untuk menentukan lokasi ikon di peta
            popupAnchor: [0, -32] // Titik anchor untuk menentukan lokasi popup di atas ikon
        });

        var point = L.geoJson(null, {
            onEachFeature: function (feature, layer) {
                var popupContent = `
                    <div class="text-center">
                        <h5 class="fw-bold">${feature.properties.name}</h5>
                        ${feature.properties.description ? `${feature.properties.description}` : ''}
                        <img src="{{ asset('storage/images/') }}/${feature.properties.image}" class="img-fluid img-thumbnail mt-2" alt="Image" style="width: 200px;">
                        <p class="mt-2">${feature.properties.created_at}</p> <!-- Tambahkan waktu pembuatan laporan -->
                        <div class="d-flex flex-row justify-content-end mt-2">
                            <a href="{{url('edit-point')}}/${feature.properties.id}" class="btn btn-sm btn-warning me-2">
                                <i class="fa-solid fa-edit"></i>
                            </a>
                            <form action="{{url('delete-point')}}/${feature.properties.id}" method="POST" class="d-inline">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger" onclick="return confirm('Hapus laporan ini?')">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                `;

                // Mengganti (") menjadi (') dalam script bootstrap agar tidak error
                // Perhatikan tanda petik

                layer.on({
                    click: function (e) {
                        layer.bindPopup(popupContent).openPopup();
                    },
                    mouseover: function (e) {
                        layer.bindTooltip(feature.properties.name);
                    },
                });
            },
            pointToLayer: function(feature, latlng) {
                return L.marker(latlng, {
                    icon: customIcon
                });
            }
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
            //             + "<br>" + 
                        
            //             "<div class='d-flex  flex-row justify-content-end mt-2'>" +

            //             "<a href = '{{url('edit-polyline')}}/" + feature.properties.id + "' class='btn btn-sm btn-warning me-2'><i class='fa-solid fa-edit'></i></a>" + 

            //             "<form action='{{url('delete-polyline')}}/" + feature.properties.id + "' method='POST'>" +
            //             '{{ csrf_field() }}' + 
            //             '{{ method_field('DELETE') }}' +
            //             "<button type='submit' class='btn btn-danger' onclick='return confirm(\"Delete this data?\")'><i class='fa-solid fa-trash-can'></i></button>" +
            //             "</form>"

            //             "</div>"
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
            //         + "<br>" + 
            //         "<div class='d-flex  flex-row justify-content-end mt-2'>" +

            //         "<a href = '{{url('edit-polygon')}}/" + feature.properties.id + "' class='btn btn-sm btn-warning me-2'><i class='fa-solid fa-edit'></i></a>" + 
                        
            //             "<form action='{{url('delete-polygon')}}/" + feature.properties.id + "' method='POST'>" +
            //             '{{ csrf_field() }}' + 
            //             '{{ method_field('DELETE') }}' +
            //             "<button type='submit' class='btn btn-danger' onclick='return confirm(\"Delete this data?\")'><i class='fa-solid fa-trash-can'></i></button>" +
            //             "</form>"

            //             "</div>"
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
    @endsection