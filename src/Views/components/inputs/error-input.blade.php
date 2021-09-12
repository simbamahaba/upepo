@props(['field'])
@if ($errors->has($field))
    <span class="pure-form-message-inline">{{ $errors->first($field) }}</span>
@endif
