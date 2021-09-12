@extends('vendor.upepo.layouts.app')
@section('content')
    @php
    $divClass = 'pure-control-group';
    $errorMsg = 'pure-form-message-inline';
    @endphp

<div style="max-width: 50%; margin:0 auto;">
    @if(session()->has('mesaj'))
        <p>{{ session()->get('mesaj') }}</p>
    @endif

<h2>Profil utilizator</h2>
        {{ date('d.m.Y H:i:s',session('auth.password_confirmed_at')) }}
        <ul>
            @if($customer->name)<li><em>{{ $customer->name }}</em></li>@endif
            @if($customer->email)<li><em>{{ $customer->email }}</em></li>@endif
        </ul>

<form action="{{ route('customer.update', [$customer->id]) }}" method="post" class="pure-form pure-form-aligned" id="profil">
@csrf @method('PUT')
<fieldset>

<div class="{{ $divClass }}">
    <label for="account_type">Tip cont :</label>
    <select name="account_type" id="account_type">
        <option value="0" @if($customer->account_type == 0) selected @endif>Persoana fizica</option>
        <option value="1" @if($customer->account_type == 1) selected @endif>Persoana juridica</option>
    </select>
    <x-decoweb::inputs.error-input :field="'account_type'"/>
</div>
<div id="pers_fizica" @if(old('account_type') == 1) style="display:none;" @endif>
    <div class="{{ $divClass }}">
        <label for="name">Nume :</label>
        <input type="text" name="name" value="{{ $customer->name }}" id="name">
        <x-decoweb::inputs.error-input :field="'name'"/>
    </div>
    <div class="{{ $divClass }}">
        <label for="phone">Telefon :</label>
        <input type="text" name="phone" id="phone" value="{{ $customer->phone }}">
        <x-decoweb::inputs.error-input :field="'phone'"/>
    </div>
    <div class="{{ $divClass }}">
        <label for="cnp">CNP :</label>
        <input type="text" name="cnp" id="cnp" value="{{ $customer->cnp }}">
        <x-decoweb::inputs.error-input :field="'cnp'"/>
    </div>
    <div class="{{ $divClass }}">
        <label for="region">Judet :</label>
        <input type="text" name="region" id="region" value="{{ $customer->region }}">
        <x-decoweb::inputs.error-input :field="'region'"/>
    </div>
    <div class="{{ $divClass }}">
        <label for="city">Oras :</label>
        <input type="text" name="city" id="city" value="{{ $customer->city }}">
        <x-decoweb::inputs.error-input :field="'city'"/>
    </div>
</div>
<div id="pers_juridica" @if(old('account_type') == 0) style="display:none;" @endif>
    <div class="{{ $divClass }}">
        <label for="company">Companie :</label>
         <input type="text" name="company" id="company" value="{{ $customer->company }}">
        <x-decoweb::inputs.error-input :field="'company'"/>
    </div>
    <div class="{{ $divClass }}">
        <label for="rc">Nr. Reg. Com. :</label>
        <input type="text" name="rc" id="rc" value="{{ $customer->rc }}">
        <x-decoweb::inputs.error-input :field="'rc'"/>
    </div>
    <div class="{{ $divClass }}">
        <label for="cif">CIF :</label>
        <input type="text" name="cif" id="cif" value="{{ $customer->cif }}">
        <x-decoweb::inputs.error-input :field="'cif'"/>
    </div>
    <div class="{{ $divClass }}">
        <label for="bank_account">Cont bancar :</label>
        <input type="text" name="bank_account" id="bank_account" value="{{ $customer->bank_account }}">
        <x-decoweb::inputs.error-input :field="'bank_account'"/>
    </div>
    <div class="{{ $divClass }}">
        <label for="bank_name">Nume banca :</label>
        <input type="text" name="bank_name" id="bank_name" value="{{ $customer->bank_name }}">
        <x-decoweb::inputs.error-input :field="'bank_name'"/>
    </div>
</div>
<div class="{{ $divClass }}">
    <label for="address">Adresa :</label>
    <textarea name="address" id="address">{{ $customer->address }}</textarea>
    <x-decoweb::inputs.error-input :field="'address'"/>
</div>
<div class="pure-controls">
    <input type="submit" class="pure-button pure-button-primary" value="Modifica">
</div>
</fieldset>
    </form>
    <a href="{{ url('customer/newPassword') }}" class="pure-button">Schimba parola</a>
    <a href="{{ url('customer/myOrders') }}" class="pure-button">Comenzile mele</a>
</div>
@endsection
@section('footer-assets')
<script src="{{ asset('assets/admin/vendors/upepo/js/account_type.js') }}"></script>
@endsection
