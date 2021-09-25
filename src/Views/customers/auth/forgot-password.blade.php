@extends('vendor.upepo.layouts.app')
@section('content')
<div>
    {{ __('upepo::passwords.forgot') }}
</div>

@if(session('status'))
   <div>
       {{ session('status') }}
   </div>
@endif

<form method="POST" action="{{ route('password.email') }}" class="pure-form pure-form-aligned">
    @csrf
    <fieldset>
        <div class="pure-control-group">
            <label for="email">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" id="email">
            @if ($errors->has('email'))
                <span class="pure-form-message-inline">{{ $errors->first('email') }}</span>
            @endif
        </div>
        <div class="pure-controls">
            <input type="submit" class="pure-button pure-button-primary" value="{{ __('Email Password Reset Link') }}">
        </div>
    </fieldset>
</form>
@endsection
