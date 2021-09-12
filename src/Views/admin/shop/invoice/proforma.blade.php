<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Factura Proforma {{ $order->id }}</title>
    <link href="{{ asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
</head>
<body>
    <div class="row">
        <div class="col-sm-12 col-md-8 col-lg-6 col-md-offset-2 col-lg-offset-3">


                <table class="table">
                   <tbody>
                    <tr>
                        <td class="text-left">
                            Furnizor : {{ $invoice->company }}<br>
                            Sediu: {{ $invoice->address }}<br>
                            Cod fiscal: {{ $invoice->cif }}<br>
                            Nr. R.C.: {{ $invoice->rc }}<br>
                            Cod IBAN: {{ $invoice->bank_account }}<br>
                            Banca: {{ $invoice->bank_name }}<br>
                            Capital Social: 200 RON <br>
                        </td>
                        <td class="text-center">FACTURĂ PROFORMĂ <br>
                            Seria {{ $invoice->serie }} <br>
                            Nr. #{{ $order->id }} <br>
                            Data : {{ date_format($order->created_at,'d.m.Y') }}
                            <br><br>
                            Cota TVA: {{ $invoice->tva }}%
                        </td>
                        <td>
                            @if( $order->account_type == 1 )
                                Cumpărător: {{ $order->company }}<br>
                                Nr. R.C.: {{ $order->rc }} <br>
                                CIF: {{ $order->cif }} <br>
                                Cont bancar: {{ $order->bank_account }} <br>
                                Banca: {{ $order->bank_name }} <br>

                                @else
                                Cumpărător: {{ $order->name }}<br>
                                Judet: {{ $order->region }}<br>
                                Oras: {{ $order->city }}<br>
                            @endif
                            Adresa: {{ $order->address }}
                        </td>
                    </tr>
                    </tbody>
                </table>
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th class="text-center">Nr</th>
                    <th>Denumirea produselor sau a serviciilor</th>
                    <th class="text-center">U.M.</th>
                    <th class="text-center">Cantitatea</th>
                    <th class="text-center">Pretul unitar<br>(Fara TVA)</th>
                    <th class="text-center">Valoare<br>(LEI)</th>
                    <th class="text-center">Valoare TVA<br>(LEI)</th>
                </tr>
                </thead>
                <tbody>
                <tr style="color:#8c8c8c;">
                    <td class="text-center">0</td>
                    <td class="text-center">1</td>
                    <td class="text-center">2</td>
                    <td class="text-center">3</td>
                    <td class="text-center">4</td>
                    <td class="text-center">5 (3 X 4)</td>
                    <td class="text-center">6</td>
                </tr>
                @foreach($items as $item)
                    <tr>
                        <td class="text-center"></td>
                        <td>{{ $item['name'] }}</td>
                        <td class="text-center">-</td>
                        <td class="text-center">{{ $item['quantity'] }}</td>
                        <td class="text-center">{{ $item['priceNoVAT'] }}</td>
                        <td class="text-center">{{ $item['priceNoVAT']*$item['quantity'] }}</td>
                        <td class="text-center">{{ $item['VAT'] }}</td>
                    </tr>
                    @endforeach
                <tr>
                    <td class="text-center"></td>
                    <td>Transport</td>
                    <td class="text-center">-</td>
                    <td class="text-center">1</td>
                    <td class="text-center">{{ $transportNoVAT }}</td>
                    <td class="text-center">{{ $transportNoVAT }}</td>
                    <td class="text-center">{{ $transportVAT }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">Total</td>
                    <td class="text-center">{{ $itemsNoVAT }}</td>
                    <td class="text-center">{{ $itemsVAT }}</td>
                </tr>
                <tr>
                    <td colspan="5" class="text-right">Total de plata</td>
                    <td colspan="2" class="text-center">{{ $order->finalPrice() }} LEI</td>
                </tr>
                </tbody>
            </table>
            <button class="btn btn-default btn-sm" onclick="window.print();">Print</button>
        </div>
    </div>
</body>
</html>