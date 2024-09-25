<nav class="app-header navbar navbar-expand bg-body">
    <!--begin::Container-->
    <div class="container-fluid">
        <!--begin::Start Navbar Links-->
        <ul class="navbar-nav">
            <li class="nav-item"> <a class="nav-link" data-lte-toggle="sidebar" href="#" role="button"> <i class="bi bi-list"></i> </a> </li>
            @if(!empty($nav))
                @foreach ($nav as $k => $n )
                    @if( $k != "HOME")
                    <li class="nav-item d-none d-md-block"> <a href="{{ $n }}" class="nav-link">{{ $k == "BUDVAR" ? "HOME" : $k }}</a>
                    @endif
                @endforeach
            @endif
        </ul>
        <ul class="navbar-nav ms-auto">

            <li class="nav-item"> <a class="nav-link" href="#" data-lte-toggle="fullscreen"> <i data-lte-icon="maximize" class="bi bi-arrows-fullscreen"></i> <i data-lte-icon="minimize" class="bi bi-fullscreen-exit" style="display: none;"></i> </a> </li>

            <li class="nav-item dropdown user-menu"> <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <img src="/assets/theme/assets/img/user2-160x160.jpg" class="user-image rounded-circle shadow" alt="User Image">
                    <span class="d-none d-md-inline">{{ Auth::user()->name }}</span> </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-end">
                    <!--begin::User Image-->
                    <li class="user-header text-bg-primary"> <img src="/assets/theme/assets/img/user2-160x160.jpg" class="rounded-circle shadow" alt="User Image">
                        <p>
                            {{ Auth::user()->email }}
                            <small>{{ Auth::user()->phone }}</small>
                        </p>
                    </li>

                    @if (Auth::guard('admin')->user())
                    <li class="user-footer">
                        <a href="{{ route('admin.profile') }}" class="btn btn-default btn-flat">Tài khoản</a>
                        <a href="{{ route('admin.logout') }}" class="btn btn-default btn-flat float-end" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">{{ __('Logout') }}</a>
                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                    @endif

                </ul>
            </li>

        </ul>
    </div>
</nav>