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
    var url = '/dataset/geospatial-details/' + datasetID + '?f=json';
    $.getJSON( url, function( data ) {
        if (data['features']){
            var coords = data['features'][0]['geometry']['coordinates'];
            var marker = new mapboxgl.Marker()
                .setLngLat(coords)
                .addTo(map);
            map.setCenter(coords);
        }
    });

});



