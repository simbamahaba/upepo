<!DOCTYPE html>
<html lang="ro">
<head>
    <title>Confirmare email</title>
<style>
    .link_div{
        min-height:50px;
        width:50%;
        text-align: center;
        padding: 20px 0;
        margin: 30px auto;
        border: 1px solid royalblue;
    }
    .top{
        text-align: center;
    }
    .top h3{
        color: royalblue;
    }
</style>
</head>
<body>
<div class="top">
    <h3>Salut, {{ $customerName }}</h3>
    <p>Iți mulțumim pentru înscrierea pe site-ul {{ $site_settings['site_name'] }}</p>
</div>

<div class="link_div">
    <p>Te rugăm să accesezi următorul link pentru a confirma adresa de mail:</p>
    <p><a href="{{ route('customer.confirmEmail', $emailToken) }}" target="_blank">Confirmă email</a></p>
    <br>
    <br>
    <p>Dacă nu poți accesa linkul de mai sus, copiază codul de mai jos (Ctrl+C) în url-ul browser-ului:</p>
    <p>{{ route('customer.confirmEmail', $emailToken) }}</p>
    <br>
    <p>Cu multă considerație,</p>
    <p>Echipa {{ $site_settings['site_name'] }}</p>
</div>
</body>
</html>
