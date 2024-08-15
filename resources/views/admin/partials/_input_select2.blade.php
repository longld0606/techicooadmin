<?php
$displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
}
?>
<div class="mb-3" {{ $displayNone }}> 
    <label class="form-label" for="{{ 'input_' . $name }}">{{ $title }}</label> 
    <select class="form-control  select2" style="width: 100%;" id="{{ 'input_' . $name }}" name="{{ $name }}" {{ isset($isRequired) && $isRequired ? 'required' : '' }}>
        @if (isset($all_title))
        <option value=""> {{ $all_title }}</option>
        @endif
        @foreach ($array as $k => $v)
        <option value="{{ $k }}" {{ $k==$val ? 'selected' : '' }}> {{ $v }}</option>
        @endforeach
    </select> 
</div>