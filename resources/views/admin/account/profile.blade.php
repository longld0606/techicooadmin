@extends('admin.layouts.app')

@push('style')
<style>.page-header{margin-top: -120px;}</style>
@endpush
@section('content')
<div class="user-profile user-card mb-4" >

    <div class="card-body py-0">
        <div class="user-about-block m-0">
            <div class="row">
                <div class="col-md-4 text-center mt-n5">
                    <div class="change-profile text-center">
                        <div class="dropdown w-auto d-inline-block">
                            <a class="dropdown-toggle" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="profile-dp">
                                    <div class="position-relative d-inline-block">
                                        <img class="img-radius img-fluid wid-100" src="/assets/admin2/images/user/avatar-4.jpg" alt="User image">
                                    </div>
                                    {{-- <div class="overlay">
                                        <span>change</span>
                                    </div> --}}
                                </div>
                                <div class="certificated-badge">
                                    <i class="fas fa-certificate text-c-blue bg-icon"></i>
                                    <i class="fas fa-check front-icon text-white"></i>
                                </div>
                            </a>
                            {{-- <div class="dropdown-menu">
                                <a class="dropdown-item" href="#"><i class="feather icon-upload-cloud me-2"></i>upload new</a>
                                <a class="dropdown-item" href="#"><i class="feather icon-image me-2"></i>from photos</a>
                                <a class="dropdown-item" href="#"><i class="feather icon-shield me-2"></i>Protact</a>
                                <a class="dropdown-item" href="#"><i class="feather icon-trash-2 me-2"></i>remove</a>
                            </div> --}}
                        </div>
                    </div>
                    <h5 class="mb-1">{{Auth::user()->name}}</h5>
                    <p class="mb-2 text-muted">{{Auth::user()->email}}</p>
                </div>
                <div class="col-md-8 mt-md-4">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#!" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i class="feather icon-globe me-2 f-18"></i>{{Auth::user()->name}}</a>
                            <div class="clearfix"></div>
                            <a href="mailto:{{ Auth::user()->email }}" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i class="feather icon-mail me-2 f-18"></i>{{ Auth::user()->email }}</a>
                            <div class="clearfix"></div>
                            <a href="#!" class="mb-1 text-muted d-flex align-items-end text-h-primary"><i class="feather icon-phone me-2 f-18"></i>{{ Auth::user()->phone }}</a>
                        </div>
                        <div class="col-md-6">
                            <div class="media">
                                <i class="feather icon-map-pin me-2 mt-1 f-18"></i>
                                <div class="flex-grow-1">
                                    <p class="mb-0 text-muted">4289 Calvin Street</p>
                                    <p class="mb-0 text-muted">Baltimore, near MD Tower Maryland,</p>
                                    <p class="mb-0 text-muted">Maryland (21201)</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')

@stack('script')
@endpush
