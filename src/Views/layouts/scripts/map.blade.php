<script>
    function initMap() {
        var infowindow = new google.maps.InfoWindow();
        var address = {lat: {{ $map->latitude }}, lng: {{ $map->longitude }} };
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            center: address
        });

        contentString = "<b style='font-size: 12px;'>Companie: {{ $map->company }}</b>";
        contentString += "<br/><b style='font-size: 12px;'>Judet:</b><span  style='font-size: 12px;'> {{ $map->region }}</span><br/><b style='font-size: 12px;'>Oras:</b> <span  style='font-size: 12px;'>{{ $map->city }}</span><br/><b style='font-size: 12px;'>Adresa</b><span style='font-size: 12px;'>: {{ $map->address }}</span>";
        infowindow.setContent(contentString);
        infowindow.setPosition(address);
        infowindow.open(map);

        var marker = new google.maps.Marker({
            position: address,
            map: map
        });
    }
    window.onload = initMap;
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA6utf7v7LOyA24khe4OL-HfiAkgV85OcM&callback=initMap">
</script>