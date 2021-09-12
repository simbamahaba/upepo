@extends('vendor.upepo.admin.layouts.master')
@section('section-title') {{ $settings['config']['pageName'] }} @endsection
@section('section-content')
<form action="{{ route('record.store',[$settings['config']['tableName']]) }}" method="POST" class="form-horizontal form-label-left">
@csrf
<fieldset>
<legend>{{ $settings['messages']['add'] }}</legend>
@foreach($settings['elements'] as $name=>$field)
<?php $required = ( $field['required'] == '')?'':"*"; ?>

    @switch($field['type'])
        @case('checkbox')
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
                <div class="col-md-6 col-sm-6">
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" name="{{ $name }}"> {{ $field['friendlyName'] }}
                        </label>
                    </div>
                </div>
            </div>
            @break
        @case('select')
            <div class="item form-group">
                <label for="{{ $name }}" class="col-form-label col-md-3 col-sm-3 label-align">{{ $field['friendlyName'].' '.$required }}</label>
                <div class="col-md-6 col-sm-6">
                    <select name="{{ $name }}" id="{{ $name }}" class="form-control">
                        @foreach($field['options'] as $optionId => $option)
                            <option value="{{ $optionId }}">{!! $option !!}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @break
        @case('editor')
            <?php if( !defined('EDITOR') ) define('EDITOR',true) ?>
            <div class="item form-group">
                <label for="my-editor" class="col-form-label col-md-3 col-sm-3 label-align">{{ $field['friendlyName'].' '.$required }}</label>
                <div class="col-md-6 col-sm-6">
                    <textarea name="{{ $name }}" id="my-editor" class="form-control"></textarea>
                </div>
            </div>
            @break
        @case('textarea')
            <div class="item form-group">
                <label for="{{ $name }}" class="col-form-label col-md-3 col-sm-3 label-align">{{ $field['friendlyName'].' '.$required }}</label>
                <div class="col-md-6 col-sm-6">
                    <textarea name="{{ $name }}" id="{{ $name }}" class="form-control"></textarea>
                </div>
            </div>
            @break
        @default
            <div class="item form-group">
                <label for="{{ $name }}" class="col-form-label col-md-3 col-sm-3 label-align">{{ $field['friendlyName'].' '.$required }}</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="{{ $name }}" class="form-control" id="{{ $name }}">
                </div>
            </div>
    @endswitch

@endforeach

@if($settings['config']['functionVisible'] == 1)
<div class="item form-group">
    <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
    <div class="col-md-6 col-sm-6">
        <div class="checkbox">
            <label>
                <input type="checkbox" name="visible" checked="checked"> Vizibil
            </label>
        </div>
    </div>
</div>
@endif
<div class="ln_solid"></div>
<div class="item form-group">
    <div class="col-md-6 col-sm-6 offset-md-3">
        <input type="submit" class="btn btn-primary" value="Salveaza">
        <a class="btn btn-secondary" href="{{ url('admin/core/'.$settings['config']['tableName']) }}">Renunța</a>
    </div>
</div>
</fieldset>
    <div class="form-group">
        <div class='input-group date datePicker'>
            <input type="text" class="form-control ">
            <span class="input-group-addon">
                <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
            </span>
        </div>
    </div>
</form>
@endsection
@section('footer-assets')
    <script>
        $('.datePicker').datetimepicker({
            format: 'DD.MM.YYYY'
        });
    </script>
@endsection
