@extends('vendor.upepo.admin.layouts.master')
@section('section-title')
    <a href="{{ url('admin/core/'.$tabela) }}">{{ $pageName }}</a> / {{ $record->$name }}
@endsection
@section('section-content')
<form action="{{ route('store.pic', [$tabela, $record->id]) }}" method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left">
        @csrf
        @method('POST')
    <fieldset>
        <legend>Adăugare poze (max. {{ $imagesMax }})</legend>
    <div class="item form-group"><label for="description" class="col-form-label col-md-3 col-sm-3 label-align">Titlu poză</label>
        <div class="col-md-6 col-sm-6">
            <textarea name="description" id="description" class="form-control textarea-small" placeholder="(maxim 50 de caractere)"></textarea>
        </div>
    </div>
    <div class="item form-group"><label for="pic" class="col-form-label col-md-3 col-sm-3 label-align">Alege o poză *</label>
        <div class="col-md-6 col-sm-6">
            <input type="file" name="pic" class="form-control">
        </div>
    </div>
    <div class="item form-group">
        <div class="col-md-6 col-sm-6 offset-md-3">
        <input type="submit" class="btn btn-primary" value="Adaugă poza">
        <a class="btn btn-secondary" href="{{ url('admin/core/'.$tabela) }}">Renunță</a>
        <button class="btn btn-secondary" type="reset" value="Reset">Reset</button>
        </div>
    </div>
    </fieldset>
</form>

    <span style="display: block; height: 40px;"></span>
    @if($poze->count() != 0)
    <form action="{{ route('update.picsOrder', [$idTabela, $record->id]) }}" method="post" class="form-horizontal  form-label-left">
        @csrf
        @method('POST')
<div class="table-responsive">
    <table class="table">
        <thead>
        <tr>
            <th>Imagine</th>
            <th>Titlu</th>
            <th class="text-center">Ordine</th>
            <th class="text-center">Acțiuni</th>
        </tr>
        </thead>
        <tbody>
    @foreach($poze as $poza)
{{--        {{ dump( $poza->name ) }}--}}
{{--        {{ dd( substr_replace($poza->name, 'thumb_', strrpos($poza->name, '/') +1 ) . ltrim(strrchr($poza->name, '/'),'/') ) }}--}}
        <tr>
            <td style="width: 136px;">
                <img src="{{ asset('images/small/'.$poza->thumb) }}" alt="{{ Str::limit($poza->description, 50) }}" title="{{ Str::limit($poza->description, 50) }}" data-toggle="tooltip" data-placement="right">
            </td>
            <td>
                <textarea name="description_{{ $poza->id }}" cols="10" rows="10" class="form-control textarea-small">{{ $poza->description }}</textarea>
            </td>
            <td class="text-center">
                <input type="text" name="ordine_{{ $poza->id }}" value="{{ $poza->ordine }}" class="numar margin-top-34">
            </td>
            <td class='text-center'>
                <a data-toggle="tooltip" style="margin-top: 35px;" data-placement="top" href="{{ url('admin/core/deletePic/'.$poza->id) }}" class="panelIcon deleteItem" title='Sterge' onclick="return confirm('Sunteti sigur ca doriti sa stergeti?')"></a>
            </td>
        </tr>
    @endforeach
        </tbody>
    </table>
</div>
    <div class="col-sm-12">
        <input type="submit" value="Modifică" class="btn btn-success">
    </div>
    </form>
    @else
        {{ $noImages }}
    @endif
    <hr>
    <a href="{{ url('admin/core/'.$tabela) }}" class="btn btn-dark">Înapoi la listare</a>
    <a href="{{ url('admin/core/'.$tabela.'/edit/'.$record->id) }}" class="btn btn-dark">Înapoi la editare</a>
@endsection
