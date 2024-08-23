@extends('admin.layouts.app')
@section('content')
<section class="app-content ">
    <div class="card card-secondary card-outline  mb-4 mt-4 item-box">
        <div class="card-body">
            @include('admin.partials._alerts')

            <form class="form-item" method="POST" action="{{ '/' }}" enctype="multipart/form-data">
                <div>alo</div>
            
            </form>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script type="text/javascript">
    $(function() {
           
    });
</script>
@endpush