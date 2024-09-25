<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">


    <div class="m-header">
        <a class="mobile-menu" id="mobile-collapse" href="{{ route('admin.dashboard') }}"><span></span></a>
        <a href="{{ route('admin.dashboard') }}" class="b-brand">
            <!-- ========   change your logo hear   ============ -->
            <img src="/assets/admin2/images/logo.png" alt="" class="logo">

        </a>
        <a href="#!" class="mob-toggler">
            <i class="feather icon-more-vertical"></i>
        </a>
    </div>
    <div class="collapse navbar-collapse">

        <ul class="navbar-nav ms-auto">
            <li>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
                    <div class="dropdown-menu dropdown-menu-end notification">
                        <div class="noti-head">
                            <h6 class="d-inline-block m-b-0">Thông báo</h6>
                            <div class="float-end">
                                <a href="#!" class="m-r-10">Đánh đấu đã đọc</a>
                                <a href="#!">Xóa tất cả</a>
                            </div>
                        </div>
                        <ul class="noti-body">
                            <li class="n-title">
                                <p class="m-b-0">Mới</p>
                            </li>
                            <li class="notification">
                                <div class="d-flex">
                                    <img class="img-radius" src="/assets/admin2/images/user/avatar-1.jpg" alt="Generic placeholder image">
                                    <div class="flex-grow-1">
                                        <p><strong>John Doe</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>5 min</span></p>
                                        <p>New ticket Added</p>
                                    </div>
                                </div>
                            </li>
                            <li class="n-title">
                                <p class="m-b-0">Cũ hơn</p>
                            </li>
                            <li class="notification">
                                <div class="d-flex">
                                    <img class="img-radius" src="/assets/admin2/images/user/avatar-2.jpg" alt="Generic placeholder image">
                                    <div class="flex-grow-1">
                                        <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>10 min</span></p>
                                        <p>Prchace New Theme and make payment</p>
                                    </div>
                                </div>
                            </li>
                            <li class="notification">
                                <div class="d-flex">
                                    <img class="img-radius" src="/assets/admin2/images/user/avatar-1.jpg" alt="Generic placeholder image">
                                    <div class="flex-grow-1">
                                        <p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>12 min</span></p>
                                        <p>currently login</p>
                                    </div>
                                </div>
                            </li>
                            <li class="notification">
                                <div class="d-flex">
                                    <img class="img-radius" src="/assets/admin2/images/user/avatar-2.jpg" alt="Generic placeholder image">
                                    <div class="flex-grow-1">
                                        <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                                        <p>Prchace New Theme and make payment</p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                        <div class="noti-footer">
                            <a href="#!">Xem tất cả</a>
                        </div>
                    </div>
                </div>
            </li>
            <li>
                <div class="dropdown drp-user">
                    <a href="#" class="dropdown-toggle" data-bs-toggle="dropdown">
                        <i class="feather icon-user"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end profile-notification">
                        <div class="pro-head">
                            <img src="/assets/admin2/images/user/avatar-4.jpg" class="img-radius" alt="User-Profile-Image">
                            <span>{{ Auth::user()->name }}</span>
                            <a href="{{ route('admin.logout') }}" class="dud-logout" title="Logout" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" >
                                <i class="feather icon-log-out"></i>
                            </a>
                        </div>
                        <ul class="pro-body">
                            <li><a href="{{ route('admin.profile') }}" class="dropdown-item"><i class="feather icon-user"></i> Thông tin cá nhân</a></li>

                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</header>
