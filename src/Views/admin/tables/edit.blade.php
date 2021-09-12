@extends('vendor.upepo.admin.layouts.master')
@section('section-title') Editare tabela <strong>{{ $settings['config']['tableName'] }}</strong> @endsection
@section('footer-assets')
<script>
    $(document).ready(function(){

        $( "select[id^='tip_']" ).change(function() {
            var id = '';
            id += $( this ).attr('id');
            var counter = id.replace(/tip_/,'');

            var sel = 'select_';
            var txt = 'text_';
            var select = sel.concat(counter);
            var text = txt.concat(counter);
            switch( $("#" + id + " option:selected").text() ){
                case 'select':
                    $("#" + select).css('display','block');
                    $("#" + text).css('display','none');
                    break;
                case 'text':
                    $("#" + select).css('display','none');
                    $("#" + text).css('display','block');
                    break;
                default:
                    $("#" + text).css('display','none');
                    $("#" + select).css('display','none');
            }
        });

        var table;
        $('#tableName').change( function(){
            if (typeof table !== 'undefined') {
                $(".selectTable option[value='" + table + "']").remove();
            }

            table = $('#tableName').val();
            $('.selectTable').prepend($('<option>', {
                value: table,
                text: table
            }));

        });

        $("#addField").click(function(event){
            event.preventDefault();
//            $('#myTable tr:last').after("");
        });

        // $("#myTable").tableDnD();
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

    <form action="{{ route('tables.update',$table->id) }}" method="POST" class="form-horizontal"> @csrf @method('POST')

<table class="table" id="myTable">
    <fieldset>
        <legend class="text-center text-info mt-4 mb-4">SETĂRI AFIȘARE</legend>
        <div class="item form-group @error('tableName') bad @enderror">
            <label for="tableName" class="{{ $labelClass }}">Nume tabelă <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="tableName" id="tableName" class="{{ $inputSmall }}" value="{{ $settings['config']['tableName'] }}">
            </div>
        </div>
        <div class="item form-group @error('pageName') bad @enderror">
            <label for="pageName" class="{{ $labelClass }}">Nume pagină <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="pageName" id="pageName" class="{{ $inputSmall }}" value="{{ $settings['config']['pageName'] }}">
            </div>
        </div>
        <div class="item form-group @error('model') bad @enderror">
            <label for="model" class="{{ $labelClass }}">Model <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="model" id="model" class="{{ $inputSmall }}" value="{{ $settings['config']['model'] }}">
            </div>
        </div>
        <div class="item form-group @error('displayedName') bad @enderror">
            <label for="displayedName" class="{{ $labelClass }}">Nume afișat <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="displayedName" id="displayedName" class="{{ $inputSmall }}" value="{{ $settings['config']['displayedName'] }}">
            </div>
        </div>
        <div class="item form-group @error('displayedFriendlyName') bad @enderror">
            <label for="displayedFriendlyName" class="{{ $labelClass }}">Nume friendly afișat<span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="text" name="displayedFriendlyName" id="displayedFriendlyName" class="{{ $inputSmall }}" value="{{ $settings['config']['displayedFriendlyName'] }}">
            </div>
        </div>
        <div class="item form-group @error('limitPerPage') bad @enderror">
            <label for="limitPerPage" class="{{ $labelClass }}">Limită pe pagină <span class="required">*</span></label>
            <div class="{{ $inputClass }}">
                <input type="number" min="5" max="100" name="limitPerPage" id="limitPerPage" class="{{ $inputSmall }}" value="{{ $settings['config']['limitPerPage'] }}">
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend class="text-center text-info mt-4 mb-4">FUNCȚII</legend>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionAdd" <?=($settings['config']['functionAdd'] == 1)?'checked="checked"':'';?> value="1"> Adăugare
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionEdit" <?=($settings['config']['functionEdit'] == 1)?'checked="checked"':'';?> value="1"> Editare
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionDelete" <?=($settings['config']['functionDelete'] == 1)?'checked="checked"':'';?> value="1"> Ștergere
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionSetOrder" <?=($settings['config']['functionSetOrder'] == 1)?'checked="checked"':'';?> value="1"> Setează ordinea
                    </label>
                </div>
            </div>
        </div>
        {{-- IMAGES --}}
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionImages" id="functionImages" value="1" <?=($settings['config']['functionImages'] == 1)?'checked="checked"':'';?>> Imagini
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <label for="imagesMax" class="{{ $labelClass }}">Număr maxim imagini</label>
            <div class="{{ $inputClass }}">
                <input type="number" name="imagesMax" id="imagesMax" min="1" class="{{ $inputSmall }}" value="{{ $settings['config']['imagesMax'] }}">
            </div>
        </div>
        {{-- FILES --}}
        <div class="item form-group">
            <div class="{{ $checkboxClass }}">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="functionFile" id="functionFile" value="1" <?=($settings['config']['functionFile'] == 1)?'checked="checked"':'';?>> Fișiere
                    </label>
                </div>
            </div>
        </div>
        <div class="item form-group">
            <label for="filesMax" class="{{ $labelClass }}">Număr maxim fișiere</label>
            <div class="{{ $inputClass }}">
                <input type="number" name="filesMax" id="filesMax" min="1" class="{{ $inputSmall }}" value="{{ $settings['config']['filesMax'] }}">
            </div>
        </div>
        <div class="item form-group">
            <label for="filesExt" class="{{ $labelClass }}">Extensii </label>
            <div class="{{ $inputClass }}">
                <input type="text" name="filesExt" id="filesExt" class="{{ $inputSmall }}" value="{{ $settings['config']['filesExt'] }}" placeholder="pdf, doc etc.">
            </div>
        </div>
{{ dd($settings) }}

    <tr class="nodrop nodrag"><td>Fisiere</td>
        <td><div class="col_1">
                <input type="checkbox" name="functionFile"
                       <?=($settings['config']['functionFile'] == 1)?'checked="checked"':'';?>
                value="1">
            </div>
            <div class="col_2">Maxim: <input class="numar" type="number" min="0" name="filesMax" value="{{ $settings['config']['filesMax'] }}"></div>
            <div class="col_2">Extensii permise: <input type="text" name="filesExt" value="pdf"></div>
        </td>
    </tr>

    <tr class="nodrop nodrag"><td>Vizibil pe site</td>
        <td><input type="checkbox" name="functionVisible"
               <?=($settings['config']['functionVisible'] == 1)?'checked="checked"':'';?>
               value="1">
        </td>
    </tr>
    <tr class="nodrop nodrag"><td>Creaza tabela</td><td><input type="checkbox" name="functionCreateTable" checked="checked" value="1"></td></tr>
    <tr class="nodrop nodrag"><td>Recursiv</td>
        <td><div class="col_1">
                <input type="checkbox" name="functionRecursive"
                       <?=($settings['config']['functionRecursive'] == 1)?'checked="checked"':'';?>
                       value="1">
            </div>
            <div class="col_2">Nivel maxim: <input type="number" name="recursiveMax" value="{{ $settings['config']['recursiveMax'] }}"></div>
        </td>
    </tr>
        <tr class="nodrop nodrag"><th colspan="2" class="active">Mesaje</th></tr>
    <tr class="nodrop nodrag"><td>Adauga</td><td><input class="form-control input-sm" type="text" name="add" value="{{ $settings['messages']['add'] }}"></td></tr>
    <tr class="nodrop nodrag"><td>Editeaza</td><td><input class="form-control input-sm" type="text" name="edit" value="{{ $settings['messages']['edit'] }}"></td></tr>
    <tr class="nodrop nodrag"><td>Nu sunt imagini</td><td><input class="form-control input-sm" type="text" name="no_images" value="{{ $settings['messages']['no_images'] }}"></td></tr>
    <tr class="nodrop nodrag"><td>Nu sunt fisiere</td><td><input class="form-control input-sm" type="text" name="no_files" value="{{ $settings['messages']['no_files'] }}"></td></tr>
    <tr class="nodrop nodrag"><td>A fost adaugat</td><td><input class="form-control input-sm" type="text" name="added" value="{{ $settings['messages']['added'] }}"></td></tr>
    <tr class="nodrop nodrag"><td>A fost sters</td><td><input class="form-control input-sm" type="text" name="deleted" value="{{ $settings['messages']['deleted'] }}"></td></tr>
        <tr class="nodrop nodrag"><th colspan="2" class="active">Filtre</th></tr>
    <tr class="nodrop nodrag"><td>Numele campurilor din tabel separate cu "," (virgula)</td>
        <?php
              if(!empty($settings['filter']) && is_array($settings['filter'])){
                $filter = implode(',',$settings['filter']);
              }else{
                $filter='';
              }
        ?>
        <td><input class="form-control input-sm" type="text" name="filter" value="{{ $filter }}"></td>
    </tr>

    <tr class="nodrop nodrag"><th colspan="2" class="active nodrop nodrag">Coloane |
            <button id="addField" class="btn btn-default btn-sm">Adauga coloana</button></th></tr>
    <?php $count=0; ?>
    @foreach($settings['elements'] as $name => $field)
    <tr>
        <td style="width:40%;">
            <div class="form-group">
                <label for="friendlyName_{{ $count }}" class="col-md-4 control-label">Nume friendly</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="elements[{{ $name }}][friendlyName]" id="friendlyName_{{ $count }}" value="{{ $field['friendlyName'] }}">
                </div>
            </div>
            <div class="form-group">
                <label for="dbName_{{ $count }}" class="col-md-4 control-label">Nume DB</label>
                <div class="col-md-8">
                <input type="text" class="form-control" name="elements[{{ $name }}][databaseName]" id="dbName_{{ $count }}" value="{{ $name }}">
                </div>
            </div>
            <div class="form-group">
                <label for="tip_{{ $count }}">Tip:</label>
                <div class="col-md-8">

                    <select name="elements[{{ $name }}][type]" id="tip_{{ $count }}" class="form-control">
                        @foreach($types as $type)
                            @php
                                $selectedFieldType = ($field['type'] == $type)?'selected=selected':'';
                            @endphp
                            <option value="{{ $type }}" {{ $selectedFieldType }}>{{ $type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-md-4 control-label">Obligatoriu</label>
                <div class="radio col-md-8">
                    <?php
                        if ($field['required'] == 1){
                            $yes = 'checked=checked';
                            $no = '';
                        }else{
                            $no = 'checked=checked';
                            $yes = '';
                        }
                    ?>
                    <label class="radio-inline"><input type="radio" name="elements[{{$name}}][required]" value="0" {{ $no }}></label>
                    <label class="radio-inline"><input type="radio" name="elements[{{$name}}][required]" value="1" {{ $yes }}></label>
                </div>
            </div>
            <div class="form-group">
                <label for="colType_{{ $count }}" class="col-md-4 control-label">Tip coloana</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" name="elements[{{ $name }}][colType]" id="colType_{{ $count }}" value="{{ $field['colType'] }}">
                </div>
            </div>
        </td>
        <td>
            <div class="form-group" style="@if($field['type'] == 'select') display:none @else display:block @endif;">
                <div class="col-md-6" id="text_{{ $count }}" >
                    <label class="checkbox-inline">
                       <input type="checkbox" name="elements[{{ $name }}][readonly]" id="text_{{ $count }}" {{ (isset($field['readonly']) && $field['readonly'] == 1)?'checked="checked"':'' }} value="1"> Readonly
                    </label>
                </div>
            </div>

            <span id="select_{{ $count }}" style="@if($field['type'] == 'select') display:block !important @else display:none @endif;">
                <div class="form-group">
                    <div class="col-md-8 col-md-offset-3 checkbox">
                        <label class="checkbox-inline">
                            <?php $multiple = (isset($field['selectMultiple']) && $field['selectMultiple'] == 1)?'checked="checked"':''; ?>
                            <input type="checkbox" name="elements[{{ $name }}][selectMultiple]" {{ $multiple }} value="1"> Multiplu
                        </label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="elements[{{$name}}][selectFirstEntry]" class="col-md-3 control-label">Prima valoare:</label>
                    <div class="col-md-8">
                        <?php $selectFirstEntry = (isset($field['selectFirstEntry']))?$field['selectFirstEntry']:null; ?>
{{--                        {!! Form::text("elements[$name][selectFirstEntry]", $selectFirstEntry, ['class'=>'form-control', 'id'=>'']) !!}--}}
                        <input type="text" name="elements[{{$name}}][selectFirstEntry]" id="elements[{{$name}}][selectFirstEntry]" value="{{  $selectFirstEntry }}" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-sm-3 control-label">Din tabelul:</label>
                    <div class="col-sm-8">
                        <?php $selectTable = (isset($field['selectTable']))?$field['selectTable']:null; ?>
{{--                    {!! Form::select("elements[$name][selectTable]",$tabele ,$selectTable,['class'=>'form-control selectTable']) !!}--}}
                        <select name="elements[{{$name}}][selectTable]" id="" class="form-control selectTable">
                            @foreach($tabele as $tabela => $numeTabela)
                                @php $tableSelected = ($selectTable == $tabela)?"selected":"" @endphp
                                <option value="{{ $tabela }}" {{ $tableSelected }}>{{ $numeTabela }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="" class="col-md-3 control-label">Valori fixe:</label>
                    <div class="col-md-8">
                        <?php $selectExtra = (isset($field['selectExtra']))?$field['selectExtra']:null; ?>
                        <textarea name="elements[{{$name}}][selectExtra]" id="" cols="30" rows="2" class="form-control">{{ $selectExtra }}</textarea>
                    </div>
                </div>
            </span>

        </td>
    </tr>
        <?php $count++; ?>
    @endforeach
    </tbody>
</table>
<div class="col-sm-12">

    <input type="submit" value="Submit" class="btn btn-success btn-sm">
</div>
</form>


@endsection
