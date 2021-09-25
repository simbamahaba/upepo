@extends('vendor.upepo.layouts.app')
@section('content')
    @php
        $divClass = 'pure-control-group';
        $errorMsg = 'pure-form-message-inline';
    @endphp
    @if(session()->has('mesaj'))
        <div role="alert">
            {{ session()->get('mesaj') }}
        </div>
    @endif

    <h2>Cont nou</h2>

    <form method="POST" action="{{ route('customer.register') }}" class="pure-form pure-form-aligned" role="form" >
        @csrf @method('POST')

        <h3>Date autentificare</h3>
        <hr>
        <div class="{{ $divClass }}">
            <label for="email">Email *</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            <x-upepo::inputs.error-input :field="'email'"/>
        </div>
        <div class="{{ $divClass }}">
            <label for="password">Password *</label>
            <input id="password" type="password" name="password" required>
            <x-upepo::inputs.error-input :field="'password'"/>
        </div>
        <div class="{{ $divClass }}">
            <label for="password-confirm">Confirm Password *</label>
            <input id="password-confirm" type="password" name="password_confirmation" required>
        </div>

        <h3>Tip cont</h3>
        <hr>
        <div class="{{ $divClass }}">
            <label for="account_type">Tip cont *</label>
            <select name="account_type" id="account_type" required>
                <option value="0">Persoana fizica</option>
                <option value="1">Persoana juridica</option>
            </select>
            <x-upepo::inputs.error-input :field="'account_type'"/>
        </div>
        <h3>Date personale</h3>
        <hr>
        {{--PERSOANA FIZICA--}}
        <div id="pers_fizica" @if(old('account_type') == 1) style="display:none;" @endif>
            <div class="{{ $divClass }}">
                <label for="name">Nume *</label>
                <input type="text" name="name" id="name" placeholder="(doar litere, spatii si cratima)" value="{{ old('name') }}">
                <x-upepo::inputs.error-input :field="'name'"/>
            </div>
            <div class="{{ $divClass }}">
                <label for="phone">Telefon *</label>
                <input type="text" name="phone" id="phone" placeholder="(doar cifre)" value="{{ old('phone') }}">
                <x-upepo::inputs.error-input :field="'phone'"/>
            </div>
            <div class="{{ $divClass }}">
                <label for="cnp">CNP *</label>
                <input type="text" name="cnp" id="cnp" placeholder="(doar cifre)" value="{{ old('cnp') }}">
                <x-upepo::inputs.error-input :field="'cnp'"/>
            </div>
            <div class="{{ $divClass }}">
                <label for="region">Judet *</label>
                <input type="text" name="region" id="region" placeholder="(doar litere, spatii si cratima)" value="{{ old('region') }}">
                <x-upepo::inputs.error-input :field="'region'"/>
            </div>
            <div class="{{ $divClass }}">
                <label for="city">Oras *</label>
                <input type="text" name="city" id="city" placeholder="(doar litere, spatii si cratima)" value="{{ old('city') }}">
                <x-upepo::inputs.error-input :field="'city'"/>
            </div>
        </div>
        {{--PERSOANA JURIDICA--}}
        <div id="pers_juridica" @if(old('account_type') == 0) style="display:none;" @endif>
            <div class="{{ $divClass }}">
                <label for="company" >Companie *</label>
                <input type="text" name="company" id="company" placeholder="(doar litere, cifre, spatii si cratima)" value="{{ old('company') }}">
                <x-upepo::inputs.error-input :field="'company'"/>
            </div>
            <div class="{{ $divClass }}">
                <label for="rc">Nr. Reg. Com. *</label>
                <input type="text" name="rc" id="rc" class="form-control" placeholder="(doar litere si cifre)" value="{{ old('rc') }}">
                <x-upepo::inputs.error-input :field="'rc'"/>
            </div>
            <div class="{{ $divClass }}">
                <label for="cif">CIF *</label>
                <input type="text" name="cif" id="cif" class="form-control" placeholder="(doar cifre)" value="{{ old('cif') }}">
                <x-upepo::inputs.error-input :field="'cif'"/>
            </div>
            <div class="{{ $divClass }}">
                <label for="bank_account">Cont bancar *</label>
                <input type="text" name="bank_account" id="bank_account" class="form-control" placeholder="(doar litere si cifre)" value="{{ old('bank_account') }}">
                <x-upepo::inputs.error-input :field="'bank_account'"/>
            </div>
            <div class="{{ $divClass }}">
                <label for="bank_name" >Nume banca *</label>
                <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('bank_name') }}">
                <x-upepo::inputs.error-input :field="'bank_name'"/>
            </div>
        </div>
        <div class="{{ $divClass }}">
            <label for="address" ">Adresa :</label>
            <textarea name="address" id="address" cols="50" rows="3" class="form-control" placeholder="(adresa)"></textarea>
            <x-upepo::inputs.error-input :field="'address'"/>
        </div>
        <div class="pure-controls">
            <input type="submit" class="pure-button pure-button-primary" value="Creează cont">
        </div>

    </form>
@endsection
@section('footer-assets')
    <script src="{{ asset('assets/admin/vendors/upepo/js/account_type.js') }}"></script>
@endsection

