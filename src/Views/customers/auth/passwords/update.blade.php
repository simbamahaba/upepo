@extends('vendor.upepo.layouts.app')

@section('content')
    <h3>Schimbare parola</h3>

@if (session('status'))
    <div>
        {{ session('status') }}
    </div>
@endif

<form class="pure-form pure-form-aligned" role="form" method="POST" action="{{ route('customer.updatePassword',Auth::guard('customer')->user()->id ) }}">
@csrf @method('POST')
<fieldset>
    <div class="pure-control-group">
        <label for="password">Parola noua</label>
        <input id="password" type="password" class="form-control" name="password" required>
        @if ($errors->has('password'))
        <span class="pure-form-message-inline">{{ $errors->first('password') }}</span>
        @endif
    </div>

    <div class="pure-control-group">
        <label for="password-confirm" >Repeta parola</label>
        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
        @if ($errors->has('password_confirmation'))
        <span class="pure-form-message-inline">{{ $errors->first('password_confirmation') }}</span>
        @endif
    </div>
    <div class="pure-controls">
        <button type="submit" class="pure-button pure-button-primary">Schimba</button>
    </div>
</fieldset>
</form>
@endsection
