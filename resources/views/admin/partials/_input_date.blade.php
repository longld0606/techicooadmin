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
	<div class="input-group">
		<span class="input-group-text" id="basic-addon1"><i class="fa fa-calendar"></i></span>
		<input type="text" class="form-control datepicker" id="{{ 'input_' . $name }}" name="{{ $name }}" 
		{{ isset($isRequired) && $isRequired ? 'required' : '' }} {{ $_readonly }} {{ $_disabled }} 
		value="{{ \App\Common\Utility::displayDate($val) }}" autocomplete="off">
	</div> 
</div>