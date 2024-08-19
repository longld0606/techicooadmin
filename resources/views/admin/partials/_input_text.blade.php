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
    <textarea class="form-control" id="{{ 'input_' . $name }}" name="{{ $name }}"
       rows="{{ isset($row) ? $row : 3 }}"
        {{ isset($isRequired) && $isRequired ? 'required' : '' }} {{ $_readonly }} {{ $_disabled }} >{{ $val }}</textarea>
</div>
