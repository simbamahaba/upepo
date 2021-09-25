@extends('vendor.upepo.layouts.app')
@section('content')
    @php
        $divClass = 'pure-control-group';
        $errorMsg = 'pure-form-message-inline';
    @endphp
<h2>{{ __('upepo::auth.signin') }}</h2>

<form method="POST" action="{{ url('customer/login') }}"  class="pure-form pure-form-aligned" role="form" >
    @csrf
    <fieldset>
        <div class="{{ $divClass }}">
            <label for="email"> Email</label>
            <input id="email" type="text" name="email" value="{{ old('email') }}" required>
            <x-upepo::inputs.error-input :field="'email'"/>
        </div>

        <div class="{{ $divClass }}">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required>
            <x-upepo::inputs.error-input :field="'password'"/>
        </div>
        <div class="pure-controls">
            <button class="pure-button pure-button-primary" type="submit" value="submit">Log in</button>
        </div>
    </fieldset>
</form>
<a class="pure-button" href="{{ route('password.request') }}">{{ __('upepo::passwords.forgotask') }}</a>
<a class="pure-button" href="{{ route('customer.showRegistrationForm') }}">Cont nou</a>
<hr>
<a class="pure-button pure-button-primary" href="{{ url('auth/facebook') }}">Facebook Login</a>
<x-upepo::inputs.error-input :field="'fberror'"/>
@endsection