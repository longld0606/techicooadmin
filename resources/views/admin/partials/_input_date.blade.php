<?php
$displayNone = '';
if ((isset($hiden) && $hiden == true) || (isset($hidden) && $hidden == true)) {
    $displayNone = 'style=display:none;';
}
?>

<div class="row mb-3"  {{ $displayNone }}>
	<label class="col-sm-3" for="{{ 'input_' . $name }}">{{ $title }}</label>
	<div class="col-sm-9">
		<div class="input-group">
			<div class="input-group-addon">
				<i class="fa fa-calendar"></i>
			</div>
			<input type="text" class="form-control datepicker" id="{{ 'input_' . $name }}" name="{{ $name }}" value="{{ \App\Common\Utility::displayDate($val) }}" autocomplete="off">
		</div>
	</div>
</div>
