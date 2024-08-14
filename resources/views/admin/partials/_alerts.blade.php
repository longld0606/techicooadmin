@if (session()->has('success'))
    <div class="col-sm-12">
        <div class="alert alert-success alert-dismissible flat" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
            </button>
            {{ session()->get('success') }}
        </div>
    </div>
@elseif ($errors->any())
    <div class="col-sm-12">
        <div class="alert alert-danger alert-dismissible flat">
            <ul style="list-style: none;padding-inline-start: 0">
                @foreach ($errors->all() as $error)
                    <li>{!! $error !!}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="top: -20px;">
                <span aria-hidden="true">×</span>
            </button>
        </div>
    </div>
@endif
