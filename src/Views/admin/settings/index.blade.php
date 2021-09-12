@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Setari generale @endsection
@section('section-content')

<form action="{{ route('settings.update') }}" method="post" class="form-horizontal form-label-left">
        @csrf
        @method('POST')
    <div class="item form-group">
        <label for="analytics" class="col-form-label col-md-3 col-sm-3 label-align">Google analytics:</label>
        <div class="col-md-6 col-sm-6">
            <textarea name="analytics" id="analytics" cols="50" rows="10" class="form-control" placeholder="Google analytics code...">{{ $site_settings['analytics'] }}</textarea>
        </div>
    </div>
    <h4>Setari Site</h4>
    <hr>
    <div class="item form-group">
        <label for="city" class="col-form-label col-md-3 col-sm-3 label-align">Oras companie:</label>
        <div class="col-md-6 col-sm-6">
            <input type="text" name="city" id="city" value="{{ $site_settings['city'] }}" class="form-control">
        </div>
    </div>
    <div class="item form-group">
        <label for="system_email" class="col-form-label col-md-3 col-sm-3 label-align">Email de sistem:</label>
        <div class="col-md-6 col-sm-6">
            <input type="text" name="system_email" id="system_email" value="{{ $site_settings['system_email'] }}" class="form-control" readonly>
        </div>
    </div>
    <div class="item form-group">
        <label for="contact_email" class="col-form-label col-md-3 col-sm-3 label-align">Email de contact:</label>
        <div class="col-md-6 col-sm-6">
            <input type="text" name="contact_email" id="contact_email" value="{{ $site_settings['contact_email'] }}" class="form-control">
        </div>
    </div>
    <div class="item form-group">
        <label for="phone" class="col-form-label col-md-3 col-sm-3 label-align">Telefon:</label>
        <div class="col-md-6 col-sm-6">
            <input type="text" name="phone" id="phone" value="{{ $site_settings['phone'] }}" class="form-control">
        </div>
    </div>
    <h4>Setari SEO</h4>
    <hr>
    <div class="item form-group">
        <label for="site_name" class="col-form-label col-md-3 col-sm-3 label-align">Numele site-ului:</label>
        <div class="col-md-6 col-sm-6">
            <input type="text" name="site_name" id="site_name" value="{{ $site_settings['site_name'] }}" class="form-control">
        </div>
    </div>
    <div class="item form-group">
        <label for="meta_keywords" class="col-form-label col-md-3 col-sm-3 label-align">Cuvinte cheie:</label>
        <div class="col-md-6 col-sm-6">
            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ $site_settings['meta_keywords'] }}" class="form-control" placeholder="10-12 cuvinte, separate prin virgula">
        </div>
    </div>
    <div class="item form-group">
        <label for="meta_description" class="col-form-label col-md-3 col-sm-3 label-align">Meta descriere:</label>
        <div class="col-md-6 col-sm-6">
            <textarea name="meta_description" id="meta_description" cols="50" rows="10" class="form-control" placeholder="Descriere site - max 180 de caractere...">{{ $site_settings['meta_description'] }}</textarea>
        </div>
    </div>
    <div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <input type="submit" value="Salvează" class="btn btn-success">
    </div>
    </div>
</form>
@endsection
