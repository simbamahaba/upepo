@extends('vendor.upepo.layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table">
            <thead>
            <tr>
                <th>Comanda</th>
                <th>Data</th>
                <th>Valoare</th>
                <th>Status</th>
            </tr>
            </thead>
            <tfoot>
            <tr>
                <td colspan="4" class="text-right"></td>
            </tr>
            </tfoot>
            <tbody>
            @foreach( $orders as $order)
                <tr>
                    <td>#{{$order->id}}</td>
                    <td>{{ date_format($order->created_at,'d-M-Y H:i') }}</td>
                    <td>{{ $order->finalPrice().' '.config('shop.currency') }}</td>
                    <td>{{ $order->status->name }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
