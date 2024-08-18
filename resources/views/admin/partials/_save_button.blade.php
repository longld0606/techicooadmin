 
<div class="">
    <div class="text-end">
        <a href="{{ $ref }}" class="btn btn-default btn-flat"> <i class="fa fa-chevron-left"></i> &nbsp;
            Quay lại </a>
        @if (!$isDisabled)
        <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-save"></i>
            &nbsp;{{ __($btn) }}</button>
        @endif
    </div>
</div>