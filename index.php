<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Display navigation directions</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">

    <script src='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.js'></script>
    <link href='https://api.mapbox.com/mapbox.js/v3.3.1/mapbox.css' rel='stylesheet' />

    <script src='https://api.mapbox.com/mapbox.js/plugins/mapbox-directions.js/v0.4.0/mapbox.directions.js'></script>
    <link rel='stylesheet' href='https://api.mapbox.com/mapbox.js/plugins/mapbox-directions.js/v0.4.0/mapbox.directions.css' type='text/css' />

    <style>
        body { margin: 0; padding: 0; }
        #map { position: absolute; top: 0; bottom: 0; width: 100%; }
        #inputs,
        #errors,
        #directions {
            position: absolute;
            width: 33.3333%;
            max-width: 300px;
            min-width: 200px;
        }
        #inputs {
            z-index: 10;
            top: 10px;
            left: 10px;
        }
        #directions {
            z-index: 99;
            background: rgb(0 0 0 / 19%);
            top: 0;
            right: 0;
            bottom: 0;
            overflow: auto;
        }

        #errors {
            z-index: 8;
            opacity: 0;
            padding: 10px;
            border-radius: 0 0 3px 3px;
            background: rgba(0,0,0,.25);
            top: 90px;
            left: 10px;
        }
        #map .leaflet-top.leaflet-left {
            position: absolute;
            right: 0;
        }
        #map .leaflet-top.leaflet-left .leaflet-control {
            float: right;
        }
    </style>
</head>
<body>
    <div id="map"></div>
    <div id='inputs'></div>
    <div id='errors'></div>
    <div id='directions'>
      <div id='routes'></div>
      <div id='instructions'></div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="jquery-3.1.1.min.js"></script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>

    <script>
    L.mapbox.accessToken = 'pk.eyJ1IjoibW9ua2V5LTIwMDIiLCJhIjoiY2xnMXp2cW5kMDBkNDNlbjluM2RtbzVjeiJ9.1fSltdPisSd7RvicJo4tDA';

    const mapLeaflet = L.mapbox.map('map')
    .setView([12.972784, 80.179281], 13)
    .addLayer(L.mapbox.styleLayer('mapbox://styles/mapbox/outdoors-v12'));

    $(document).ready(function() {
        $(function() {
            let icon = L.icon({
                iconUrl : 'circle.svg',
                iconSize: [10, 10]
            });

            $.getJSON('coordinates.json', function(coordinate) {
                for (const point of coordinate) {
                    L.marker(point.coordinate, {icon: icon}).addTo(mapLeaflet);
                }
            });
        });
    });

    // move the attribution control out of the way
    mapLeaflet.attributionControl.setPosition('bottomleft');

    // create the initial directions object, from which the layer
    // and inputs will pull data.
    var directions = L.mapbox.directions();

    var directionsLayer = L.mapbox.directions.layer(directions)
        .addTo(mapLeaflet);

    var directionsInputControl = L.mapbox.directions.inputControl('inputs', directions)
        .addTo(mapLeaflet);

    var directionsErrorsControl = L.mapbox.directions.errorsControl('errors', directions)
        .addTo(mapLeaflet);

    var directionsRoutesControl = L.mapbox.directions.routesControl('routes', directions)
        .addTo(mapLeaflet);

    var directionsInstructionsControl = L.mapbox.directions.instructionsControl('instructions', directions)
        .addTo(mapLeaflet);

    mapLeaflet.scrollWheelZoom.disable();
    </script>
</body>
</html>