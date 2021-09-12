<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Comanda noua</title>
</head>
<body>
Buna ziua,
@if( $toAdmin === true )
    <p>
        Aveti o comanda noua efectuata de <strong>{{ $name }}</strong>.<br>
        Mesajul de mai jos a fost trimis clientului.
    </p>
    <p>-----------------------</p>
@endif
<p>Va multumim pentru comanda efectuata. In curand va vom contacta pentru a discuta detaliile comenzii.</p>
<p>Puteti vizualiza factura proforma aici: <a href="{{ url($invoiceUrl) }}">Proforma</a></p>
<p>Daca nu puteti accesa linkul de mai sus, copiati codul de mai jos (Ctrl+C) in url-ul browser-ului:</p>
<p>{{ url($invoiceUrl) }}</p>
<br>
<p>Cu multa consideratie,</p>
<p>Echipa {{ $site_settings['site_name'] }}</p>
</body>
</html>