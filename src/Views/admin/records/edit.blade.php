@extends('vendor.upepo.admin.layouts.master')
@section('section-title') {{ $fields['config']['pageName'] }} @endsection
@section('section-content')
<form action="{{ route('record.update',[$fields['config']['tableName'], $record->id]) }}" method="POST" class="form-horizontal form-label-left">
@csrf @method('PUT')
<fieldset>
<legend>{{ $fields['messages']['edit'] }}</legend>
@foreach($fields['elements'] as $name=>$field)
<?php $required = ( $field['required'] == '')?'':"*" ?>

    @switch($field['type'])
        @case('checkbox')
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
                <div class="col-md-6 col-sm-6">
                    <div class="checkbox">
                        <label>
                            @php $checked = ($record->$name === 'da' )?"checked=checked":''; @endphp
                            <input type="checkbox" name="{{$name}}" {{ $checked }}> {{ $field['friendlyName'] }}
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
                            @php $selected = ($optionId == $record->$name)?'selected':''; @endphp
                            <option value="{{ $optionId }}" {{ $selected }}>{!! $option !!}</option>
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
                    <textarea name="{{ $name }}" id="my-editor" class="form-control">{{ $record->$name }}</textarea>
                </div>
            </div>
            @break
        @case('textarea')
        <div class="item form-group">
            <label for="{{ $name }}" class="col-form-label col-md-3 col-sm-3 label-align">{{ $field['friendlyName'].' '.$required }}</label>
            <div class="col-md-6 col-sm-6">
                <textarea name="{{ $name }}" id="{{ $name }}" class="form-control">{{ $record->$name }}</textarea>
            </div>
        </div>
            @break
        @case('calendar')
        <div class="item form-group">
            <label for="{{ $name }}" class="col-form-label col-md-3 col-sm-3 label-align">{{ $field['friendlyName'].' '.$required }}</label>
            <div class="col-md-6 col-sm-6">
                <input name="{{ $name }}" id="{{ $name }}" value="{{ $record->$name }}" class="date-picker form-control" placeholder="dd-mm-yyyy" type="text" onfocus="this.type='date'" onmouseover="this.type='date'" onclick="this.type='date'" onblur="this.type='text'" onmouseout="timeFunctionLong(this)">
                <script>
                    function timeFunctionLong(input) {
                        setTimeout(function() {
                            input.type = 'text';
                        }, 60000);
                    }
                </script>
            </div>
        </div>
            @break
        @default
        <div class="item form-group">
            <label for="{{ $name }}" class="col-form-label col-md-3 col-sm-3 label-align">{{ $field['friendlyName'].' '.$required }}</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="{{ $name }}" class="form-control" id="{{ $name }}" value="{{ $record->$name }}">
            </div>
        </div>
    @endswitch
@endforeach
    @if($fields['config']['functionVisible'] == 1)
        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
            <div class="col-md-6 col-sm-6">
                <div class="checkbox">
                    <label>
                        <?php $checked = ($record->visible == 1)?'checked=checked':'' ?>
                            <input type="checkbox" name="visible" {{ $checked }}> Vizibil
                    </label>
                </div>
            </div>
        </div>
    @endif
    <div class="ln_solid"></div>
    <div class="item form-group">
        <div class="col-md-6 col-sm-6 offset-md-3">
            <input type="submit" value="Salvează modificări" class="btn btn-primary">
        </div>
    </div>
</fieldset>
</form>
@endsection
