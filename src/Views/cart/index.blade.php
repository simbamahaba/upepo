@extends('vendor.upepo.layouts.app')
@section('content')
    @if(session()->has('mesaj'))
        <div class="alert alert-success text-center" role="alert">
            {{ session()->get('mesaj') }}
        </div>
    @endif

<h3>Cosul de cumparaturi</h3>
    @if(Cart::count() != 0)
            {!! Form::open(['method'=>'POST','url'=>'cart/update','class'=>'form-horizontal']) !!}

        <table class="table">
            <thead>
                <tr>
                    <th colspan="2">Produs</th>
                    <th>Descriere</th>
                    <th>Cantitate</th>
                    <th>Pret unitar</th>
                    <th>Pret total</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <td colspan="5" class="text-right">TOTAL: </td>
                    <td>{{ Cart::total() }} RON</td>
                </tr>
            </tfoot>
            <tbody>
            @foreach(Cart::content() as $item)
                <tr>
                    <td>
                        @if(isset($pics[$item->id]) && count($pics[$item->id]) > 0)
                            <img src="{{ url('images/small/'.array_shift($pics[$item->id])) }}" alt="">
                        @else
                            <img src="{{ url('images/small/no-image-icon-11.PNG') }}">
                        @endif
                    </td>
                    <td>
                        {{ $item->id.' '.$item->name }}
                    </td>
                    <td>
                        @if($item->options->size){{ ' Size: '.$item->options->size }}@endif
                        @if($item->options->color){{ ' Color: '.$item->options->color }}@endif
                    </td>
                    <td>
                        <input type="number" min="1" name="item[{{ $item->rowId }}]" value="{{ $item->qty }}"><br>
                        <a href="{{ url('cart/deleteItem/'.$item->rowId) }}">Sterge</a>
                    </td>
                    <td>{{ number_format($item->priceTax,2) }} RON</td>
                    <td>{{ number_format(round($item->priceTax * $item->qty),2)  }} RON</td>
                </tr>
            @endforeach
            </tbody>
        </table>
        <button type="submit" class="btn btn-default">Modifică</button>
        <a class="btn btn-default" href="{{ $url }}">Finalizează comanda</a>
        <a class="btn btn-default" href="{{ url('cart/destroy') }}">Golește coșul</a>
            {!! Form::close() !!}
    @else
        <p>Coșul de cumpărături este gol.</p>
    @endif
@endsection
