@extends('vendor.upepo.admin.layouts.master')
@section('section-title')
    Setări tabelă
@endsection
@section('footer-assets')
    <script>
        $(document).ready(function () {

            $("select[id^='tip_']").change(function () {
                let id = '';
                id += $(this).attr('id');
                let counter = id.replace(/tip_/, '');

                let sel = 'select_';
                let txt = 'text_';
                // let select = sel.concat(counter);
                // let text = txt.concat(counter);

                let select = "#" + sel.concat(counter);
                let text = "#" + txt.concat(counter);

                switch ($("#" + id + " option:selected").text()) {
                    case 'select':
                        $(select).css('display', 'block');
                        $(text).css('display', 'none');
                        break;
                    case 'text':
                        $(select).css('display', 'none');
                        $(text).css('display', 'block');
                        break;
                    default:
                        $(text).css('display', 'none');
                        $(select).css('display', 'none');
                }
            });

            let table;
            $('#tableName').change(function () {
                if (typeof table !== 'undefined') {
                    $(".selectTable option[value='" + table + "']").remove();
                }

                table = $('#tableName').val();
                $('.selectTable').prepend($('<option>', {
                    value: table,
                    text: table
                }));

                // Set Model name
                let model = $(this).val().trim();
                model = model.charAt(0).toUpperCase() + model.slice(1);

                if(model.endsWith('ies')){
                    model = model.substring(0, model.length -3) + 'y';
                }else if (model.endsWith('s')){
                    model = model.substring(0, model.length -1);
                }

                $('#model').val( model );

            });

        /*    $('#functionImages').change(function(){
                if( $(this).prop('checked') === true){
                    $('#imagesMax').removeAttr('disabled');
                }else{
                    $('#imagesMax').attr('disabled', 'disabled');
                }
            });

            $('#functionFile').change(function(){
                if( $(this).prop('checked') === true){
                    $('#filesMax').removeAttr('disabled');
                    $('#filesExt').removeAttr('disabled');
                }else{
                    $('#filesMax').attr('disabled', 'disabled');
                    $('#filesExt').attr('disabled', 'disabled');
                }
            });

            $('#functionRecursive').change(function(){
                if( $(this).prop('checked') === true){
                    $('#recursiveMax').removeAttr('disabled');
                }else{
                    $('#recursiveMax').attr('disabled', 'disabled');
                }
            });*/

        });
    </script>
@endsection
@section('section-content')
    @if(session()->has('mesaj'))
        <div class="alert alert-success text-center" role="alert">
            {{ session()->get('mesaj') }}
        </div>
    @endif

    <?php
    $labelClass = 'col-form-label col-md-3 col-sm-3 label-align';
    $checkboxClass = 'col-md-6 col-sm-6 offset-md-3';
    $inputClass = 'col-md-6 col-sm-6';
    $inputSmall = 'form-control form-control-sm';
    ?>

<form action="{{ route('tables.store') }}" method="POST" class="form-horizontal"> @csrf @method('POST')
    <fieldset>
        <legend class="text-center text-info mt-4 mb-4">SETĂRI AFIȘARE</legend>
        <div class="item form-group @error('tableName') bad @enderror">
            <label for="tableName" class="{{ $labelClass }}">Nume tabelă <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="tableName" id="tableName" class="{{ $inputSmall }}" value="{{ old('tableName') }}">
            </div>
        </div>
        <div class="item form-group @error('pageName') bad @enderror">
            <label for="pageName" class="{{ $labelClass }}">Nume pagină <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="pageName" id="pageName" class="{{ $inputSmall }}" value="{{ old('pageName') }}">
            </div>
        </div>
        <div class="item form-group @error('model') bad @enderror">
            <label for="model" class="{{ $labelClass }}">Model <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="model" id="model" class="{{ $inputSmall }}" value="{{ old('model') }}">
            </div>
        </div>
        <div class="item form-group @error('displayedName') bad @enderror">
            <label for="displayedName" class="{{ $labelClass }}">Nume afișat <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="displayedName" id="displayedName" class="{{ $inputSmall }}" value="{{ old('displayedName')??'name' }}">
            </div>
        </div>
        <div class="item form-group @error('displayedFriendlyName') bad @enderror">
            <label for="displayedFriendlyName" class="{{ $labelClass }}">Nume friendly afișat<span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="displayedFriendlyName" id="displayedFriendlyName" class="{{ $inputSmall }}" value="{{ old('displayedFriendlyName')??'Nume' }}">
            </div>
        </div>
        <div class="item form-group @error('limitPerPage') bad @enderror">
            <label for="limitPerPage" class="{{ $labelClass }}">Limită pe pagină <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="number" min="5" max="100" name="limitPerPage" id="limitPerPage" class="{{ $inputSmall }}" value="{{ old('limitPerPage')??10 }}">
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend class="text-center text-info mt-4 mb-4">FUNCȚII</legend>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionAdd" checked="checked" value="1"> Adăugare
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionEdit" checked="checked" value="1"> Editare
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionDelete" checked="checked" value="1"> Ștergere
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionSetOrder" checked="checked" value="1"> Setează ordinea
                    </label>
                </div>
            </div>
        </div>
        {{-- IMAGES --}}
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionImages" id="functionImages" value="1" @if( null !== old('functionImages') )  checked="checked" @endif> Imagini
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <label for="imagesMax" class="{{ $labelClass }}">Număr maxim imagini</label>
            <div class="{{ $inputClass }}">
                <input type="number" name="imagesMax" id="imagesMax" min="1" {{--disabled="disabled"--}} class="{{ $inputSmall }}" value="{{ old('imagesMax') }}">
            </div>
        </div>
        {{-- FILES --}}
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionFile" id="functionFile" value="1" @if( null !== old('functionFile') )  checked="checked" @endif> Fișiere
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <label for="filesMax" class="{{ $labelClass }}">Număr maxim fișiere</label>
            <div class="{{ $inputClass }}">
                <input type="number" name="filesMax" id="filesMax" min="1" {{--disabled="disabled"--}} class="{{ $inputSmall }}" value="{{ old('filesMax') }}">
            </div>
        </div>
        <div class="item form-group">
            <label for="filesExt" class="{{ $labelClass }}">Extensii </label>
            <div class="{{ $inputClass }}">
                <input type="text" name="filesExt" id="filesExt" {{--disabled="disabled"--}} class="{{ $inputSmall }}" value="{{ old('filesExt') }}" placeholder="pdf, doc etc.">
            </div>
        </div>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionVisible" checked="checked" value="1"> Vizibil pe site
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionCreateTable" checked="checked" value="1"> Creează
                        tabelă
                    </label>
                </div>
            </div>
        </div>
        {{-- RECURSIVE --}}
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionRecursive" value="1" id="functionRecursive" @if( null !== old('functionRecursive') )  checked="checked" @endif> Recursiv
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <label for="recursiveMax" class="{{ $labelClass }}">Nivel maxim </label>
            <div class="{{ $inputClass }}">
                <input type="number" name="recursiveMax" id="recursiveMax" min="1" {{--disabled="disabled"--}} class="{{ $inputSmall }}" value="{{ old('recursiveMax') }}">
            </div>
        </div>
    </fieldset>
    {{--MESSAGES--}}
    <fieldset>
        <legend class="text-center text-info mt-4 mb-4">MESAJE</legend>
        <div class="item form-group @error('add') bad @enderror">
            <label for="add" class="{{ $labelClass }}">Adaugă <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="add" id="add" class="{{ $inputSmall }}" value="{{ old('add') ?? 'Adaugă un element' }}">
            </div>
        </div>
        <div class="item form-group @error('edit') bad @enderror">
            <label for="edit" class="{{ $labelClass }}">Editează <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="edit" id="edit" class="{{ $inputSmall }}" value="{{ old('edit') ?? 'Editează elementul' }}">
            </div>
        </div>
        <div class="item form-group @error('no_images') bad @enderror">
            <label for="no_images" class="{{ $labelClass }}">Nu sunt imagini <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="no_images" id="no_images" class="{{ $inputSmall }}" value="{{ old('no_images') ?? 'Nu există poze pentru acest element' }}">
            </div>
        </div>
        <div class="item form-group @error('no_files') bad @enderror">
            <label for="no_files" class="{{ $labelClass }}">Nu sunt fișiere <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="no_files" id="no_files" class="{{ $inputSmall }}" value="{{ old('no_files') ?? 'Nu există fișiere pentru acest element' }}">
            </div>
        </div>
        <div class="item form-group @error('added') bad @enderror">
            <label for="added" class="{{ $labelClass }}">A fost adăugat <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="added" id="added" class="{{ $inputSmall }}" value="{{ old('added') ?? 'Elementul a fost adăugat cu succes' }}">
            </div>
        </div>
        <div class="item form-group @error('deleted') bad @enderror">
            <label for="deleted" class="{{ $labelClass }}">A fost șters <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="deleted" id="deleted" class="{{ $inputSmall }}" value="{{ old('deleted') ?? 'Elementul a fost șters cu succes' }}">
            </div>
        </div>
    </fieldset>
    {{--FILTERS--}}
    <fieldset>
        <legend class="text-center text-info mt-4 mb-4">FILTRE</legend>
        <div class="item form-group @error('filter') bad @enderror">
            <label for="filter" class="{{ $labelClass }}">Filtre</label>
            <div class="{{ $inputClass }}">
                <input type="text" name="filter" id="filter" class="{{ $inputSmall }}" value="{{ old('filter') }}">
                <span id="filter" class="help-block">Numele câmpurilor din tabelă separate prin "," (virgulă)</span>
            </div>
        </div>
    </fieldset>

{{--COLUMNS--}}
    <fieldset>
        <legend class="text-center text-info mt-4 mb-4">COLOANE</legend>
        <?php $count = 0; ?>
        @for($i = $columns; $i>0; $i--)
            <div class="row mb-4 pb-4" style="border-bottom: 1px solid #e5e5e5;">
                <div class="col-md-6">{{--left--}}
                    <div class="item form-group">
                        <label for="friendlyName_{{ $count }}" class="{{ $labelClass }}">Nume friendly</label>
                        <div class="col-md-9">
                            <input type="text" class="{{ $inputSmall }}" name="elements[{{ $count }}][friendlyName]" id="friendlyName_{{ $count }}" placeholder="Friendly name" value="{{ old('elements.'.$count.'.friendlyName') }}">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="dbName_{{ $count }}" class="{{ $labelClass }}">Nume DB</label>
                        <div class="col-md-9">
                            <input type="text" class="{{ $inputSmall }}" name="elements[{{ $count }}][databaseName]" id="dbName_{{ $count }}" placeholder="column_name" value="{{ old('elements.'.$count.'.databaseName') }}">
                        </div>
                    </div>
                    <div class="item form-group">
                        <label for="tip_{{ $count }}" class="{{ $labelClass }}">Tip</label>
                        <div class="col-md-9">
                            <select name="elements[{{$count}}][type]" id="tip_{{ $count  }}" class="{{ $inputSmall }}">
                                @foreach($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="item form-group">
                        <div class="radio {{ $checkboxClass }}">
                            <label class="radio-inline">
                                <input name="elements[{{ $count }}][required]" type="radio" value="0"> Facultativ
                            </label>
                            <label class="radio-inline ml-3">
                                <input name="elements[{{ $count }}][required]" type="radio" checked="checked" value="1"> Obligatoriu
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="colType_{{ $count }}" class="{{ $labelClass }}">Tip coloană</label>
                        <div class="col-md-9">
                            <input type="text" class="{{ $inputSmall }}" name="elements[{{ $count }}][colType]" id="colType_{{ $count }}" placeholder="varchar|100" value="{{ old('elements.'.$count.'.colType') }}">
                        </div>
                    </div>
                </div>{{-- /left--}}
                <div class="col-md-6">{{--right--}}

                    <div class="form-group">
                        <div class="col-md-12" id="text_{{ $count }}">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="elements[{{ $count }}][readonly]" id="text_{{ $count }}" value="1"> Readonly
                            </label>
                        </div>
                    </div>
                    <div id="select_{{ $count }}" style="display:none;">

                        <div class="item form-group">
                            <div class="{{ $checkboxClass }}">
                                <label class="checkbox">
                                    <input type="checkbox" name="elements[{{ $count }}][selectMultiple]" value="1">
                                    Multiplu
                                </label>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="elements[{{ $count }}][selectFirstEntry]"
                                   class="{{ $labelClass }}">Prima valoare</label>
                            <div class="col-md-9">
                                <input type="text" class="{{ $inputSmall }}" name="elements[{{ $count }}][selectFirstEntry]" id="elements[{{ $count }}][selectFirstEntry]" placeholder="Prima valoare">
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="elements[{{$count}}][selectTable]" class="{{ $labelClass }}">Din tabela</label>
                            <div class="col-sm-9">
                                <select name="elements[{{$count}}][selectTable]" id="elements[{{$count}}][selectTable]" class="form-control form-control-sm selectTable">
                                    @foreach($tabele as $key=>$tabela)
                                        <option value="{{ $key }}">{{ $tabela }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="item form-group">
                            <label for="elements[{{$count}}][selectExtra]" class="{{ $labelClass }}">Valori fixe</label>
                            <div class="col-md-9">
                <textarea name="elements[{{$count}}][selectExtra]" id="elements[{{$count}}][selectExtra]" rows="2" class="{{ $inputSmall }}"></textarea>
                            </div>
                        </div>

                    </div>
                </div>{{-- //right--}}
            </div>
            <?php $count++; ?>
        @endfor
    </fieldset>
        <div class="item form-group">
            <div class="col-md-6 col-sm-6 offset-md-3">
                <input type="submit" class="btn btn-success btn-sm" value="Create table">
            </div>
        </div>
    </form>
@endsection
