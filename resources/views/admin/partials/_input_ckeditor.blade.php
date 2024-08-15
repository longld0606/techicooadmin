<?php
$displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
}
?>
<div class="row mb-3"  {{ $displayNone }}>
    <label class="col-sm-3" for="{{ 'input_' . $name }}">{{ $title }}</label>
    <div class="col-sm-9">
        <textarea class="form-control ckeditor" id="{{ 'input_' . $name }}" name="{{ $name }}" rows='5'>{{ $val }}</textarea>
    </div>
</div>
