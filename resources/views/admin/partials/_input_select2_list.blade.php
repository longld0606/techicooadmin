<?php
$displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
}
$field_val = 'title';
if (isset($field)) {
    $field_val = $field;
}
$isMultiple = false;
if ((isset($multiple) && $multiple == true)) {
    $isMultiple = true; $attr_multiple = '';
}
?>

<div class="row mb-3"  {{ $displayNone }}>
    <label class="col-sm-3" for="{{ 'input_' . $name }}">{{ $title }}</label>
    <div class="col-sm-9">
        <select class="form-control select2" style="width: 100%;" id="{{ 'input_' . $name }}" name="{{ $name }}" {{ $isMultiple ? 'multiple=multiple' : ''}}>
            @if(isset($all_title) )
            <option value=""> {{ $all_title }}</option>
            @endif
            @if(count($array) > 0)
                @foreach ($array as $k => $v)
                    <option value="{{ $v['id'] }}" {{ ($isMultiple ? (in_array($v['id'], $val?? [])) : $v['id']==$val) ? 'selected' : '' }}> {{ $v[$field_val] }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
