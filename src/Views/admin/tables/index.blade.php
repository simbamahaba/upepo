@extends('vendor.upepo.admin.layouts.master')
@section('header-assets')
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
@endsection
@section('footer-assets')
    <script>
        $(document).ready(function(){
            $("#all_tables").change(function(){
                if(this.checked) {
                    $('.tables').prop('checked', true);
                }else{
                    $('.tables').prop('checked', false);
                }
            });
        });
    </script>
@endsection
@section('section-title') Tabele @endsection
@section('section-content')

<form id="tables_create" action="{{ route('tables.create') }}" method="get" class="form-horizontal">
    <div class="item form-group">
        <label for="columns" class="col-form-label col-md-3 col-sm-3 label-align">Număr coloane</label>
        <div class="col-md-6 col-sm-6">
            <input type="number" min="1" class="form-control" name="columns" id="columns" form="tables_create">
        </div>
    </div>
    <div class="item form-group">
        <div class="col-md-6 col-sm-6 offset-md-3">
            <input type="submit" class="btn btn-success btn-sm" value="Tabela noua" form="tables_create">
        </div>
    </div>
</form>

    <form id="tables_order" action="{{ route('tables.order') }}" method="post">
        @csrf
        @method('POST')
    </form>
<div class="table-responsive">
    <table class="table table-hover jambo_table">
        <thead>
        <tr>
            <th><input form="tables_order" type="checkbox" id="all_tables" class=""></th>
            <th>Nume</th>
            <th class='text-center'>Ordine</th>
            <th class='text-center'>Vizibil</th>
            <th class='text-center'>Editare</th>
            <th class='text-center'>Delete</th>
        </tr>
        </thead>
        <tbody>
        @foreach($tabele as $tabela)
            <tr>
                <td><input form="tables_order" type="checkbox" class="tables" name="item[{{ $tabela->id }}]"></td>
                <td>{{ $tabela->name }}</td>
                <td class='text-center'><input form="tables_order" type="text" name="order_{{ $tabela->id }}" class="text-center numar" value="{{ $tabela->order }}"></td>
                <td class='text-center'>@if($tabela->visible == 1) <span class='panelIcon visible'></span> @else <span class='panelIcon notVisible'></span> @endif</td>
                <td class='text-center'><a data-toggle="tooltip" data-placement="top" href="{{ route('tables.edit',$tabela->id) }}" class="panelIcon editItem" title='Editeaza'></a></td>
                <td class='text-center'>
                    <form action="{{ route('tables.destroy', $tabela->id)}}" method="post" id="delete_{{ $tabela->id }}_tb">
                        @csrf
                        @method('DELETE')
                        <button form="delete_{{ $tabela->id }}_tb" class="btn btn-sm btn-danger" type="submit" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
    <div class="col-sm-12">
        <input form="tables_order" type="submit" class="btn btn-primary btn-sm" value="Schimba ordinea">
    </div>
@endsection
