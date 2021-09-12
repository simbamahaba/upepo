@extends('vendor.upepo.layouts.app')

@section('content')
    @if(session()->has('mesaj'))
        <div class="alert alert-success text-center" role="alert">
            {{ session()->get('mesaj') }}
        </div>
    @endif
<h3>Pasul 3</h3> @if($customer->email) {{ $customer->email }} @endif
<hr>
{!! Form::open(['method'=>'POST','url'=>'cart/storeOrder','class'=>'form-horizontal','id'=>'profil']) !!}
    <h4>Modalitate transport</h4>
<div class="form-group">
    {!! Form::label('transport','Transport:',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::select('transport',$transport ,null,['class'=>'form-control','id'=>'transport']) !!}
        @if ($errors->has('transport'))
            <span class="help-block">
                <strong>{{ $errors->first('transport') }}</strong>
            </span>
        @endif
    </div>
</div>
    <h4>Doresc emiterea facturii pe:</h4>
<div class="form-group">
    {!! Form::label('account_type','Tip :',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::select('account_type',[0=>'Persoana fizica',1=>'Persoana juridica'] ,$customer->account_type,['class'=>'form-control','id'=>'account_type']) !!}
        @if ($errors->has('account_type'))
            <span class="help-block">
                <strong>{{ $errors->first('account_type') }}</strong>
            </span>
        @endif
    </div>
</div>

<div id="pers_fizica" @if(old('account_type') == 1) style="display:none;" @endif>
    <h4>Detalii personale</h4>
    <div class="form-group">
        {!! Form::label('name','Nume :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('name', $customer->name, ['class'=>'form-control', 'id'=>'name','placeholder'=>'']) !!}
            @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('phone','Telefon :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('phone', $customer->phone, ['class'=>'form-control', 'id'=>'phone','placeholder'=>'']) !!}
            @if ($errors->has('phone'))
                <span class="help-block">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('cnp','CNP :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('cnp', $customer->cnp, ['class'=>'form-control', 'id'=>'cnp','placeholder'=>'']) !!}
            @if ($errors->has('cnp'))
                <span class="help-block">
                    <strong>{{ $errors->first('cnp') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('region','Judet :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('region', $customer->region, ['class'=>'form-control', 'id'=>'region','placeholder'=>'']) !!}
            @if ($errors->has('region'))
                <span class="help-block">
                    <strong>{{ $errors->first('region') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('city','Oras :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('city', $customer->city, ['class'=>'form-control', 'id'=>'city','placeholder'=>'']) !!}
            @if ($errors->has('city'))
                <span class="help-block">
                    <strong>{{ $errors->first('city') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div id="pers_juridica" @if(old('account_type') == 0) style="display:none;" @endif>
    <h4>Companie</h4>
    <div class="form-group">
        {!! Form::label('company','Companie :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('company', $customer->company, ['class'=>'form-control', 'id'=>'company','placeholder'=>'']) !!}
            @if ($errors->has('company'))
                <span class="help-block">
                    <strong>{{ $errors->first('company') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('rc','Nr. Reg. Com. :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('rc', $customer->rc, ['class'=>'form-control', 'id'=>'rc','placeholder'=>'']) !!}
            @if ($errors->has('rc'))
                <span class="help-block">
                    <strong>{{ $errors->first('rc') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('cif','CIF :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('cif', $customer->cif, ['class'=>'form-control', 'id'=>'cif','placeholder'=>'']) !!}
            @if ($errors->has('cif'))
                <span class="help-block">
                    <strong>{{ $errors->first('cif') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('bank_account','Cont bancar :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('bank_account', $customer->bank_account, ['class'=>'form-control', 'id'=>'bank_account','placeholder'=>'']) !!}
            @if ($errors->has('bank_account'))
                <span class="help-block">
                    <strong>{{ $errors->first('bank_account') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('bank_name','Nume banca :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::text('bank_name', $customer->bank_name, ['class'=>'form-control', 'id'=>'bank_name','placeholder'=>'']) !!}
            @if ($errors->has('bank_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('bank_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="form-group">
    {!! Form::label('email','Email :',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::email('email', $customer->email, ['class'=>'form-control', 'id'=>'email','placeholder'=>'']) !!}
        @if ($errors->has('email'))
            <span class="help-block">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
        @endif
    </div>
</div>
<div class="form-group">
    {!! Form::label('address','Adresa :',['class'=>'col-sm-2 control-label']) !!}
    <div class="col-sm-5">
        {!! Form::textarea('address', $customer->address, ['class'=>'form-control', 'id'=>'address','placeholder'=>'']) !!}
        @if ($errors->has('address'))
            <span class="help-block">
                <strong>{{ $errors->first('address') }}</strong>
            </span>
        @endif
    </div>
</div>
<h4>Adresa de livrare</h4>
    <div class="form-group">
        <div class="col-sm-offset-2 col-sm-10">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value="1" name="same_address"> Coincide cu adresa de facturare.
                </label>
            </div>
        </div>
    </div>
    <div class="form-group">
        {!! Form::label('adresa_livrare','Adresa livrare :',['class'=>'col-sm-2 control-label']) !!}
        <div class="col-sm-5">
            {!! Form::textarea('delivery_address', null, ['class'=>'form-control', 'id'=>'adresa_livrare','placeholder'=>'']) !!}
            @if ($errors->has('delivery_address'))
                <span class="help-block">
                <strong>{{ $errors->first('delivery_address') }}</strong>
            </span>
            @endif
        </div>
    </div>
<div class="form-group">
    <div class="col-sm-5 col-sm-offset-2">
        {!! Form::submit('Trimite comanda', ['class'=>'btn btn-primary']) !!}
    </div>
</div>
{!! Form::close() !!}
@endsection
@section('footer-assets')
<script>
    $(document).ready(function(){
        var $account = $("#account_type");
        var $fizica = $("#pers_fizica");
        var $juridica = $("#pers_juridica");
        $account.change(function(){
            switch( $account.val() ){
                case '0':   $fizica.show();
                            $juridica.hide();
                    break;
                case '1':   $fizica.hide();
                            $juridica.show();
                    break;
            }
        });
        var type = $account.val();
        if( type == 1){
            $fizica.hide();
            $juridica.show();
        }
    });
</script>
@endsection