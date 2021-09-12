@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Setări transport @endsection
@section('section-content')
    <form action="{{ route('transport.update.order') }}" method="POST" id="transport_order" class="form-horizontal"> @csrf @method('POST')</form>
    <a class="btn btn-primary btn-small" href="{{ route('transport.create') }}"><i class="fa fa-plus-circle"></i> Adaugă un transport</a>

    <div class="table-responsive mt-4">
        <table class="table jambo_table">
            <thead>
            <tr>
                <th>Nume transport</th>
                <th class='text-center'>Ordine</th>
                <th class='text-center'>Vizibil</th>
                <th class='text-center'>Editează</th>
                <th class='text-center'>Șterge</th>
            </tr>
            </thead>
            <tbody>
            @foreach($transport as $t)
                <tr>
                    <td><h6>{{ $t->name }}</h6></td>
                    <td class="text-center"><input type="text" name="orderId_{{ $t->id }}" class="numar" value="{{ $t->ordine }}" form="transport_order"></td>
                    <td class='text-center'>@if($t->visible == 1) <span class='panelIcon visible'></span> @else <span class='panelIcon notVisible'></span> @endif</td>
                    <td class='text-center'><a data-toggle="tooltip" data-placement="top" href="{{ url('admin/shop/transport/'.$t->id.'/edit/') }}" class="panelIcon editItem" title='Editează'></a></td>
                    <td class='text-center'><a data-toggle="tooltip" data-placement="top" href="{{ url('admin/shop/transport/'.$t->id.'/delete') }}" class="panelIcon deleteItem" title='Șterge' onclick="return confirm('Sunteti sigur ca doriti sa stergeti?')"></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-12">
        <button type="submit" form="transport_order" class="btn btn-success"><i class="fa fa-list-ol"></i> Schimbă ordinea</button>
    </div>

@endsection
