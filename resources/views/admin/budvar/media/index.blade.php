@section('index') 
<div class="col-sm-3 mb-3">
    @include('admin.partials._input_val', [
    'title' => 'Loại',
    'name' => 'type',
    ])
</div>
@endsection
@push('script')
{{-- <script>
    alert('1212');
</script> --}}
@endpush
@extends('admin.partials._index', ['lang'=>false])