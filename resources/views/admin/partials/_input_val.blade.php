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
$_minlength ='';
if(isset($minlength))
{
    $_minlength = 'minlength='.$minlength;
}
$_maxlength ='';
if(isset($maxlength))
{
    $_maxlength = 'maxlength='.$maxlength;
}
?>
<div class="mb-3" {{ $_displayNone }}>
	<label class="form-label" for="{{ 'input_' . $name }}">{{ $title }}</label> 
	<input type="{{ isset($type) ? $type : 'text' }}" class="form-control" id="{{ 'input_' . $name }}" name="{{ $name }}" value="{{ $val }}" 
    {{ isset($isRequired) && $isRequired ? 'required' : '' }} {{ $_readonly }} {{ $_disabled }}  {{ $_minlength }} {{ $_maxlength }} />
</div>