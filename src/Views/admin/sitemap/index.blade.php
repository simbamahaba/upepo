@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Sitemap @endsection
@section('section-content')
    <h4>Ultima actualizare: {{ date_format($last,'d-M-Y') }}</h4>
    {!! Form::open(['method'=>'POST','url'=>'admin/sitemap/regenerate','class'=>'form-horizontal']) !!}
    <input type="hidden" name="regenerate" value="1">
    <div class="col-sm-10">
        {!! Form::submit('Regenereaza sitemap',['class' => 'btn btn-success btn-lg']) !!}
    </div>
    {!! Form::close() !!}
@endsection