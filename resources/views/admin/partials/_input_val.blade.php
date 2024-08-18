<?php
$displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
}
$isDisabled = '';
if ((isset($disabled) && $disabled == true) ) {
    $isDisabled = 'disabled';
}
if(!isset($val))
{
    $val = '';
}
?>
<div class="mb-3">
	<label class="form-label" for="{{ 'input_' . $name }}">{{ $title }}</label> 
	<input type="{{ isset($type) ? $type : 'text' }}" class="form-control" id="{{ 'input_' . $name }}" name="{{ $name }}" value="{{ $val }}" {{ isset($isRequired) && $isRequired ? 'required' : '' }} {{ $isDisabled }}  />
</div>