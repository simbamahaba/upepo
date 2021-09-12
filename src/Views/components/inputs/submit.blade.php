@props(['value'=>__('inputs.submit'), 'form'=>'', 'class'=>'pure-button'])

{{--<button type="submit" class="{{ $class }}">{{ $value }}</button>--}}
<input type="submit" value="{{ $value }}" class="{{ $class }}" form="{{ $form }}">
