<?php
$displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
}
?>


<div class="mb-3" {{ $displayNone }}>
    <label class="form-label" for="{{ 'input_' . $name }}">{{ $title }}</label>
    <textarea class="form-control ckeditor" rows="{{ isset($row) ? $row : 10 }}" id="{{ 'input_' . $name }}" name="{{ $name }}" rows='5'>{{ $val }}</textarea>
</div>
