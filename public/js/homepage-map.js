mapboxgl.accessToken = 'pk.eyJ1IjoiamFzZW1rIiwiYSI6ImNqcmM2MGx3bDE3MTY0NGw4MHdpMGJtOTEifQ.q78vPOJ29YoFwpVZoFAlfQ';
var bounds = [
    [-1.3, 51.6], // Southwest coordinates
    [-0.2, 52.3] // Northeast coordinates
];
var map = new mapboxgl.Map({
    container: 'map', // container id
    style: 'mapbox://styles/jasemk/cjrc7gzq720742smn987oynug',
    center: [-0.755,52.01], // starting position
    pitch: 60, // pitch in degrees
    zoom: 12, // starting zoom
    minZoom: 10,
    maxBounds: bounds
});

// Add zoom and rotation controls to the map.
map.addControl(new mapboxgl.NavigationControl());

map.on('load', function() {
    //var url = 'datafeeds.geojson';
    //var url = '/js/map_sample_data.json';
    var url = '/dataset/locations';
    map.addSource('geojson_source',
        {
            type: 'geojson',
            data: url,
            cluster: true
        });


    /*
    map.addLayer({
        "id": "datafeeds",
        "type": "symbol",
        "source": "geojson_source",
        "layout": {
            "icon-image": "circle-15"
        }
    });
    */


    map.addLayer({
        id: "clusters",
        type: "circle",
        source: "geojson_source",
        filter: ["has", "point_count"],
        paint: {
            // Use step expressions (https://docs.mapbox.com/mapbox-gl-js/style-spec/#expressions-step)
            // with three steps to implement three types of circles:
            //   * Blue, 20px circles when point count is less than 100
            //   * Yellow, 30px circles when point count is between 100 and 750
            //   * Pink, 40px circles when point count is greater than or equal to 750
            "circle-color": [
                "step",
                ["get", "point_count"],
                "#4bb5c1",
                100,
                "#00a388",
                750,
                "#f28cb1"
            ],
            "circle-radius": [
                "step",
                ["get", "point_count"],
                20,
                100,
                30,
                750,
                40
            ],
            "circle-stroke-width": 1,
            "circle-stroke-color": "#787878"
        }
    });

    map.addLayer({
        id: "cluster-count",
        type: "symbol",
        source: "geojson_source",
        filter: ["has", "point_count"],
        layout: {
            "text-field": "{point_count_abbreviated}",
            "text-font": ["DIN Offc Pro Medium", "Arial Unicode MS Bold"],
            "text-size": 12
        }
    });


    map.addLayer({
        id: "unclustered-point",
        type: "circle",
        source: "geojson_source",
        filter: ["!", ["has", "point_count"]],
        paint: {
            "circle-color": "#ff6138",
            "circle-radius": 7,
            "circle-stroke-width": 1,
            "circle-stroke-color": "#787878"
        }
    });

});

map.on('click', 'unclustered-point', function (e) {
    var coordinates = e.features[0].geometry.coordinates.slice();
    var details = "<strong>Datafeed</strong><br />";
    //var link = "https://datahub.mksmart.org/dataset/" + e.features[0].properties.name;
    var link = e.features[0].properties.url;
    details += "<em><a href='" + link + "'>" + e.features[0].properties.title + "</a></em><br />";
    //details += "UUID: <em>" + e.features[0].properties.uuid + "</em><br />";
    //details += "Link: <em><a class='mappopup' href='" + link + "'>" + link + "</a></em><br />";
    //details += "Visible: <em>" + e.features[0].properties.visible + "</em>";
    // Ensure that if the map is zoomed out such that multiple
    // copies of the feature are visible, the popup appears
    // over the copy being pointed to.
    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
    }

    new mapboxgl.Popup()
        .setLngLat(coordinates)
        .setHTML(details)
        .addTo(map);
});

// Change the cursor to a pointer when the mouse is over the places layer.
map.on('mouseenter', 'unclustered-point', function () {
    map.getCanvas().style.cursor = 'pointer';
});

// Change it back to default when it leaves.
map.on('mouseleave', 'unclustered-point', function () {
    map.getCanvas().style.cursor = '';
});


// inspect a cluster on click
map.on('click', 'clusters', function (e) {
    var features = map.queryRenderedFeatures(e.point, { layers: ['clusters'] });
    var clusterId = features[0].properties.cluster_id;
    map.getSource('geojson_source').getClusterExpansionZoom(clusterId, function (err, zoom) {
        if (err)
            return;

        map.easeTo({
            center: features[0].geometry.coordinates,
            zoom: zoom
        });
    });
});

map.on('mouseenter', 'clusters', function () {
    map.getCanvas().style.cursor = 'pointer';
});
map.on('mouseleave', 'clusters', function () {
    map.getCanvas().style.cursor = '';
});