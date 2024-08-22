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
@can('Admin\Budvar\CategoryController@index')
<li class="nav-item"> <a href="{{ route('admin.budvar.category.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Danh mục </p>
    </a> </li>
@endcan
@can('Admin\Budvar\PostController@index')
<li class="nav-item"> <a href="{{ route('admin.budvar.post.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Tin tức</p>
    </a> </li>
@endcan
@can('Admin\Budvar\PageController@index')
<li class="nav-item"> <a href="{{ route('admin.budvar.page.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Trang - Sự kiện</p>
    </a> </li>
@endcan
@can('Admin\Budvar\ContactController@index')
<li class="nav-item"> <a href="{{ route('admin.budvar.contact.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Liên hệ - Đặt hàng</p>
    </a> </li>
@endcan
@can('Admin\Budvar\UserController@index')
<li class="nav-item"> <a href="{{ route('admin.budvar.user.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Tài khoản khách hàng</p>
    </a> </li>
@endcan

@can('Admin\Budvar\SliderController@index')
<li class="nav-item"> <a href="{{ route('admin.budvar.slider.index') }}" class="nav-link"> <i class="nav-icon bi bi-circle"></i>
        <p>Slider - Banner</p>
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
