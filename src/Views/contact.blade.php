<?php
@extends('vendor.upepo.layouts.app')

@section('header-assets')
    <script src="{{ asset('assets/admin/vendors/upepo/js/formvalidation/jquery.validate.min.js') }}"></script>
    <style>
        .error{ color: red;}
    </style>
@endsection

@section('content')
    <h2>CONTACT</h2>
    @if(session()->has('mesaj'))
        <div>{{ session()->get('mesaj') }}</div>
    @endif
    @include('vendor.upepo.layouts.scripts.form')

    {{ $map->latitude }} <br>
    {{ $map->longitude }} <br>
    {{ $map->company }} <br>
    {{ $map->region }} <br>
    {{ $map->city }} <br>
    {{ $map->address }} <br>
@endsection

@section('footer-assets')
    <script src="{{ asset('assets/admin/vendors/upepo/js/formvalidation/validateform.js') }}"></script>
@endsection
