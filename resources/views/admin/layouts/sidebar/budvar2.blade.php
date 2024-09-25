@can('Budvar')
<li class="nav-item pcoded-menu-caption">
    <label>BUDVAR</label>
</li>
@can('Admin\Budvar\MenuController@index')

<li class="nav-item pcoded-hasmenu">
    <a href="#!" class="nav-link "><span class="pcoded-micon"><i class="feather icon-monitor"></i></span><span class="pcoded-mtext">Website</span></a>
    <ul class="pcoded-submenu">
        @can('Admin\Budvar\CategoryController@index') <li><a href="{{ route('admin.budvar.category.index') }}">Danh mục</a></li> @endcan
        @can('Admin\Budvar\ProductController@index') <li><a href="{{ route('admin.budvar.product.index') }}">Sản phẩm</a></li> @endcan
        @can('Admin\Budvar\PostController@index') <li><a href="{{ route('admin.budvar.post.index') }}">Tin tức</a></li> @endcan
        @can('Admin\Budvar\ContactController@index') <li><a href="{{ route('admin.budvar.contact.index') }}">Liên hệ - Đặt hàng</a></li> @endcan
        @can('Admin\Budvar\MenuController@index') <li><a href="{{ route('admin.budvar.menu.index') }}">Menu</a></li> @endcan
        @can('Admin\Budvar\SliderController@index') <li><a href="{{ route('admin.budvar.slider.index') }}">Slider - Banner</a></li> @endcan
        @can('Admin\Budvar\HistoryController@index') <li><a href="{{ route('admin.budvar.history.index') }}">Lịch sử</a></li> @endcan
        @can('Admin\Budvar\MediaController@index') <li><a href="{{ route('admin.budvar.media.index') }}">Media - File</a></li> @endcan
    </ul>
</li>
@endcan
@can('Admin\Budvar\PageController@index')
<li class="nav-item "> <a href="{{ route('admin.budvar.page.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-activity"></i></span>
        <span class="pcoded-mtext">Trang - Sự kiện</span> </a></li>



@endcan
@can('Admin\Budvar\PromotionController@index')
<li class="nav-item "> <a href="{{ route('admin.budvar.promotion.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-layers"></i></span>
        <span class="pcoded-mtext">Khuyến mãi</span> </a></li>
@endcan
@can('Admin\Budvar\VoucherController@index')
<li class="nav-item "> <a href="{{ route('admin.budvar.voucher.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-printer"></i></span>
        <span class="pcoded-mtext">Phiếu quà tặng</span> </a></li>
@endcan
@can('Admin\Budvar\CustomerController@index')
<li class="nav-item "> <a href="{{ route('admin.budvar.customer.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-users"></i></span>
        <span class="pcoded-mtext">Tài khoản khách hàng</span> </a></li>
@endcan
@can('Admin\Budvar\UserController@index')
<li class="nav-item "> <a href="{{ route('admin.budvar.user.index') }}" class="nav-link "> <span class="pcoded-micon"><i class="feather icon-unlock"></i></span>
        <span class="pcoded-mtext">Tài khoản Quản trị</span> </a></li>
@endcan

@endcan
