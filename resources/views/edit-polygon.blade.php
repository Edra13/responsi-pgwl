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

    <!-- Modal Create Polygon-->
    <div class="modal fade" id="PolygonModal" tabindex="-1" aria-labelledby="PolygonModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h1 class="modal-title fs-5" id="PolygonModalLabel"><i class="fa-solid fa-map-pin"></i> Edit Polygon</h1>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form action="{{ route('update-polygon', $id) }}" method="POST" enctype="multipart/form-data">
                @csrf <!--  security milik Laravel -->
                @method('PATCH')
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
                <textarea class="form-control" id="geompolygon" name = "geom" rows="1" readonly></textarea>
                </div>
                <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image_polygon" 
                name = "image" onchange="document.getElementById('preview-image-polygon').src = window.URL.createObjectURL(this.files[0])">

                <input type="hidden" class="form-control" id="image_old" name = "image_old">
                </div>
                <div class="mb-3">
                    <img src="" alt= "Preview" id="preview-image-polygon" 
                    class = "img-thumbnail" width="200">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-success">Update Polygon</button>
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
    var map = L.map('map').setView([51.505, -0.09], 14);

    // Basemap
    L.tileLayer('https://tiles.stadiamaps.com/tiles/alidade_smooth/{z}/{x}/{y}{r}.{ext}', {
	minZoom: 0,
	maxZoom: 20,
	attribution: '&copy; <a href="https://www.stadiamaps.com/" target="_blank">Stadia Maps</a> &copy; <a href="https://openmaptiles.org/" target="_blank">OpenMapTiles</a> &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
	ext: 'png'
}).addTo(map);;

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
        $('#geompolygon').val(wkt);
        $('#image_old').val(layer.feature.properties.image);
        $('#preview-image-polygon').attr('src', "{{ asset('storage/images/') }}" + "/" + layer.feature.properties.image);
        $('#PolygonModal').modal('show');
    })

    // console.log(geojson);
    //fungsi console pada javascript seperti dd (debug and die php)
});

    /* GeoJSON Polygon */
			var polygon = L.geoJson(null, {
				onEachFeature: function (feature, layer) {

                    drawnItems.addLayer(layer);

					var popupContent = 
                    "<h3>" + feature.properties.name + "</h3>" + "" +
                        "Description:" + feature.properties.description + "<br>" +
                        "Foto: <br><img src='{{ asset('storage/images/') }}/" + feature.properties.image + "' class='img-thumbnail' alt='...' style='width: 400px;'>"
                        ;

                        //mengganti (") menjadi (') dalam script bootstrap agar tidak error
                        //perhatikan tanda petik

					layer.on({
						click: function (e) {
							polygon.bindPopup(popupContent);
						},
						mouseover: function (e) {
							polygon.bindTooltip(feature.properties.name);
						},
					});
				},
			});
			$.getJSON("{{route('api.polygon', $id)}}", function (data) {
				polygon.addData(data);
				map.addLayer(polygon);
                map.fitBounds(polygon.getBounds());
			});

            // Layer Control 
            var overlayMaps = {
                "Polygons": polygon
            };

            var layerControl = L.control.layers(null, overlayMaps, {collapsed: false}).addTo(map);

    </script>
    @endsection