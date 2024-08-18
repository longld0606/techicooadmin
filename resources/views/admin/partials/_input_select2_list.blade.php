<?php
$displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
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

<div class="mb-3" {{ $displayNone }}>
    <label class="form-label" for="{{ 'input_' . $name }}">{{ $title }}</label>
    <select class="form-control  select2" style="width: 100%;" id="{{ 'input_' . $name }}" name="{{ $name }}"
        {{ isset($isRequired) && $isRequired ? 'required' : '' }} {{ $isMultiple ? 'multiple=multiple' : '' }}>
        @if (isset($all_title))
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
