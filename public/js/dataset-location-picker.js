mapboxgl.accessToken = 'pk.eyJ1IjoiamFzZW1rIiwiYSI6ImNqcmM2MGx3bDE3MTY0NGw4MHdpMGJtOTEifQ.q78vPOJ29YoFwpVZoFAlfQ';
var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/jasemk/cjrc7gzq720742smn987oynug',
    center: [-0.755,52.01], // starting position
    pitch: 60, // pitch in degrees
    zoom: 12 // starting zoom
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());

map.on('load', function() {
    var  markerSet = false;
    var marker;
    var url = '/dataset/geospatial-details/' + datasetID + '?f=json';

    function updateFormFields(lngLat) {
        $("#dataset-form input[name=latitude]").val(lngLat.lat.toFixed(6));
        $("#dataset-form input[name=longitude]").val(lngLat.lng.toFixed(6));
    }

    $.getJSON( url, function( data ) {
        function onDragEnd() {
            var lngLat = marker.getLngLat();
            var lon = lngLat.lng;
            var lat = lngLat.lat
            updateFormFields(lngLat);
            //console.log (lngLat);
        }

        if (data['features']){
            var coords = data['features'][0]['geometry']['coordinates'];
            marker = new mapboxgl.Marker({
                draggable: true
            })
                .setLngLat(coords)
                .addTo(map);
            map.setCenter(coords);
            marker.on('dragend', onDragEnd);
            markerSet = true;
        }

        map.on('click', function(e) {
            //console.log(e.lngLat);
            //map.setCenter(e.lngLat);
            if (markerSet == false) {
                marker = new mapboxgl.Marker({
                    draggable: true
                })
                    .setLngLat(e.lngLat)
                    .addTo(map);
                marker.on('dragend', onDragEnd);
                markerSet = true;
            }
            marker.setLngLat(e.lngLat);
            updateFormFields(e.lngLat)
        });

        $("#dataset-form input[name=latitude]").change(function() {
            var lat = $("#dataset-form input[name=latitude]").val();
            var lng = $("#dataset-form input[name=longitude]").val();
            marker.setLngLat([lng,lat]);
            map.flyTo(
                {
                    center:[lng,lat]
                });
        });
        $("#dataset-form input[name=longitude]").change(function() {
            var lat = $("#dataset-form input[name=latitude]").val();
            var lng = $("#dataset-form input[name=longitude]").val();
            marker.setLngLat([lng,lat]);
            map.flyTo(
                {
                    center:[lng,lat]
                });
        });

    });

});



