@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Hartă @endsection
@section('section-content')
    <style>
        #map {
            height: 600px;
            width: 800px;
            display: block;
            margin:0 auto;
        }
    </style>
    <div class="row">
        <div class="col-12 text-center">
        <h5>Instrucțiuni de folosire:</h5>
        <ol type="1">
            <li>Poziționați mouse-ul pe locația exactă a sediului firmei;</li>
            <li>Click dreapta pe hartă (va apărea un simbol care indică locația firmei);</li>
            <li>Apăsați butonul de mai jos pentru a salva locația.</li>
        </ol>
        </div>
    </div>
    <div id="map"></div>

    <hr>

    <form action="{{ route('map.update') }}" method="POST" class="form-horizontal form-label-left">
        @csrf
        @method('POST')
        <div class="item form-group">
            <label for="latitude" class="col-form-label col-md-3 col-sm-3 label-align">Latitudine:</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="latitude" id="latitude" class="form-control" value="{{ $map->latitude }}">
            </div>
        </div>

        <div class="item form-group">
            <label for="longitude" class="col-form-label col-md-3 col-sm-3 label-align">Longitudine:</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="longitude" id="longitude" class="form-control" value="{{ $map->longitude }}">
            </div>
        </div>

        <div class="item form-group">
            <label for="company" class="col-form-label col-md-3 col-sm-3 label-align">Companie:</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="company" id="company" class="form-control" value="{{ $map->company }}">
            </div>
        </div>

        <div class="item form-group">
            <label for="region" class="col-form-label col-md-3 col-sm-3 label-align">Județ :</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="region" id="region" class="form-control" value="{{ $map->region }}">
            </div>
        </div>

        <div class="item form-group">
            <label for="city" class="col-form-label col-md-3 col-sm-3 label-align">Oraș :</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="city" id="city" class="form-control" value="{{ $map->city }}">
            </div>
        </div>

        <div class="item form-group">
            <label for="address" class="col-form-label col-md-3 col-sm-3 label-align">Adresa:</label>
            <div class="col-md-6 col-sm-6">
                <textarea name="address" id="address" class="form-control">{{ $map->address }}</textarea>
            </div>
        </div>

        <div class="item form-group">
            <div class="col-md-6 col-sm-6 offset-md-3">
            <input type="submit" value="Submit" class="btn btn-primary">
            </div>
        </div>
    </form>
@endsection
@section('footer-assets')
<script>
    function initMap() {
        let myLatlng = {lat: {{ $map->latitude }}, lng: {{ $map->longitude }}};
        let infowindow = new google.maps.InfoWindow();
        let map = new google.maps.Map(document.getElementById('map'), {
            zoom: 16,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            center: myLatlng
        });

        let marker = new google.maps.Marker({
            position: myLatlng,
            map: map
        });

        let contentString = "<b style='font-size: 12px;'>Companie: {{ $map->company }}</b>";
        contentString += "<br/><b style='font-size: 12px;'>Judet:</b><span  style='font-size: 12px;'> {{ $map->region }}</span><br/><b style='font-size: 12px;'>Oras:</b> <span  style='font-size: 12px;'>{{ $map->city }}</span><br/><b style='font-size: 12px;'>Adresa</b><span style='font-size: 12px;'>: {{ $map->address }}</span>";
        infowindow.setContent(contentString);
        infowindow.setPosition(myLatlng);
        infowindow.open(map);

        map.addListener('rightclick', function(event) {
            new_location = event.latLng;
            marker.setPosition(new_location);
            document.getElementById('latitude').value = new_location.lat();
            document.getElementById('longitude').value = new_location.lng();
        });
    }

    window.onload = initMap;
</script>
<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=">
</script>
@endsection
