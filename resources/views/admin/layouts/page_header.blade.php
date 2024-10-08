<div class="page-header page-horizontal">
    <div class="page-block">
        <div class="row align-items-center">
            <div class="col-md-12">
                <div class="page-header-title">
                    <h5 class="m-b-10">{{$title}}</h5>
                </div>
                @if(!empty($nav))
                    <ul class="breadcrumb">
                        @foreach ($nav as $k => $n )
                            @if($k=="HOME")
                            <li class="breadcrumb-item"><a href="{{ $n }}"><i class="feather icon-home"></i></a></li>
                            @else
                            <li class="breadcrumb-item"> <a href="{{ $n }}" class="">{{ $k }}</a></li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</div>
