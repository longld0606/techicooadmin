<?php
$_displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $_displayNone = 'style=display:none;';
}
$_readonly = '';
if ((isset($view) && $view == true) || (isset($readonly) && $readonly == true)) {
    $_readonly = 'readonly;';
}
$_disabled = '';
if ((isset($isDisabled) && $isDisabled == true) || (isset($disabled) && $disabled == true) ) {
    $_disabled = 'disabled';
}
if(!isset($val))
{
    $val = '';
}
?>
<div class="mb-3" {{ $_displayNone }}> 
    <label class="form-label" for="{{ 'input_' . $name }}">{{ $title }}</label> 
    <select class="form-control  select2" style="width: 100%;" id="{{ 'input_' . $name }}" name="{{ $name }}" 
    {{ isset($isRequired) && $isRequired ? 'required' : '' }} {{ $_readonly }} {{ $_disabled }} >
        @if (isset($all_title))
        <option value=""> {{ $all_title }}</option>
        @endif
        @foreach ($array as $k => $v)
        <option value="{{ $k }}" {{ $k== $val ? 'selected' : '' }}> {{ $v }}</option>
        @endforeach
    </select> 
</div>