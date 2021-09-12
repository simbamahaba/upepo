<script>
    /*
  * Click the map to set a new location for the Street View camera.
  */

    var map;
    var panorama;

    function initMap() {
        var infowindow = new google.maps.InfoWindow();
        var berkeley = {lat: {{ $map->latitude }}, lng: {{ $map->longitude }} };
        var sv = new google.maps.StreetViewService();

        panorama = new google.maps.StreetViewPanorama(document.getElementById('pano'),
            {
//                position: {lat: 42.345573, lng: -71.098326},
                addressControlOptions: {
                    position: google.maps.ControlPosition.BOTTOM_CENTER
                },
                linksControl: false,
                panControl: false,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL
                },
                enableCloseButton: false
            });

        // Set up the map.
        map = new google.maps.Map(document.getElementById('map'), {
            center: berkeley,
            zoom: 16,
            streetViewControl: false
        });

        contentString = "<b style='font-size: 12px;'>Companie: {{ $map->company }}</b>";
        contentString += "<br/><b style='font-size: 12px;'>Judet:</b><span  style='font-size: 12px;'> {{ $map->region }}</span><br/><b style='font-size: 12px;'>Oras:</b> <span  style='font-size: 12px;'>{{ $map->city }}</span><br/><b style='font-size: 12px;'>Adresa</b><span style='font-size: 12px;'>: {{ $map->address }}</span>";
        infowindow.setContent(contentString);
        infowindow.setPosition(berkeley);
        infowindow.open(map);
        // Set the initial Street View camera to the center of the map
        sv.getPanorama({location: berkeley, radius: 50}, processSVData);

        // Look for a nearby Street View panorama when the map is clicked.
        // getPanoramaByLocation will return the nearest pano when the
        // given radius is 50 meters or less.
//        map.addListener('click', function(event) {
//            sv.getPanorama({location: event.latLng, radius: 100}, processSVData);
//        });
    }

    function processSVData(data, status) {
        if (status === 'OK') {
            var marker = new google.maps.Marker({
                position: data.location.latLng,
                map: map,
                title: data.location.description
            });

            panorama.setPano(data.location.pano);
            panorama.setPov({
                heading: 270,
                pitch: 0
            });
            panorama.set('addressControl', false);
            panorama.setVisible(true);

            marker.addListener('click', function() {
                var markerPanoID = data.location.pano;
                // Set the Pano to use the passed panoID.
                panorama.setPano(markerPanoID);
                panorama.setPov({
                    heading: 270,
                    pitch: 0
                });
                panorama.setVisible(true);
            });
        } else {
            console.error('Street View data not found for this location.');
        }
    }
    window.onload = initMap;
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6utf7v7LOyA24khe4OL-HfiAkgV85OcM&callback=initMap">
</script>