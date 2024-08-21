<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!--begin::Sidebar Brand-->
    <div class="sidebar-brand">
        <!--begin::Brand Link--> <a href="{{ route('admin.dashboard') }}" class="brand-link">
            <!--begin::Brand Image--> <img src="/assets/img/logo.png" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            <!--end::Brand Image-->
            <!--begin::Brand Text--> <span class="brand-text fw-light">BUDVAR</span>
            <!--end::Brand Text-->
        </a>
        <!--end::Brand Link-->
    </div>
    <!--end::Sidebar Brand-->
    <!--begin::Sidebar Wrapper-->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!--begin::Sidebar Menu-->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">

               
                        @can('Admin\Budvar\DashboardController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.dashboard') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Dashboard</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\ProductController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.product.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Sản phẩm</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\PostController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.post.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Tin tức</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\PageController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.page.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Page</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\ContactController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.contact.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Khách hàng liên hệ</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\UserController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.user.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Tài khoản khách hàng</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\CategoryController@index')
                        {{-- <li class="nav-item"> <a href="{{ route('admin.budvar.brand.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Brand</p>
                            </a> </li> --}}
                        <li class="nav-item"> <a href="{{ route('admin.budvar.category.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Danh mục sản phẩm</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\SliderController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.slider.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Slider</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\MediaController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.media.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Media</p>
                            </a> </li>
                        @endcan
                        @can('Admin\Budvar\MenuController@index')
                        <li class="nav-item"> <a href="{{ route('admin.budvar.menu.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
                                <p>Menu</p>
                            </a> </li>
                        @endcan
                    
            </ul>
            <!--end::Sidebar Menu-->
        </nav>
    </div>
    <!--end::Sidebar Wrapper-->
</aside>
<!--end::Sidebar-->
<!--begin::App Main-->