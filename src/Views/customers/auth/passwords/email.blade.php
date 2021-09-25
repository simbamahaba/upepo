@extends('vendor.upepo.layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif
    <div class="panel panel-default">
        <div class="panel-heading">Am uitat parola</div>
        <div class="panel-body">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('customer/password/email') }}">
                @csrf

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                        @endif
                    </div>
                </div>

                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <input class="btn btn-primary" type="submit" value="Send Password Reset Link">
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection