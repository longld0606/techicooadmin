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
 
$isMultiple = false;
if (isset($multiple) && $multiple == true) {
    $isMultiple = true;
    $attr_multiple = '';
}
if (!isset($id_field)) {
    $id_field = 'id';
}
if (!isset($val_field)) {
    $val_field = 'title';
}
?>

<div class="mb-3" {{ $_displayNone }}>
    <label class="form-label" for="{{ 'input_' . $name }}">{{ $title }}</label>
    <select class="form-control  select2" style="width: 100%;" id="{{ 'input_' . $name }}" name="{{ $name }}"
         {{ $isMultiple ? 'multiple=multiple' : '' }}
         {{ isset($isRequired) && $isRequired ? 'required' : '' }} {{ $_readonly }} {{ $_disabled }} >
        @if (isset($all_title) && $all_title != '')
            <option value=""> {{ $all_title }}</option>
        @endif
        @if (count($array) > 0)
            @foreach ($array as $k => $v)
                <option value="{{ $v[$id_field] }}"
                    {{ ($isMultiple ? in_array($v[$id_field], $val ?? []) : $v[$id_field] == $val) ? 'selected' : '' }}>
                    {{ $v[$val_field] }}</option>
            @endforeach
        @endif
    </select>
</div>
