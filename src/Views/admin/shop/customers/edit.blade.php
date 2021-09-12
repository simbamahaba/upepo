<?php define('NOERRORS',1); ?>
@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Utilizatori @endsection
@section('section-content')
    {{--{{ $customer->orders[0]->items[0]->name }}
    {{ $customer->orders[0]->items[0]->price }}--}}
<form action="{{ route('customer.update.backend', [$customer->id]) }}" method="POST" class="form-horizontal form-label-left" id="myform">
@csrf @method("PUT")
    <fieldset>
        @php $name = ( !empty($customer->email) )?$customer->email:$customer->name; @endphp
        <legend>
            Utilizator: <strong class="text-dark">{{ $name }}</strong><br>
            Comenzi : <strong class="text-dark">{{ count($customer->orders) }}</strong>
        </legend>
        <div class="item form-group @error('account_type') bad @enderror">
            <label for="account_type" class="col-form-label col-md-3 col-sm-3 label-align">Tip cont * :</label>
            <div class="col-md-6 col-sm-6">
                <select name="account_type" id="account_type" class="form-control">
                    <option value="0" @php echo ($customer->account_type == 0)?'selected':'' @endphp >Persoana fizica</option>
                    <option value="1" @php echo ($customer->account_type == 1)?'selected':'' @endphp >Persoana juridica</option>
                </select>
                @if ($errors->has('account_type')) <span class="help-block text-danger"><strong>{{ $errors->first('account_type') }}</strong></span> @endif
            </div>
        </div>
        <div class="item form-group @error('email') bad @enderror">
            <label for="email" class="col-form-label col-md-3 col-sm-3 label-align">Email * :</label>
            <div class="col-md-6 col-sm-6">
                <input type="email" name="email" id="email" class="form-control input-sm" value="{{ $customer->email }}" placeholder="Email">
                @if ($errors->has('email')) <span class="help-block text-danger"><strong>{{ $errors->first('email') }}</strong></span> @endif
            </div>
        </div>
        <div class="item form-group @error('phone') bad @enderror">
            <label for="phone" class="col-form-label col-md-3 col-sm-3 label-align">Telefon * :</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="phone" id="phone" class="form-control input-sm" value="{{ $customer->phone }}" placeholder="(doar cifre)">
                @if ($errors->has('phone')) <span class="help-block text-danger"><strong>{{ $errors->first('phone') }}</strong></span> @endif
            </div>
        </div>
{{--PERSOANA FIZICA - EDIT--}}
        <div id="pers_fizica" @if(old('account_type') == 1) style="display:none;" @endif>
            <div class="item form-group @error('name') bad @enderror">
                <label for="name" class="col-form-label col-md-3 col-sm-3 label-align">Nume * :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="name" id="name" class="form-control input-sm" value="{{ $customer->name }}" placeholder="(doar litere, spatii si cratima)">
                    @if ($errors->has('name')) <span class="help-block text-danger"><strong>{{ $errors->first('name') }}</strong></span> @endif
                </div>
            </div>
            <div class="item form-group @error('cnp') bad @enderror">
                <label for="cnp" class="col-form-label col-md-3 col-sm-3 label-align">CNP * :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="cnp" id="cnp" class="form-control input-sm" value="{{ $customer->cnp }}" placeholder="(doar cifre)">
                    @if ($errors->has('cnp')) <span class="help-block text-danger"><strong>{{ $errors->first('cnp') }}</strong></span> @endif
                </div>
            </div>
            <div class="item form-group @error('region') bad @enderror">
                <label for="region" class="col-form-label col-md-3 col-sm-3 label-align">Județ * :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="region" id="region" class="form-control input-sm" value="{{ $customer->region }}" placeholder="(doar litere, spatii si cratima)">
                    @if ($errors->has('region')) <span class="help-block text-danger"><strong>{{ $errors->first('region') }}</strong></span> @endif
                </div>
            </div>
            <div class="item form-group @error('city') bad @enderror">
                <label for="city" class="col-form-label col-md-3 col-sm-3 label-align">Oraș * :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="city" id="city" class="form-control input-sm" value="{{ $customer->city }}" placeholder="(doar litere, spatii si cratima)">
                    @if ($errors->has('city')) <span class="help-block text-danger"><strong>{{ $errors->first('city') }}</strong></span> @endif
                </div>
            </div>
        </div>
{{--PERSOANA JURIDICA - EDIT--}}
        <div id="pers_juridica" @if(old('account_type') == 0) style="display:none;" @endif>
            <div class="item form-group @error('company') bad @enderror">
                <label for="company" class="col-form-label col-md-3 col-sm-3 label-align">Companie * :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="company" id="company" class="form-control input-sm" value="{{ $customer->company }}" placeholder="(doar litere, cifre, spatii si cratima)">
                    @if ($errors->has('company')) <span class="help-block text-danger"><strong>{{ $errors->first('company') }}</strong></span> @endif
                </div>
            </div>
            <div class="item form-group @error('rc') bad @enderror">
                <label for="rc" class="col-form-label col-md-3 col-sm-3 label-align">Nr. Reg. Com. :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="rc" id="rc" class="form-control input-sm" value="{{ $customer->rc }}" placeholder="(doar litere si cifre)">
                    @if ($errors->has('rc')) <span class="help-block text-danger"><strong>{{ $errors->first('rc') }}</strong></span> @endif
                </div>
            </div>
            <div class="item form-group @error('cif') bad @enderror">
                <label for="cif" class="col-form-label col-md-3 col-sm-3 label-align">CIF :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="cif" id="cif" class="form-control input-sm" value="{{ $customer->cif }}" placeholder="(doar cifre)">
                    @if ($errors->has('cif')) <span class="help-block text-danger"><strong>{{ $errors->first('cif') }}</strong></span> @endif
                </div>
            </div>
            <div class="item form-group @error('bank_account') bad @enderror">
                <label for="bank_account" class="col-form-label col-md-3 col-sm-3 label-align">Cont bancar :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="bank_account" id="bank_account" class="form-control input-sm" value="{{ $customer->bank_account }}" placeholder="(doar litere si cifre)">
                    @if ($errors->has('bank_account')) <span class="help-block text-danger"><strong>{{ $errors->first('bank_account') }}</strong></span> @endif
                </div>
            </div>
            <div class="item form-group @error('bank_name') bad @enderror">
                <label for="bank_name" class="col-form-label col-md-3 col-sm-3 label-align">Nume bancă :</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="bank_name" id="bank_name" class="form-control input-sm" value="{{ $customer->bank_name }}" placeholder="(doar litere, spatii si cratima)">
                    @if ($errors->has('bank_name')) <span class="help-block text-danger"><strong>{{ $errors->first('bank_name') }}</strong></span> @endif
                </div>
            </div>
        </div>
        <div class="item form-group @error('address') bad @enderror">
            <label for="address" class="col-form-label col-md-3 col-sm-3 label-align">Adresa :</label>
            <div class="col-md-6 col-sm-6">
                <textarea name="address" id="address" cols="50" rows="3" class="form-control input-sm" placeholder="(adresa)">{{ $customer->address }}</textarea>
                @if ($errors->has('address')) <span class="help-block text-danger"><strong>{{ $errors->first('address') }}</strong></span> @endif
            </div>
        </div>
        <div class="item form-group">
            <div class="col-md-6 col-sm-6 offset-md-3">
                <div class="checkbox">
                    <label>
                        <?php $checked = ( !$customer->email_verified_at )?:'checked'; ?>
                        <input type="checkbox" value="1" name="verified" {{ $checked }}> Activ
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="col-md-6 col-sm-6 offset-md-3">
                <input type="submit" class="btn btn-primary" value="Salvează">
            </div>
        </div>
    </fieldset>
</form>
@endsection
@section('footer-assets')
<script src="{{ asset('assets/admin/vendors/upepo/js/account_type.js') }}"></script>
@endsection
