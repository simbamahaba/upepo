@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Status comenzi @endsection
@section('section-content')
    <form action="{{ route('status.order.update', $status->id) }}" method="POST"
          class="form-horizontal form-label-left">
        @csrf @method('PUT')
        <fieldset>
            <legend>Editare status</legend>
            <div class="item form-group">
                <label for="name" class="col-form-label col-md-3 col-sm-3 label-align">Nume status:</label>
                <div class="col-md-6 col-sm-6">
                    <input type="text" name="name" id="name" class="form-control" value="{{ $status->name }}"
                           placeholder="Nume status">
                </div>
            </div>
            <div class="item form-group">
                <label class="col-form-label col-md-3 col-sm-3 label-align"></label>
                <div class="col-md-6 col-sm-6">
                    <div class="checkbox">
                        <label>
                            <?php $checked = ($status->visible != 1) ?: 'checked'; ?>
                            <input type="checkbox" value="1" name="visible" {{ $checked }}> Vizibil
                        </label>
                    </div>
                </div>
            </div>
            <div class="item form-group">
                <div class="col-md-6 col-sm-6 offset-md-3">
                    <input type="submit" value="Salvează" class="btn btn-primary">
                    <a href="{{ route('status.index') }}" class="btn btn-secondary">Înapoi la listare</a>
                </div>
            </div>
        </fieldset>
    </form>
@endsection
