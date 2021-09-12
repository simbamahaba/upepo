<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="none">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin login</title>
    <link href="{{ asset('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/build/css/custom.min.css') }}" rel="stylesheet">
</head>
<body class="login">

<div class="login_wrapper">
<div class="animate form login_form">
<section class="login_content">
<form role="form" method="POST" action="{{ route('admin.login') }}">
{{ csrf_field() }}
<h1>Admin</h1>
<div>
@if ($errors->has('email'))
<span class="help-block">
<strong>{{ $errors->first('email') }}</strong>
</span>
@endif
<input name="email" type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" required="" />
</div>
<div>
<input name="password" type="password" class="form-control" placeholder="Password" required="" />
@if ($errors->has('password'))
<span class="help-block">
<strong>{{ $errors->first('password') }}</strong>
</span>
@endif
</div>
<div><input class="btn btn-success btn-block" type="submit" value="Log in" style="margin-left: initial; float: initial;"></div>
</form>
</section>
</div>
</div>

</body>
</html>
