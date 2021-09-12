@extends('vendor.upepo.admin.layouts.master')
@section('section-title')Comanda #{{ $order->id }} @endsection
@section('section-content')
<form action="{{ route('order.update.status', $order->id) }}" id="order_update-status" method="POST"> @csrf @method('PUT') </form>
<form action="{{ route('order.transport.price', $order->id) }}" id="update_transport_price" method="POST"> @csrf @method('PUT') </form>
<form action="{{ route('order.update.quantity', $order->id) }}" id="order_update_quantity" method="POST"> @csrf @method('POST') </form>

<div class="row">
    <div class="col-12">
<a class="btn btn-info btn-sm pull-right" target="_blank" href="{{ url('cart/vizualizareProforma/'.$order->id.'/'.$proformaCode) }}">Vizualizați proformă</a>
<button class="btn btn-secondary btn-sm pull-right"><i class="fa fa-download"></i> Generate PDF</button>
    </div>
</div>
<div class="row">
<div class="col-lg-6 col-md-12">
<h3 class="text-center green p-4">Informații despre comandă</h3>
<div class="table-responsive">
    <table class="table table-hover" id="orders">
        <tr><th>Data:</th><td>{{ date_format($order->created_at,'d/m/Y H:i') }}</td><td></td></tr>

        <tr>
            <th>Status:</th>
            <td>
                <select name="status" id="status" class="form-control form-control-sm" form="order_update-status">
                    @foreach($selectStatus as $id=>$status)
                        @php $selected = ($order->status_id == $id)?'selected':'' @endphp
                        <option value="{{ $id }}" {{ $selected }}>{{ $status }}</option>
                    @endforeach
                </select>

            </td>
            <td><input type="submit" class="btn btn-success btn-sm" form="order_update-status" value="Schimbă"></td>
        </tr>

        <tr><th>Tip transport:</th><td>{{ $order->transport->name }}</td><td></td></tr>

        <tr>
            <th>Valoare transport:</th>
            <td>
                <input type="text" name="price_transport" id="price_transport" value="{{ $order->price_transport }}" class="form-control form-control-sm" form="update_transport_price">
{{--                <input type="submit" class="btn btn-success btn-sm" form="update_transport_price" value="Schimbă">--}}

            </td>
            <td><button type="submit" class="btn btn-success btn-sm" form="update_transport_price">Schimbă</button></td>
        </tr>

        <tr><th>Valoare produse:</th><td>{{ $order->price.' '.config('shop.currency') }}</td><td></td></tr>
        <tr><th>Valoare TOTAL:</th><td>{{ $order->finalPrice().' '.config('shop.currency') }}</td><td></td></tr>
        <tr><th>Nrumăr produse:</th><td>{{ $order->quantity }}</td><td></td></tr>
    </table>
</div>
</div>
<div class="col-lg-6 col-md-12">
    <h3 class="text-center green p-4">Date client</h3>
    <ul class="nav nav-tabs bar_tabs" role="tablist" id="myTab">
        <li class="nav-item"><a href="#data_client" class="nav-link active" data-toggle="tab" role="tab" aria-controls="data_client" aria-selected="true"><h4><i class="fa fa-user"></i> Date identificare client</h4></a></li>
        <li class="nav-item"><a href="#transport" class="nav-link" data-toggle="tab" role="tab" aria-controls="transport" aria-selected="false"><h4><i class="fa fa-truck"></i> Date transport</h4></a></li>
    </ul>
    <div class="tab-content">
        <div id="data_client" class="tab-pane fade show active" role="tabpanel" aria-labelledby="data_client-tab">
            <div class="table-responsive">
                <table class="table table-striped">

                    <tfoot>
                    <tr>
                        <td colspan="2">@if( !is_null($order->customer_id) )
                                <a class="btn btn-info btn-sm" href="{{ url('admin/shop/customers/'.$order->customer_id.'/edit') }}"><i class="fa fa-user"></i> Profil utilizator</a>
                            @else
                                Clientul nu are cont pe site.
                            @endif
                        </td>
                    </tr>
                    </tfoot>
                    <tbody>
                    <tr><th>Nume</th><td>{{ $order->customerName() }}</td></tr>
                    <tr><th>Email</th><td>{{ $order->email }}</td></tr>
                    @if( $order->account_type == 0 )
                        <tr><th>Telefon</th><td>{{ $order->phone }}</td></tr>
                        <tr><th>Judet</th><td>{{ $order->region }}</td></tr>
                        <tr><th>Oras</th><td>{{ $order->city }}</td></tr>
                        <tr><th>CNP</th><td>{{ $order->cnp }}</td></tr>
                    @else
                        <tr><th>Banca</th><td>{{ $order->bank_name }}</td></tr>
                        <tr><th>Cont bancar</th><td>{{ $order->bank_account }}</td></tr>
                        <tr><th>Nr. Reg. Com.</th><td>{{ $order->rc }}</td></tr>
                        <tr><th>CIF</th><td>{{ $order->cif }}</td></tr>
                    @endif
                    <tr><th>Adresa</th><td>{{ $order->address }}</td></tr>
                    </tbody>
                </table>
            </div>

        </div>
        <div id="transport" class="tab-pane fade"  role="tabpanel" aria-labelledby="transport-tab">
            <p class="m-5 text-dark"><strong>Adresa de livrare:</strong>
                <?= ( empty($order->delivery_address) )?'Coincide cu adresa de facturare.':$order->delivery_address; ?>
            </p>
        </div>
    </div>
</div>
</div>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
<h3 class="text-center green p-4">Produse comandate</h3>
<div class="table-responsive">
    <table class="table table-bordered jambo_table">
        <thead>
        <tr>
            <th>Nume produs</th>
            <th>Culoare</th>
            <th>Marime</th>
            <th>Buc.</th>
            <th>Preț unitar</th>
            <th>Preț total</th>
            <th class="text-center">Delete</th>
        </tr>
        </thead>
        <tbody>

        @foreach($order->items as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->color }}</td>
            <td>{{ $item->size }}</td>
            <td><input type="number" class="form-control numarb form-control-sm" value="{{ $item->quantity }}" name="item_{{ $item->id }}" form="order_update_quantity"></td>
            <td>{{ $item->price.' '.config('settings.magazin.currency') }}</td>
            <td><h6 class="text-dark">{{ number_format($item->price * $item->quantity,2).' '.config('shop.currency') }}</h6></td>
            <td class="text-center"><a data-toggle="tooltip" data-placement="top" href="{{ url('/admin/shop/orders/'.$order->id.'/item/'.$item->id.'/delete/') }}" class="panelIcon deleteRedItem" title="Delete" onclick="return confirm('Sunteți sigur că doriți să stergeți?')"></a></td>
        </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="7">
                <button type="submit" class="btn btn-warning btn-sm" form="order_update_quantity"><i class="fa fa-refresh" aria-hidden="true"></i>
                    Schimbă cantitățile</button>
            </td>
        </tr>
        </tfoot>
    </table>

</div>
</div>
</div>

@endsection
