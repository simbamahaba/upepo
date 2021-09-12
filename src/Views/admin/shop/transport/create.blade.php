@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Setări transport @endsection
@section('section-content')
    @if(session()->has('mesaj'))
        <br>
        <br>
        <div class="alert alert-success text-center" role="alert">
            {{ session()->get('mesaj') }}
        </div>
    @endif
    <form action="{{ route('transport.store') }}" method="POST" id="transport-create" class="form-horizontal form-label-left">
        @csrf   @method('POST')
    <fieldset>
        <legend>Adăugare transport</legend>
        <div class="item form-group">
            <label for="name" class="col-form-label col-md-3 col-sm-3 label-align">Nume transport:</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="name" id="name" class="form-control" placeholder="Nume transport" form="transport-create">
            </div>
        </div>
        <div class="item form-group">
            <label for="price" class="col-form-label col-md-3 col-sm-3 label-align">Pret:</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="price" id="price" class="form-control" placeholder="Pret transport" form="transport-create">
            </div>
        </div>
        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
            <div class="col-md-6 col-sm-6">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="visible" checked form="transport-create"> Vizibil
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
        <div class="col-md-6 col-sm-6 offset-md-3">
            <input type="submit" class="btn btn-primary" value="Salveaza" form="transport-create">
            <a href="{{ route('transport.index') }}" class="btn btn-secondary">Renuntă</a>
        </div>
        </div>
    </fieldset>
    </form>
@endsection
