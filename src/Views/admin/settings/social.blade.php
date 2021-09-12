@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Rețele sociale @endsection
@section('header-assets')
    <script type="text/javascript" src="{{ asset('assets/admin/vendors/upepo/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/admin/vendors/upepo/js/messages_ro.min.js') }}"></script>
@endsection
@section('section-content')

<form action="{{ route('social.update') }}" method="POST" enctype="multipart/form-data" id="myForm" class="form-horizontal form-label-left">
        @csrf
        @method('POST')
    <div class="item form-group">
        <label for="facebook_address" class="col-form-label col-md-3 col-sm-3 label-align">Facebook:</label>
        <div class="col-md-6 col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">https://www.facebook.com/</span>
                <input type="text" name="facebook_address" id="facebook_address" class="form-control" value="{{ $site_settings['facebook_address'] }}">
            </div>
        </div>
    </div>
    <div class="item form-group">
        <label for="twitter_address" class="col-form-label col-md-3 col-sm-3 label-align">Twitter:</label>
        <div class="col-md-6 col-sm-6">
            <div class="input-group">
                <span class="input-group-addon">https://twitter.com/</span>
                <input type="text" name="twitter_address" id="twitter_address" class="form-control" value="{{ $site_settings['twitter_address'] }}">
            </div>
        </div>
    </div>
    <div class="item form-group">
        <label for="google_plus" class="col-form-label col-md-3 col-sm-3 label-align">Google+:</label>
        <div class="col-md-6 col-sm-6">
            <div class="input-group">
                <div class="input-group-addon">https://plus.google.com/</div>
                <input type="text" name="google_plus" id="google_plus" class="form-control" value="{{ $site_settings['google_plus'] }}">
            </div>
        </div>
    </div>
    <div class="item form-group">
        <label for="youtube" class="col-form-label col-md-3 col-sm-3 label-align">Youtube:</label>
        <div class="col-md-6 col-sm-6">
            <div class="input-group">
                <div class="input-group-addon">https://www.youtube.com/</div>
                <input type="text" name="youtube" id="youtube" class="form-control" value="{{ $site_settings['youtube'] }}">
            </div>
        </div>
    </div>
    <div class="item form-group">
        <label for="pinterest" class="col-form-label col-md-3 col-sm-3 label-align">Pinterest:</label>
        <div class="col-md-6 col-sm-6">
            <div class="input-group">
                <div class="input-group-addon">https://</div>
                <input type="text" name="pinterest" id="pinterest" class="form-control" value="{{ $site_settings['pinterest'] }}">
            </div>
        </div>
    </div>
    <div class="item form-group">
        <label for="og" class="col-form-label col-md-3 col-sm-3 label-align">Poza Facebook:</label>
        <div class="col-md-6 col-sm-6">
            <input type="file" name="og" id="og" class="form-control">
            <p>The recommended pixel dimensions for an OG Image is 1200:630 px (aspect ratio of 1.91:1).</p>
        </div>
    </div>
    <div class="col-md-6 col-sm-6 offset-md-3">
        <img style="margin-bottom: 10px;" src="{{ url('images/small/'.$site_settings['og_pic']) }}" alt="">
    </div>
    <div class="col-md-6 col-sm-6 offset-md-3">
        <input type="submit" value="Submit" class="btn btn-success">
    </div>
</form>
{{--    {!! Form::close() !!}--}}

{{--<script>
    $().ready(function() {
        $("#myForm").validate({
            rules : {
                'facebook_address': {
                required: true,
                minlength : 3,
                maxlength: 50
                },

            }
        });
    });
</script>--}}
@endsection
