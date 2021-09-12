@extends('vendor.upepo.admin.layouts.master')
@section('footer-assets')
    <script>
        $(document).ready(function () {
            $("#all_records").change(function () {
                if (this.checked) {
                    $('.records').prop('checked', true);
                } else {
                    $('.records').prop('checked', false);
                }
            });
        });
    </script>
@endsection
@section('section-title') Comenzi @endsection
@section('section-content')


            <form action="{{ route('orders.filter.status') }}" method="POST" class="form-horizontal form-label-left" id="filter_orders">
                @csrf
                <fieldset>
                    <legend>Filtre</legend>
                <div class="item form-group">
                    <label for="status" class="col-form-label col-md-3 col-sm-3 label-align">Status :</label>
                    <div class="col-md-6 col-sm-6">
                        <select name="status" id="status" class="form-control" form="filter_orders">
                            @foreach($selectStatus as $statusId => $status)
                                @php $selected = (session('status') == $statusId )?'selected':''; @endphp
                                <option value="{{ $statusId }}" {{ $selected }}>{{ $status }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                    <div class="col-md-6 col-sm-6 offset-md-3">
                        <button type="submit" name="filter" value="1" class="btn btn-warning btn-sm" form="filter_orders"><i class="fa fa-filter"></i> Filtreaza</button>
                        @if( session()->has('status') )
                        <button type="submit" name="deleteFilter" value="1" class="btn btn-warning btn-sm"><i class="fa fa-close"></i> Sterge filtrele</button>
                        @endif
                    </div>
                </fieldset>
            </form>



    <form action="{{ route('orders.delete.multiple') }}" method="POST" class="form-horizontal"
          id="orders_delete_multiple">
        @csrf
    </form>
    <div class="table-responsive">
        <table class="table table-striped jambo_table bulk_action">
            <thead>
            <tr>
                <th><input type="checkbox" id="all_records" class="" form="orders_delete_multiple"></th>
                <th>Id#</th>
                <th><?php $date = (request('date') == 'asc') ? 'desc' : 'asc'; ?>
                    <a href="{{ url('admin/shop/orders?date='.$date) }}">Data
                        @if( request()->has('date'))
                            <i class="fa @if(request('date') == 'asc') fa-caret-down @else fa-caret-up @endif"></i>
                        @endif
                    </a>
                </th>
                <th><?php $name = (request('name') == 'asc') ? 'desc' : 'asc'; ?>
                    <a href="{{ url('admin/shop/orders?name='.$name) }}">Nume
                        @if( request()->has('name'))
                            <i class="fa @if(request('name') == 'asc') fa-caret-down @else fa-caret-up @endif"></i>
                        @endif
                    </a>
                </th>
                <th><?php $price = (request('price') == 'asc') ? 'desc' : 'asc'; ?>
                    <a href="{{ url('admin/shop/orders?price='.$price) }}">Suma
                        @if( request()->has('price'))
                            <i class="fa @if(request('price') == 'asc') fa-caret-down @else fa-caret-up @endif"></i>
                        @endif
                    </a>
                </th>
                <th>Stare</th>
                <th class="text-center">Detalii</th>
                <th class="text-right"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr @if($order->read == 1) class="alert alert-info" @endif>
                    <td><input type="checkbox" class="records" name="item[{{ $order->id }}]"
                               form="orders_delete_multiple"></td>
                    <td>{{ $order->id }}</td>
                    <td>{{ date_format($order->created_at,'d/m/Y H:i') }}</td>
                    <td>{{ $order->customerName() }}</td>
                    <td>{{ $order->finalPrice() }} {{ config('shop.currency') }}</td>
                    <td>{{ $order->status->name }}</td>
                    <td class="text-center"><a data-toggle="tooltip" data-placement="top"
                                               href="{{ url('admin/shop/orders/'.$order->id.'/edit/') }}"
                                               class="panelIcon invoice" title="Detalii"></a></td>
                    <td class="text-right">
                        <form action="{{ route('order.destroy',$order->id) }}" method="POST"
                              id="order_{{ $order->id }}_destroy">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit"
                                    onclick="return confirm('Sunteti sigur ca doriti sa stergeti?')"
                                    form="order_{{ $order->id }}_destroy"><i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <button type="submit" name="deleteMultiple" form="orders_delete_multiple" class="btn btn-danger btn-sm"
            onclick="return confirm('Sunteti sigur ca doriti sa stergeti?')"><i class="fa fa-trash"></i> Delete
    </button>

    {{ $orders->links() }}
    <form action="{{ route('orders.update.limit') }}" method="POST" class="form-inline pull-right"
          id="orders_update_limit">
        @method('POST') @csrf
        <div class="input-group input-group-sm">
            <span class="input-group-btn"><button type="submit" class="btn btn-dark btn-sm go-class">Arata:</button></span>
            <input type="number" name="perPage" value="{{ $perPage }}" min="5" class="form-control input-sm"
                   style="max-width: 60px;" form="orders_update_limit">
        </div>
    </form>
@endsection
