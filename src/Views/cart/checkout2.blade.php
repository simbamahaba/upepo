@extends('vendor.upepo.layouts.app')
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3>Pasul 2</h3>
        </div>

        <div class="panel-body">
            <a class="btn btn-default" href="{{ url('cart/checkout3') }}">Cumpără fără cont</a>
            <a class="btn btn-default" href="{{ url('/customer/login/1') }}">Autentificare</a>
            <a class="btn btn-default" href="{{ url('/customer/register') }}">Înregistrare</a>
        </div>
    </div>
@endsection
