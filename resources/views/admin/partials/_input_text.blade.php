<?php
$displayNone = '';
$readonly = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
}
if (isset($view) && $view == true) {
    $readonly = 'readonly;';
}
if (!isset($val)) {
    $val = '';
}
?>
<div class="mb-3" {{ $displayNone }}>
    <label class="form-label" for="{{ 'input_' . $name }}">{{ $title }}</label>
    <textarea class="form-control" id="{{ 'input_' . $name }}" name="{{ $name }}"
        {{ isset($isRequired) && $isRequired ? 'required' : '' }} rows="{{ isset($row) ? $row : 3 }}" $readonly>{{ $val }}</textarea>
</div>
