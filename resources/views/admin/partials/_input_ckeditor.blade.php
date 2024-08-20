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
$_id = 'input_' . $name;
if(isset($inputId))
{
    $_id = $inputId;
}
?>


<div class="mb-3" {{ $_displayNone }}>
    <label class="form-label" for="{{ $_id }}">{{ $title }}</label>
    <textarea class="form-control ckeditor" rows="{{ isset($row) ? $row : 10 }}" id="{{ $_id }}" name="{{ $name }}" rows='5'
    {{ isset($isRequired) && $isRequired ? 'required' : '' }} {{ $_readonly }} {{ $_disabled }} >{{ $val }}</textarea>
</div>
