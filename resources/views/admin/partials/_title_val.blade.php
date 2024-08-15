<?php
$displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
}
?>

<div class="row mb-3"  {{ $displayNone }}>
	<div class="col-sm-3"><label>{{ $title }}</label></div>
	<div class="col-sm-9">{{ $val }}</div>
</div>
