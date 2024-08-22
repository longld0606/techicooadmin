@section('index')
<div class="col-sm-3 mb-3">
    @include('admin.partials._input_select2', [
    'title' => 'Loại',
    'name' => 'type',
    'array' => ['' => '--- Loại ---','BRAND' => 'BRAND', 'BANNER' => 'BANNER'],
    ])
</div>
@endsection
@push('script')
{{-- <script>
    alert('1212');
</script> --}}
@endpush
@extends('admin.partials._index')