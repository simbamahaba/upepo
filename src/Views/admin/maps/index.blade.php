@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Hartă @endsection
@section('header-assets')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
          integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
            integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
            crossorigin=""></script>
@endsection
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
            <li>Click pe hartă (va apărea un simbol care indică locația firmei);</li>
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
    let contentString = "<b style='font-size: 12px;'>{{ $map->company }}</b>";
    contentString += "<br/><b style='font-size: 12px;'>Judet:</b><span  style='font-size: 12px;'> {{ $map->region }}</span><br/><b style='font-size: 12px;'>Oras:</b> <span  style='font-size: 12px;'>{{ $map->city }}</span><br/><b style='font-size: 12px;'>Adresa</b><span style='font-size: 12px;'>: {{ $map->address }}</span>";
    let latitude = "{{ $map->latitude }}";
    let longitude = "{{ $map->longitude }}";
    let mymap = L.map('map').setView([latitude, longitude], 13);
    L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: '{{ env('LEAFLET_ACCESS_TOKEN') }}'
    }).addTo(mymap);
    let marker = L.marker([latitude, longitude], {
        draggable: true
    }).addTo(mymap);
    marker.bindPopup(contentString).openPopup();
    function onMapClick(e) {

        document.getElementById('latitude').value = e.latlng.lat;
        document.getElementById('longitude').value = e.latlng.lng;
        marker.setLatLng(e.latlng).openPopup();
        mymap.setView(e.latlng);
    }

    mymap.on('click', onMapClick);
</script>
@endsection
