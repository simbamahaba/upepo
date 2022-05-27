<?php const NOERRORS = 1; ?>
@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Utilizatori @endsection
@section('section-content')

<form id="store_customer" action="{{ route('customer.store.backend') }}" method="POST" class="form-horizontal form-label-left">
@csrf @method('POST')
    <fieldset>
        <legend>Adăugare utilizator</legend>
        <div class="item form-group">
            <label for="account_type" class="col-form-label col-md-3 col-sm-3 label-align">Tip cont * :</label>
            <div class="col-md-6 col-sm-6">
                <select name="account_type" id="account_type" class="form-control input-sm" form="store_customer">
                    <option value="0">Persoană fizică</option>
                    <option value="1">Persoană juridică</option>
                </select>
                @if ($errors->has('account_type'))
                <span class="help-block"><strong>{{ $errors->first('account_type') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="item form-group @error('email') bad @enderror">
            <label for="email" class="col-form-label col-md-3 col-sm-3 label-align">Email * :</label>
            <div class="col-md-6 col-sm-6">
                <input type="email" name="email" id="email" class="form-control input-sm" form="store_customer" value="{{ old('email') }}" placeholder="Email address">
                @if ($errors->has('email'))
                <span class="help-block text-danger"><strong>{{ $errors->first('email') }}</strong></span>
                @endif
            </div>
        </div>
        <input type="hidden" name="length" value="6">
        <div class="item form-group @error('password') bad @enderror">
            <label for="password" class="col-form-label col-md-3 col-sm-3 label-align">Parola * :</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="password" id="password" form="store_customer" class="form-control" placeholder="(minim 6 caractere)">
            </div>
            <div class="col-sm-8">
                <input type="button" class="btn btn-success btn-sm" value="Generează" onClick="generate();" tabindex="2">
            </div>
            @if ($errors->has('password'))
            <span class="help-block text-danger"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </div>
        <div class="item form-group @error('password_confirmation') bad @enderror">
            <label for="password_confirmation" class="col-form-label col-md-3 col-sm-3 label-align">Confirma parola * :</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="password_confirmation" id="password_confirmation" form="store_customer" class="form-control" placeholder="">
            </div>
            @if ($errors->has('password_confirmation'))
                <span class="help-block text-danger"><strong>{{ $errors->first('password_confirmation') }}</strong></span>
            @endif
        </div>
        <div class="item form-group @error('phone') bad @enderror">
            <label for="phone" class="col-form-label col-md-3 col-sm-3 label-align">Telefon :</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="phone" id="phone" form="store_customer" class="form-control" placeholder="(doar cifre)" value="{{ old('phone') }}">
                @if ($errors->has('phone'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('phone') }}</strong></span>
                @endif
            </div>
        </div>
{{--PERSOANA FIZICA--}}
        <div id="pers_fizica" @if(old('account_type') == 1) style="display:none;" @endif>
            <div class="item form-group @error('name') bad @enderror">
                <label for="name" class="col-form-label col-md-3 col-sm-3 label-align">Nume :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="name" id="name" form="store_customer" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('name') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="item form-group @error('cnp') bad @enderror">
                <label for="cnp" class="col-form-label col-md-3 col-sm-3 label-align">CNP :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="cnp" id="cnp" form="store_customer" class="form-control" placeholder="(doar cifre)" value="{{ old('cnp') }}">
                    @if ($errors->has('cnp'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('cnp') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="item form-group">
                <label for="region" class="col-form-label col-md-3 col-sm-3 label-align">Județ :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="region" id="region" form="store_customer" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('region') }}">
                    @if ($errors->has('region'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('region') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="item form-group">
                <label for="city" class="col-form-label col-md-3 col-sm-3 label-align">Oraș :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="city" id="city" form="store_customer" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('city') }}">
                    @if ($errors->has('city'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('city') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

{{--PERSOANA JURIDICA--}}
        <div id="pers_juridica" @if(old('account_type') == 0) style="display:none;" @endif>
            <div class="item form-group">
                <label for="company" class="col-form-label col-md-3 col-sm-3 label-align">Companie :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="company" id="company" form="store_customer" class="form-control" placeholder="(doar litere, cifre, spatii si cratima)" value="{{ old('company') }}">
                    @if ($errors->has('company'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('company') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="item form-group">
                <label for="rc" class="col-form-label col-md-3 col-sm-3 label-align">Nr. Reg. Com. :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="rc" id="rc" form="store_customer" class="form-control" placeholder="(doar litere si cifre)" value="{{ old('rc') }}">
                    @if ($errors->has('rc'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('rc') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="item form-group">
                <label for="cif" class="col-form-label col-md-3 col-sm-3 label-align">CIF :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="cif" id="cif" form="store_customer" class="form-control" placeholder="(doar cifre)" value="{{ old('cif') }}">
                    @if ($errors->has('cif'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('cif') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="item form-group">
                <label for="bank_account" class="col-form-label col-md-3 col-sm-3 label-align">Cont bancar :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="bank_account" id="bank_account" form="store_customer" class="form-control" placeholder="(doar litere si cifre)" value="{{ old('bank_account') }}">
                    @if ($errors->has('bank_account'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('bank_account') }}</strong></span>
                    @endif
                </div>
            </div>
            <div class="item form-group">
                <label for="bank_name" class="col-form-label col-md-3 col-sm-3 label-align">Nume bancă :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="bank_name" id="bank_name" form="store_customer" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('bank_name') }}">
                    @if ($errors->has('bank_name'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('bank_name') }}</strong></span>
                    @endif
                </div>
            </div>
        </div>

        <div class="item form-group">
            <label for="address" class="col-form-label col-md-3 col-sm-3 label-align">Adresa :</label>
            <div class="col-md-6 col-sm-6">
                <textarea name="address" id="address" form="store_customer" cols="50" rows="3" class="form-control" placeholder="(adresa)"></textarea>
                @if ($errors->has('address'))
                    <span class="help-block text-danger"><strong>{{ $errors->first('address') }}</strong></span>
                @endif
            </div>
        </div>
        <div class="item form-group">
            <div class="col-md-6 col-sm-6  offset-md-3">
                <div class="checkbox">
                    <label class="col-form-label">
                        <input type="checkbox" form="store_customer" value="1" name="verified" checked> Activ
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="col-md-6 col-sm-6 offset-md-3">
                <div class="checkbox">
                    <label class="col-form-label">
                        <input type="checkbox" form="store_customer" value="1" name="notify"> Notifica utilizator
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="col-md-6 col-sm-6 offset-md-3">
                <input type="submit" form="store_customer" class="btn btn-primary" value="Salvează">
            </div>
        </div>
    </fieldset>
</form>

@endsection
@section('footer-assets')
<script>
function randomPassword(length) {
    let chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOP1234567890";
    let pass = "";
    for (let x = 0; x < length; x++) {
        let i = Math.floor(Math.random() * chars.length);
        pass += chars.charAt(i);
    }
    return pass;
}

function generate() {
    store_customer.password.value = randomPassword(store_customer.length.value);
}
</script>
<script src="{{ asset('assets/admin/vendors/upepo/js/account_type.js') }}"></script>
@endsection
