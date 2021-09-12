<?php const NOERRORS = 1; ?>
@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Profil @endsection
@section('section-content')

<form action="{{ route('admin.update.password', $user->id) }}" method="post" class="form-horizontal form-label-left">
    @csrf @method('PUT')
    <div class="item form-group @error('password') bad @enderror">
        <label for="password" class="col-form-label col-md-3 col-sm-3 label-align">Parola nouă *</label>
        <div class="col-md-6 col-sm-6">
            <input type="password" name="password" id="password" class="form-control" placeholder="New Password">
            @if ($errors->has('password'))
                <span class="help-block text-danger"><strong>{{ $errors->first('password') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="item form-group @error('passwordAgain') bad @enderror">
        <label for="passwordAgain" class="col-form-label col-md-3 col-sm-3 label-align">Retastează parola *</label>
        <div class="col-md-6 col-sm-6">
            <input type="password" name="passwordAgain" id="passwordAgain" class="form-control" placeholder="Re-type Password">
            @if ($errors->has('passwordAgain'))
                <span class="help-block text-danger"><strong>{{ $errors->first('passwordAgain') }}</strong></span>
            @endif
        </div>
    </div>
    <div class="item form-group">
        <div class="col-md-6 col-sm-6 offset-md-3">
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </div>
</form>
@endsection
