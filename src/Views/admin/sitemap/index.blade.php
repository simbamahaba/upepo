@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Sitemap @endsection
@section('section-content')
<h4>Ultima actualizare: {{ date_format($last,'d-M-Y') }}</h4>
<form action="{{ route('sitemap.regenerate') }}" method="POST" class="form-horizontal form-label-left">
    @csrf @method('POST')
    <input type="hidden" name="regenerate" value="1">
    <div class="col-sm-12 mt-2 mb-2">
        <input type="submit" value="Regenereaza sitemap" class="btn btn-dark">
    </div>
</form>
@endsection