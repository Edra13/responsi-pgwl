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
            <h1 class="modal-title fs-5" id="PointModalLabel"><i class="fa-solid fa-map-pin"></i> Edit Laporan</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('update-point', $id) }}" method="POST" enctype="multipart/form-data">
                @csrf <!--  security milik Laravel -->
                @method('PATCH')
                <div class="mb-3">
                <label for="name" class="form-label"><b>Gangguan/kejadian yang anda lihat atau alami</b></label>
                <input type="text" class="form-control" id="name" name = "name" placeholder="">
                </div>
                <div class="mb-3">
                <label for="description" class="form-label"><b>Detail Kejadian</b></label>
                <textarea class="form-control" id="description" name = "description" rows="2"></textarea>
                </div>
                <div class="mb-3">
                <label for="geom" class="form-label"><b>Koordinat Lokasi</b></label>
                <textarea class="form-control" id="geompoint" name = "geom" rows="1" readonly></textarea>
                </div>
                <div class="mb-3">
                <label for="image" class="form-label"><b>Foto</b></label>
                <input type="file" class="form-control" id="image_point" 
                name = "image" onchange="document.getElementById('preview-image-point').src = window.URL.createObjectURL(this.files[0])">

                <input type="hidden" class="form-control" id="image_old" name = "image_old">
                </div>
                <div class="mb-3">
                    <img src="" alt= "Preview" id="preview-image-point" 
                    class = "img-thumbnail" width="200">
                </div>
                <div class="modal-footer text-center py-2 bg-danger-subtle">
                <div class="container">
                    <div class="text-danger"><i class="fa-solid fa-triangle-exclamation"></i><b> Laporan palsu akan ditindak sesuai UU ITE</b></div>
                </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-success">Perbarui Laporan</button>
            </form>
            </div>
        </div>
    </div>
    </div>
    
    @endsection

    @section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
    <script src="https://unpkg.com/@terraformer/wkt"></script>

    <script>
    var map = L.map('map').setView([-8.567987, 116.096130], 14);

    // Basemap layers
        var stadiaMaps = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
            minZoom: 0,
            maxZoom: 20,
            attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            ext: 'png'
        });

        var stadiaAlidadeSatellite = L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_satellite/{z}/{x}/{y}{r}.{ext}', {
            minZoom: 0,
            maxZoom: 20,
            attribution: '&copy; CNES, Distribution Airbus DS, © Airbus DS, © PlanetObserver (Contains Copernicus Data) | &copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            ext: 'jpg'
        });

        // Tambahkan peta Alidade Satellite terlebih dahulu
        stadiaAlidadeSatellite.addTo(map);

        // Layer control
        var baseMaps = {
            "Stadia Alidade Satellite": stadiaAlidadeSatellite,
            "Stadia Maps": stadiaMaps,
        };

        L.control.layers(baseMaps, null, { position: 'topright' }).addTo(map);



    /* Digitize Function */
var drawnItems = new L.FeatureGroup();
map.addLayer(drawnItems);

var drawControl = new L.Control.Draw({
	draw: {
		position: 'topleft',
		polyline: false,
		polygon: false,
		rectangle: false,
		circle: false,
		marker: false,
		circlemarker: false
	},
    edit: {
        featureGroup: drawnItems,
	edit: true,
    remove: false
    }
});

map.addControl(drawControl);

map.on('draw:edited', function(e) {
    var layer = e.layers;

layer.eachLayer(function(layer) {
    var geojson = layer.toGeoJSON();

    var wkt = Terraformer.geojsonToWKT(geojson.geometry);

    // console.log(wkt);

        $('#name').val(layer.feature.properties.name);
        $('#description').val(layer.feature.properties.description);
        $('#geompoint').val(wkt);
        $('#image_old').val(layer.feature.properties.image);
        $('#preview-image-point').attr('src', "{{ asset('storage/images/') }}" + "/" + layer.feature.properties.image);
        $('#PointModal').modal('show');
    })

    // console.log(geojson);
    //fungsi console pada javascript seperti dd (debug and die php)
});

    /* GeoJSON Point */
			var point = L.geoJson(null, {
				onEachFeature: function (feature, layer) {

                    drawnItems.addLayer(layer);

                    var popupContent = `
                    <div class="text-center">
                    <h5 class="fw-bold">${feature.properties.name}</h5>
                    ${feature.properties.description ? `${feature.properties.description}` : ''}
                    <img src="{{ asset('storage/images/') }}/${feature.properties.image}" class="img-fluid img-thumbnail mt-2" alt="Image" style="width: 200px;">
                    <p class="mt-2">${feature.properties.created_at}</p>
                </div>
                `;

					// var popupContent = 
                    // "<h3>" + feature.properties.name + "</h3>" + "" +
                    //     "Description:" + feature.properties.description + "<br>" +
                    //     "Foto: <br><img src='{{ asset('storage/images/') }}/" + feature.properties.image + "' class='img-thumbnail' alt='...' style='width: 400px;'>"
                    //     ;

                        //mengganti (") menjadi (') dalam script bootstrap agar tidak error
                        //perhatikan tanda petik

					layer.on({
						click: function (e) {
							point.bindPopup(popupContent);
						},
						mouseover: function (e) {
							point.bindTooltip(feature.properties.name);
						},
					});
				},
			});
			$.getJSON("{{route('api.point', $id)}}", function (data) {
				point.addData(data);
				map.addLayer(point);
                map.fitBounds(point.getBounds());
			});

            // Layer Control 
            var overlayMaps = {
                "Points": point
            };

            var layerControl = L.control.layers(null, overlayMaps, {collapsed: false}).addTo(map);

    </script>
    @endsection