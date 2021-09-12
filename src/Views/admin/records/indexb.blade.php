@extends('vendor.upepo.admin.layouts.master')
@section('section-title') {{ $config['pageName'] }} @endsection
@section('section-content')
    @if($settings['config']['functionAdd'] == 1)
    <a class="btn btn-primary btn-small" href="{{ url('admin/core/'.$config['tableName'].'/create') }}"><i class="fa fa-plus-circle"></i> {{ $settings['messages']['add'] }}</a><hr>
    @endif

    @if( !empty(array_filter($settings['filter'])) )
        <form action="{{ route('records.index',[$config['tableName']]) }}" class="form-horizontal form-label-left" method="POST" id="filters">
            @csrf @method('POST')
            <fieldset>
                <legend>Filtre</legend>
        @foreach( $filters as $filter )
            @if( $filter['type'] == 'select')
                <div class="item form-group">
                    <label for="{{ $filter['column'] }}" class="col-form-label col-md-3 col-sm-3 label-align">{{ $filter['name'] }}</label>
                    <div class="col-md-6 col-sm-6">
                        <select name="{{ $filter['column'] }}" id="{{ $filter['column'] }}" class="form-control">
                            @foreach( $filter['options'] as $optionKey=>$optionValue)
                                @php $selected = ( session('filters.'.$config['tableName'].'.'.$filter['column']) == $optionKey )?'selected':''  @endphp
                                <option value="{{ $optionKey }}" {{ $selected }}>{!! $optionValue !!}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @elseif( $filter['type'] == 'text')
                <div class="item form-group">
                    <label for="{{ $filter['column'] }}" class="col-form-label col-md-3 col-sm-3 label-align">{{ $filter['name'] }}</label>
                    <div class="col-md-6 col-sm-6">
                        <input type="text" name="{{ $filter['column'] }}" id="{{ $filter['column'] }}" value="{{ session('filters.'.$config['tableName'].'.'.$filter['column']) }}" class="form-control">
                    </div>
                </div>
            @endif
        @endforeach
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <button type="submit" class="btn btn-warning btn-sm"><i class="fa fa-filter"></i> Filtreaza</button>
                @if( session()->has('filters.'.$config['tableName']) )
                    <a href="{{ url('admin/core/'.$config['tableName'].'/resetFilters') }}" class="btn btn-warning btn-sm"><i class="fa fa-close"></i> Sterge filtrele</a>
                @endif
                </div>
            </fieldset>
        </form>
    @endif

<form action="{{ route('records.update.order', [$config['tableName']]) }}" method="POST" id="update_order" class="form-horizontal">
@csrf
</form>

<form action="{{ route('records.delete.many', [$config['tableName'], $id]) }}" method="POST" id="delete_records"> @csrf </form>
<div class="table-responsive">
{{--    <table class="table table-hover bulk_action">--}}
    <table class="table table-striped jambo_table bulk_action">
        <thead>
        <tr>
            <th><input type="checkbox" id="all_records" class=""></th>
            <?php $dir = (request('dir') == 'asc')?'desc':'asc'; ?>
            <?php $caret = (request('dir') == 'asc')?'down':'up'; ?>
            <th><a href="{{ url('admin/core/'.$config['tableName'].'/?order='.$config['displayedName'].'&dir='.$dir) }}">
                    {{ $settings['config']['displayedFriendlyName'] }}
                    @if(request('order') == $config['displayedName'] )<i class="fa fa-caret-{{ $caret }}"></i> @endif
                </a>
            </th>
            @if($settings['config']['functionSetOrder'] == 1)
            <th class='text-center'>
                <a href="{{ url('admin/core/'.$config['tableName'].'/?order=order&dir='.$dir) }}">
                    Ordine
                    @if(request('order') == 'order' )<i class="fa fa-caret-{{ $caret }}"></i> @endif
                </a>
            </th>
            @endif
            @if($settings['config']['functionVisible'] == 1)
                <th class='text-center'>
                    <a href="{{ url('admin/core/'.$config['tableName'].'/?order=visible&dir='.$dir) }}">
                        Vizibil
                        @if(request('order') == 'visible' )<i class="fa fa-caret-{{ $caret }}"></i> @endif
                    </a>
                </th>
            @endif
            <th colspan="{{ $spanActions }}" class='text-center'>Acțiuni</th>
            @if($settings['config']['functionImages'] == 1)
            <th class='text-center'>Imagine</th>
            @endif
        </tr>
        </thead>
        <tbody>
            @foreach($records as $record)
            <tr>
                <td><input type="checkbox" class="records" name="item[{{ $record->id }}]" form="delete_records"></td>
                <?php $name = $config['displayedName']; ?>
                <td>{{ html_entity_decode($record->$name) }}</td>
                @if($settings['config']['functionSetOrder'] == 1)
                <td class="text-center">
                    <input form="update_order" type="text" name="orderId[{{$record->id }}]" class="numar" value="{{ $record->order }}">
                    <input form="update_order" type="hidden" name="oldOrderId[{{ $record->id }}]" value="{{ $record->order }}">
                </td>
                @endif
                @if($config['functionVisible'] == 1)
                <td class='text-center'>@if($record->visible == 1) <span class='panelIcon visible'></span> @else <span class='panelIcon notVisible'></span> @endif</td>
                @endif
                @if($config['functionEdit'] == 1)
                <td class='text-center'><a data-toggle="tooltip" data-placement="top" href="{{ url('admin/core/'.$config['tableName'].'/edit/'.$record->id) }}" class="panelIcon editItem" title='Editează'></a></td>
                @endif
                @if($config['functionDelete'] == 1)
                <td class='text-center'><a data-toggle="tooltip" data-placement="top" href="{{ url('admin/core/'.$config['tableName'].'/delete/'.$record->id) }}" class="panelIcon deleteItem" title='Șterge' onclick="return confirm('Sunteți sigur ca doriți sa ștergeți?')"></a></td>
                @endif
                @if($config['functionFile'] == 1)
                    <td class='text-center'><a data-toggle="tooltip" data-placement="top" class='panelIcon pdf' href="{{ url('admin/core/'.$config['tableName'].'/addFile/'.$record->id) }}" title='Add Files'></a></td>
                @endif
                @if($config['functionImages'] == 1)
                    <td class='text-center'><a data-toggle="tooltip" data-placement="top" class='panelIcon addImage' href="{{ url('admin/core/'.$config['tableName'].'/addPic/'.$record->id) }}" title='Add Images'></a></td>
                    <td class='text-center'>
                        @if( !empty($pics[$record->id]) )
                            <img src="{{ url('images/xsmall/'.$config['tableName'].'/'.$record->id.'/'.$pics[$record->id]) }}" alt="">
                        @else
                            <span class='panelIcon noImage'></span>
                        @endif
                    </td>
                @else <td style="width:0; padding:8px 0;"></td> @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="col-sm-12 mt-2 mb-2">
    @if($config['functionSetOrder'] == 1)
    <button type="submit" form="update_order" class="btn btn-success btn-sm" value="1"><i class="fa fa-reorder"></i> Schimbă ordinea</button>
    @endif
    @if($config['functionDelete'] == 1)
    <button type="submit" form="delete_records" class="btn btn-danger btn-sm" value="1" onclick="return confirm('Sunteti sigur ca doriti sa stergeti?')"><i class="fa fa-trash"></i> Delete</button>
    @endif
</div>
    <div class="clearfix"></div>

    {{ $records->setPath(url('/admin/core/'.$config['tableName'].'/id/'.$id))->render('vendor.pagination.bootstrap-4') }}

    <form action="{{ route('records.limit',$config['tableName']) }}" method="POST" class="form-inline pull-right" id="records_per_page">
        @csrf @method('POST')
        <div class="input-group input-group-sm">
            <span class="input-group-btn">
                <button type="submit" class="btn btn-dark btn-sm go-class" form="records_per_page">Arată:</button>
            </span>
            <input type="number" name="perPage" form="records_per_page" value="{{ $config['limitPerPage'] }}" min="5" class="form-control" style="max-width: 60px;">
        </div>
    </form>
@endsection
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
