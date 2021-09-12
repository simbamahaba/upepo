<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Comanda noua</title>
</head>
<body>
Buna ziua,
@if( $toAdmin === true )
    <p>
        Statusul comenzii numarul <strong>{{ $orderId }}</strong> a fost schimbat.<br>
        Mesajul de mai jos a fost trimis clientului.
    </p>
    <p>-----------------------</p>
@endif
<p>Va multumim pentru alegerea facuta.</p>
<p>Comanda dumneavoastra numarul {{ $orderId }} a fost: <a href="{{ url('customer/myOrders/') }}">VERIFICA STATUSUL COMENZII AICI</a></p>
<p>Daca nu puteti accesa linkul de mai sus, copiati codul de mai jos (Ctrl+C) in url-ul browser-ului:</p>
<p>{{ url('customer/myOrders/') }}</p>
<br>
<p>Cu multa consideratie,</p>
<p>Echipa {{ $site_settings['site_name'] }}</p>
</body>
</html>