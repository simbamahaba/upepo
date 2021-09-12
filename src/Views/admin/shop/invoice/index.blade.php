<?php define('NOERRORS',1); ?>
@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Setări factură @endsection
@section('section-content')
    @php
    $label_class = 'class="col-form-label col-md-3 col-sm-3 label-align"';
    $div_input_class = 'class="col-md-6 col-sm-6"';
    @endphp

    <form action="{{ route('invoice.update', [$invoice->id]) }}" method="POST" class="form-horizontal">
        @csrf
        @method('PUT')
    <div class="item form-group @error('bank_name') bad @enderror">
        <label for="bank_name" {!! $label_class !!}>Banca</label>
        <div {!! $div_input_class !!}>
            <input type="text" name="bank_name" value="{{ $invoice->bank_name }}" id="bank_name" placeholder="Bank name" class="form-control">
            @error('bank_name')
            <span class="text-danger"><strong>{{ $errors->first('bank_name') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('cif') bad @enderror">
        <label for="cif" {!! $label_class !!}>CIF</label>
        <div {!! $div_input_class !!}>
            <input type="text" name="cif" value="{{ $invoice->cif }}" id="cif" placeholder="CIF" class="form-control">
            @error('cif')
            <span class="text-danger"><strong>{{ $errors->first('cif') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('bank_account') bad @enderror">
        <label for="bank_account" {!! $label_class !!}>Cont bancar</label>
        <div {!! $div_input_class !!}>
            <input type="text" name="bank_account" value="{{ $invoice->bank_account }}" id="bank_account" placeholder="Bank Account" class="form-control">
            @error('bank_account')
            <span class="text-danger"><strong>{{ $errors->first('bank_account') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('company') bad @enderror">
        <label for="company" {!! $label_class !!}>Furnizor</label>
        <div {!! $div_input_class !!}>
            <input type="text" name="company" value="{{ $invoice->company }}" id="company" placeholder="Company" class="form-control">
            @error('company')
            <span class="text-danger"><strong>{{ $errors->first('company') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('region') bad @enderror">
        <label for="region" {!! $label_class !!}>Judet</label>
        <div {!! $div_input_class !!}>
            <input type="text" name="region" value="{{ $invoice->region }}" id="region" placeholder="Region" class="form-control">
            @error('region')
            <span class="text-danger"><strong>{{ $errors->first('region') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('city') bad @enderror">
        <label for="city" {!! $label_class !!}>Oras</label>
        <div {!! $div_input_class !!}>
            <input type="text" name="city" value="{{ $invoice->city }}" id="city" placeholder="City" class="form-control">
            @error('city')
            <span class="text-danger"><strong>{{ $errors->first('city') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('rc') bad @enderror">
        <label for="rc" {!! $label_class !!}>Nr R.C.</label>
        <div {!! $div_input_class !!}>
            <input type="text" name="rc" value="{{ $invoice->rc }}" id="rc" placeholder="Nr R.C." class="form-control">
            @error('rc')
            <span class="text-danger"><strong>{{ $errors->first('rc') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('address') bad @enderror">
        <label for="address" {!! $label_class !!}>Sediu social</label>
        <div {!! $div_input_class !!}>
            <textarea name="address" id="address" rows="3" class="form-control" placeholder="Address">{{ $invoice->address }}</textarea>
            @error('address')
            <span class="text-danger"><strong>{{ $errors->first('address') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('serie') bad @enderror">
        <label for="serie" {!! $label_class !!}>Serie factura</label>
        <div {!! $div_input_class !!}>
            <input type="text" name="serie" value="{{ $invoice->serie }}" id="serie" placeholder="Serie factură" class="form-control">
            @error('serie')
            <span class="text-danger"><strong>{{ $errors->first('serie') }}</strong></span>
            @enderror
        </div>
    </div>
    <div class="item form-group @error('tva') bad @enderror">
        <label for="tva" {!! $label_class !!}>TVA</label>
        <div {!! $div_input_class !!}>
            <div class="input-group">
                <input type="text" name="tva" value="{{ $invoice->tva }}" id="tva" placeholder="VAT" class="form-control">
                <span class="fa fa-percent form-control-feedback right" aria-hidden="true"></span>
            </div>
            @error('tva')
            <span class="text-danger"><strong>{{ $errors->first('tva') }}</strong></span>
            @enderror
        </div>
    </div>
        <div class="item form-group">
            <div class="col-md-6 col-sm-6 offset-md-3">
        <input type="submit" class="btn btn-success" value="Submit">
    </div>
        </div>
    </form>
@endsection
