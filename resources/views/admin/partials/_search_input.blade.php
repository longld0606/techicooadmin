<div class="col-sm-12 mb-3">
    <label class="form-label" for="search">{{ __('Tìm kiếm') }}</label>
    <input type="text" class="form-control" name="search" autocomplete="search" placeholder="Từ khóa">
</div>
@if(isset($lang) && $lang == true)
<div class="col-sm-3 mb-3">
    @include('admin.partials._input_select2', [
    'title' => 'Ngôn ngữ',
    'array' => \App\Common\Enum_LANG::getArray(),
    'name' => 'lang',
    'val' => old('lang', isset($item['lang']) ? $item['lang'] : ''),
    'all_title' => '-- Ngôn ngữ --'
    ])
</div>
@endif