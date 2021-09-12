@extends('vendor.upepo.layouts.app')
@section('content')

<div>
    {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
</div>

@if ($errors->any())
<ul>
@foreach ($errors->all() as $error)
    <li>{{ $error }}</li>
@endforeach
</ul>
@endif

<form method="POST" action="{{ route('password.confirm') }}" class="pure-form">
@csrf
    <fieldset>
        <label for="password">{{ __('Password') }}</label>
        <input type="password" id="password" name="password" required autocomplete="current-password">
        <button type="submit" class="pure-button pure-button-primary">{{ __('Confirm') }}</button>
    </fieldset>
</form>
@endsection
