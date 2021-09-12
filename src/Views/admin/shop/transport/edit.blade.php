@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Setări transport @endsection
@section('section-content')

<form action="{{ route('transport.update', $transport->id) }}" class="form-horizontal form-label-left" id="transport-edit" method="POST">
        @csrf  @method("PUT")
    <fieldset>
        <legend>Editează transportul</legend>
        <div class="item form-group">
            <label for="name" class="col-form-label col-md-3 col-sm-3 label-align">Nume transport:</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="name" id="name" class="form-control" value="{{ $transport->name }}" form="transport-edit">
            </div>
        </div>
        <div class="item form-group">
            <label for="price" class="col-form-label col-md-3 col-sm-3 label-align">Pret:</label>
            <div class="col-md-6 col-sm-6">
                <input type="text" name="price" id="price" class="form-control" value="{{ $transport->price }}" form="transport-edit">
            </div>
        </div>
        <div class="item form-group">
            <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
            <div class="col-md-6 col-sm-6">
                <div class="checkbox">
                    <label>
                        @php $checked = ($transport->visible == 1)?"checked=checked":'' @endphp
                            <input type="checkbox" name="visible" {{ $checked }} form="transport-edit"> Vizibil
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
        <div class="col-md-6 col-sm-6 offset-md-3">
            <input type="submit" class="btn btn-primary" value="Salvează" form="transport-edit">
            <a href="{{ route('transport.index') }}" class="btn btn-secondary">Inapoi la listare</a>
        </div>
        </div>
    </fieldset>
</form>
@endsection
