@extends('vendor.upepo.layouts.app')
@section('content')
<div>
    {{ __('email.verify') }}
</div>

@if (session('status') == 'verification-link-sent')
    <div>
        {{ __('email.new_verification_link') }}
    </div>
@endif

<form method="POST" action="{{ route('verification.send') }}" class="pure-form">
@csrf
    <div class="pure-controls">
    <button type="submit" class="pure-button pure-button-primary">{{ __('email.resend_verification_link_btn') }}</button>
    </div>
</form>
@endsection
