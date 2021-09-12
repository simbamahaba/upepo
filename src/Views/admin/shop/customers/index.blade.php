@extends('vendor.upepo.admin.layouts.master')
@section('footer-assets')
    <script>
        $(document).ready(function(){
            $("#all_records").change(function(){
                if(this.checked) {
                    $('.records').prop('checked', true);
                }else{
                    $('.records').prop('checked', false);
                }
            });
        });
    </script>
@endsection
@section('section-title') Utilizatori @endsection
@section('section-content')
    <a class="btn btn-primary btn-small" href="{{ route('customer.create.backend') }}"><i class="fa fa-plus-circle"></i> Adaugă un utilizator</a>
    <br>
    <br>
@if(count($customers) > 0)
    <form id="delete_multiple" action="{{ route('customer.delete.multiple.backend') }}" class="form-horizontal form-label-left">
    @csrf @method("POST")
    </form>
    <div class="table-responsive">
        <table class="table table-striped jambo_table">
            <thead>
            <tr>
                <th><input form="delete_multiple" type="checkbox" id="all_records" class=""></th>
                <th class="text-center">#</th>
                <?php
                $name = (request('name') == 'asc')?'desc':'asc';
                $caretName = (request('name') == 'asc')?'down':'up';
                ?>
                <th><a href="{{ url('admin/shop/customers/?name='.$name) }}">Email @if( request('name') )<i class="fa fa-caret-{{ $caretName }}"></i>@endif</a></th>
                <?php
                $active = (request('active') == 'asc')?'desc':'asc';
                $caretActive = (request('active') == 'asc')?'down':'up';
                ?>
                <th class="text-center"><a href="{{ url('admin/shop/customers/?active='.$active) }}">Activ @if( request('active') )<i class="fa fa-caret-{{ $caretActive }}"></i>@endif</a></th>
                <th class="text-center">Editează</th>
                <th class="text-center">Șterge</th>
            </tr>
            </thead>
            <tbody>
            <?php $counter=0; ?>
            @foreach($customers as $customer)
                <tr>
                    <td><input form="delete_multiple" type="checkbox" class="records" name="item[{{ $customer->id }}]"></td>
                    <th class="text-center">{{ $customers->perPage()*($customers->currentPage()-1)+(++$counter) }}</th>
                    <td>
                        @if( empty(trim($customer->email)) )
                        {{ $customer->name }}
                        @else
                        {{ $customer->email }}
                        @endif
                    </td>
                    <td class="text-center">@if($customer->email_verified_at) <span class='panelIcon visible'></span> @else <span class='panelIcon notVisible'></span> @endif</td>
                    <td class="text-center"><a data-toggle="tooltip" data-placement="top" href="{{ url('admin/shop/customers/'.$customer->id.'/edit/') }}" class="panelIcon editItem" title='Editeaza'></a></td>
                    <td class="text-center">
                        <form action="{{ route('customer.destroy.backend', $customer->id) }}" method="POST" id="delete_customer_{{ $customer->id }}">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" type="submit" form="delete_customer_{{ $customer->id }}" onclick="return confirm('Sunteti sigur ca doriti sa stergeti?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <button form="delete_multiple" type="submit" name="deleteMultiple" class="btn btn-danger btn-sm" onclick="return confirm('Sunteti sigur ca doriti sa stergeti?')"><i class="fa fa-trash"></i> Delete</button>
    <div class="clearfix"></div>
    {{ $customers->links() }}
    <form action="{{ route('customer.limit.backend') }}" id="update_customer_limit" method="POST" class="form-inline pull-right">
        @csrf @method('POST')
        <div class="input-group input-group-sm">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-dark btn-sm go-class">Arata:</button>
            </span>
            <input type="number" name="perPage" form="update_customer_limit" value="{{ $perPage }}" min="5" class="form-control" style="max-width: 60px;">
        </div>
    </form>
@else
<p class="text-info">Deocamdată nu exista utilizatori in baza de date.</p>
@endif
@endsection
