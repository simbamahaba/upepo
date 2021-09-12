@extends('vendor.upepo.layouts.app')

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading"><h1>Intra in cont</h1></div>
        <div class="panel-body">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('customer/login') }}">
                    {{ csrf_field() }}

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

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password" class="col-md-4 control-label">Password</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control" name="password" required>

                            @if ($errors->has('password'))
                                <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-md-offset-4">
                        {{--<input class="btn btn-primary" type="submit" value="Log in">--}}
                        <button class="btn btn-primary" type="submit" value="submit">Log in</button>
                        <a class="btn btn-default" href="{{ route('password.request') }}">Ati uitat parola?</a>
                        <a class="btn btn-default" href="{{ route('customer.showRegistrationForm') }}">Cont nou</a>
                            <hr>
                            @if ($errors->has('fberror'))
                                <div class="panel panel-default">
                                    <div class="panel-body">
                                        <strong>{!! $errors->first('fberror') !!}</strong>
                                    </div>
                                </div>
                            @endif
                        <a class="btn btn-primary btn-large" href="{{ url('auth/facebook') }}"><i class="fa fa-facebook left"></i> Facebook Login</a>
                        </div>
                    </div>

                </form>
        </div>
    </div>
@endsection
