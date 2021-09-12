@extends('vendor.upepo.layouts.app')
@section('header-assets')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
@endsection
@section('content')
    @if(session()->has('mesaj'))
        <br>
        <br>
        <div class="alert alert-success text-center" role="alert">
            {{ session()->get('mesaj') }}
        </div>
    @endif
<div class="panel panel-default">
    <div class="panel-heading"><h1>Cont nou</h1></div>
    <div class="panel-body">
<form class="form-horizontal" role="form" method="POST" action="{{ url('customer/register') }}">
            @csrf
            @method('POST')

            <h3>Date autentificare</h3>
            <hr>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
                <div class="col-md-6">
                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                    @if ($errors->has('email')) <span class="help-block"><strong>{{ $errors->first('email') }}</strong></span> @endif
                </div>
            </div>

            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="col-md-4 control-label">Password</label>
                <div class="col-md-6">
                    <input id="password" type="password" class="form-control" name="password" required>
                    @if ($errors->has('password')) <span class="help-block"><strong>{{ $errors->first('password') }}</strong></span> @endif
                </div>
            </div>

            <div class="form-group">
                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                <div class="col-md-6">
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
            </div>

            <h3>Tip cont</h3>
            <hr>
            <div class="form-group">
                <label for="account_type" class="col-sm-2 control-label">Tip cont :</label>
                <div class="col-sm-5">
                    <select name="account_type" id="account_type" class="form-control">
                        <option value="0">Persoana fizica</option>
                        <option value="1">Persoana juridica</option>
                    </select>
                    @if ($errors->has('account_type')) <span class="help-block"><strong>{{ $errors->first('account_type') }}</strong></span> @endif
                </div>
            </div>
            <h3>Date personale</h3>
            <hr>
{{--PERSOANA FIZICA--}}
    <div id="pers_fizica" @if(old('account_type') == 1) style="display:none;" @endif>
                <div class="form-group">
                    <label for="name" class="col-sm-2 control-label">Nume :</label>
                    <div class="col-sm-5">
                        <input type="text" name="name" id="name" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('name') }}">
                        @if ($errors->has('name')) <span class="help-block"><strong>{{ $errors->first('name') }}</strong></span> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">Telefon :</label>
                    <div class="col-sm-5">
                        <input type="text" name="phone" id="phone" class="form-control" placeholder="(doar cifre)" value="{{ old('phone') }}">
                        @if ($errors->has('phone')) <span class="help-block"><strong>{{ $errors->first('phone') }}</strong></span> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="cnp" class="col-sm-2 control-label">CNP :</label>
                    <div class="col-sm-5">
                        <input type="text" name="cnp" id="cnp" class="form-control" placeholder="(doar cifre)" value="{{ old('cnp') }}">
                        @if ($errors->has('cnp')) <span class="help-block"><strong>{{ $errors->first('cnp') }}</strong></span> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="region" class="col-sm-2 control-label">Judet :</label>
                    <div class="col-sm-5">
                        <input type="text" name="region" id="region" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('region') }}">
                        @if ($errors->has('region')) <span class="help-block"><strong>{{ $errors->first('region') }}</strong></span> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="city" class="col-sm-2 control-label">Oras :</label>
                    <div class="col-sm-5">
                        <input type="text" name="city" id="city" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('city') }}">
                        @if ($errors->has('city')) <span class="help-block"><strong>{{ $errors->first('city') }}</strong></span> @endif
                    </div>
                </div>
    </div>
{{--PERSOANA JURIDICA--}}
            <div id="pers_juridica" @if(old('account_type') == 0) style="display:none;" @endif>
                <div class="form-group">
                    <label for="company" class="col-sm-2 control-label">Companie :</label>
                    <div class="col-sm-5">
                        <input type="text" name="company" id="company" class="form-control" placeholder="(doar litere, cifre, spatii si cratima)" value="{{ old('company') }}">
                        @if ($errors->has('company')) <span class="help-block"><strong>{{ $errors->first('company') }}</strong></span> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="rc" class="col-sm-2 control-label">Nr. Reg. Com. :</label>
                    <div class="col-sm-5">
                        <input type="text" name="rc" id="rc" class="form-control" placeholder="(doar litere si cifre)" value="{{ old('rc') }}">
                        @if ($errors->has('rc')) <span class="help-block"><strong>{{ $errors->first('rc') }}</strong></span> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="cif" class="col-sm-2 control-label">CIF :</label>
                    <div class="col-sm-5">
                        <input type="text" name="cif" id="cif" class="form-control" placeholder="(doar cifre)" value="{{ old('cif') }}">
                        @if ($errors->has('cif')) <span class="help-block"><strong>{{ $errors->first('cif') }}</strong></span> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="bank_account" class="col-sm-2 control-label">Cont bancar :</label>
                    <div class="col-sm-5">
                        <input type="text" name="bank_account" id="bank_account" class="form-control" placeholder="(doar litere si cifre)" value="{{ old('bank_account') }}">
                        @if ($errors->has('bank_account')) <span class="help-block"><strong>{{ $errors->first('bank_account') }}</strong></span> @endif
                    </div>
                </div>
                <div class="form-group">
                    <label for="bank_name" class="col-sm-2 control-label">Nume banca :</label>
                    <div class="col-sm-5">
                        <input type="text" name="bank_name" id="bank_name" class="form-control" placeholder="(doar litere, spatii si cratima)" value="{{ old('bank_name') }}">
                        @if ($errors->has('bank_name')) <span class="help-block"><strong>{{ $errors->first('bank_name') }}</strong></span> @endif
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="address" class="col-sm-2 control-label">Nume banca :</label>
                <div class="col-sm-5">
                    <textarea name="address" id="address" cols="50" rows="3" class="form-control" placeholder="(adresa)"></textarea>
                    @if ($errors->has('address')) <span class="help-block"><strong>{{ $errors->first('address') }}</strong></span> @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <input type="submit" class="btn btn-primary" value="Creează cont">
                </div>
            </div>
</form>
    </div>
</div>
@endsection
@section('footer-assets')
<script src="{{ asset('assets/admin/vendors/upepo/js/account_type.js') }}"></script>
@endsection
