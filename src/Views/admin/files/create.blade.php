@extends('vendor.upepo.admin.layouts.master')
@section('section-title')
<a href="{{ url('admin/core/'.$tabela) }}">{{ $pageName }}</a> / {{ $record->$name }}
@endsection
@section('section-content')
<form action="{{ route('store.file', [$tabela, $record->id]) }}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
        @csrf
        @method('POST')
    <fieldset>
    <legend>Adăugare fișiere (max. {{ $filesMax }})</legend>
    <div class="item form-group">
        <label for="title" class="col-form-label col-md-3 col-sm-3 label-align">Nume fișier *</label>
        <div class="col-md-6 col-sm-6" id="root">
            <input type="text" name="title" class="form-control" id="title" placeholder="(maxim 50 de caractere)" value="{{ old('title') }}">
        </div>
    </div>
    <div class="item form-group">
        <label for="file" class="col-form-label col-md-3 col-sm-3 label-align">Alege un fișier *</label>
        <div class="col-md-6 col-sm-6">
            <input name="file" type="file" class="form-control" id="file">
        </div>
    </div>
    <div class="item form-group">
        <div class="col-md-6 col-sm-6 offset-md-3">
            <input type="submit" value="Adaugă fișier" class="btn btn-primary">
            <a class="btn btn-secondary" href="{{ url('admin/core/'.$tabela) }}">Renunță</a>
            <button class="btn btn-secondary" type="reset" value="Reset">Reset</button>
        </div>
    </div>
    </fieldset>
</form>
    <span style="display: block; height: 40px;"></span>
    @if($files->count() != 0)
<form action="{{ route('update.filesOrder', [$idTabela, $record->id]) }}" method="post" class="form-horizontal  form-label-left">
    @csrf
    @method('POST')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Fișier</th>
                <th>Nume</th>
                <th class="text-center">Ordine</th>
                <th class="text-center">Acțiuni</th>
            </tr>
            </thead>
            <tbody>
            @foreach($files as $file)
                <tr>
                    <td style="width: 136px;">
                        <a target="_blank" href="{{ asset('uploaded_files/'.$tabela.'/'.$record->id.'/'.$file->name) }}" class="btn btn-link">{{ $file->title }}</a>
                    </td>
                    <td>
                        <input type="text" name="title_{{ $file->id }}" value="{{ $file->title }}" class="form-control input-sm">
                    </td>
                    <td class="text-center">
                        <input type="text" name="ordine_{{ $file->id }}" value="{{ $file->ordine }}" class="numar">
                    </td>
                    <td class='text-center'>
                        <a data-toggle="tooltip" style="" data-placement="top" href="{{ url('admin/core/deleteFile/'.$file->id) }}" class="panelIcon deleteItem" title='Șterge' onclick="return confirm('Sunteti sigur ca doriti sa stergeti?')"></a>
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
        {{ $noFiles }}
    @endif
    <hr>
    <a href="{{ url('admin/core/'.$tabela) }}" class="btn btn-dark">Înapoi la listare</a>
    <a href="{{ url('admin/core/'.$tabela.'/edit/'.$record->id) }}" class="btn btn-dark">Înapoi la editare</a>
@endsection
