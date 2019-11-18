<div class="sidebar">
    <nav class="sidebar-nav ps ps--active-y">

        <ul class="nav">
            <li class="nav-item">
                <a href="{{ route("admin.home") }}" class="nav-link">
                    <i class="fa fa-dashboard nav-icon"></i>

                    </i>
                    {{ trans('global.dashboard') }}
                </a>
            </li>
            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fa fa-users nav-icon">

                    </i>
                    {{ trans('global.administrator.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route('admin.usermanage.index') }}" class="nav-link {{ request()->is('admin/permissions') || request()->is('admin/permissions/*') ? 'active' : '' }}">
                            <i class="fa fa-address-book  nav-icon" aria-hidden="true"></i>

                            </i>
                            {{ trans('global.permissions.title') }}
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.Projectmanage.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.projectManage.title') }}
                        </a>
                    </li>
                    {{--<li class="nav-item">--}}
                        {{--<a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">--}}
                            {{--<i class="fas fa-user nav-icon">--}}

                            {{--</i>--}}
                            {{--{{ trans('global.user.title') }}--}}
                        {{--</a>--}}
                    {{--</li>--}}
                </ul>
            </li>

            {{-- Product Management Strat--}}

            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fa fa-users nav-icon">

                    </i>
                    {{ trans('global.productManages.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/productManagements') || request()->is('admin/productManagements/*') ? 'active' : '' }}">
                            <i class="fa fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('global.product_group.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa fa-user nav-icon">

                            </i>
                            {{ trans('global.productSubGroup.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.product_management_child.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                    /* Added By Mohiuddin */
                    <a href="{{ route("admin.unitmanage.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                    /* ------------------ */
                    <i class="fa fa-user nav-icon">

                    </i>
                    {{ trans('global.unitManages.title') }}
                    </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa fa-user nav-icon">

                            </i>
                            {{ trans('global.vendorManages.title') }}
                        </a>
                    </li>
                </ul>
            </li>
            {{-- Product Management End--}}

            {{-- Purchase Start--}}

            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fa fa-users nav-icon">

                    </i>
                    {{ trans('global.purchase.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/productManagements') || request()->is('admin/productManagements/*') ? 'active' : '' }}">
                            <i class="fa fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('global.localPurchase.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa fa-user nav-icon">

                            </i>
                            {{ trans('global.vendorPurchase.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.otherReceive.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa fa-user nav-icon">

                            </i>
                            {{ trans('global.purchaseReturn.title') }}
                        </a>
                    </li>

                </ul>
            </li>
            {{-- Purchase End--}}


            {{-- Sales Start--}}

            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fa fa-users nav-icon">

                    </i>
                    {{ trans('global.sales.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/productManagements') || request()->is('admin/productManagements/*') ? 'active' : '' }}">
                            <i class="fa fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('global.localSales.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa fa-user nav-icon">

                            </i>
                            {{ trans('global.customerSales.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.otherSales.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa fa-user nav-icon">

                            </i>
                            {{ trans('global.salesReturn.title') }}
                        </a>
                    </li>

                </ul>
            </li>
            {{-- Sales End--}}



            {{-- Reports Start--}}

            <li class="nav-item nav-dropdown">
                <a class="nav-link  nav-dropdown-toggle">
                    <i class="fa fa-users nav-icon">

                    </i>
                    {{ trans('global.reports.title') }}
                </a>
                <ul class="nav-dropdown-items">
                    <li class="nav-item">
                        <a href="{{ route("admin.permissions.index") }}" class="nav-link {{ request()->is('admin/productManagements') || request()->is('admin/productManagements/*') ? 'active' : '' }}">
                            <i class="fa fa-unlock-alt nav-icon">

                            </i>
                            {{ trans('global.purchaseReports.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.users.index") }}" class="nav-link {{ request()->is('admin/users') || request()->is('admin/users/*') ? 'active' : '' }}">
                            <i class="fa fa-user nav-icon">

                            </i>
                            {{ trans('global.salesReports.title') }}
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route("admin.roles.index") }}" class="nav-link {{ request()->is('admin/roles') || request()->is('admin/roles/*') ? 'active' : '' }}">
                            <i class="fa fa-briefcase nav-icon">

                            </i>
                            {{ trans('global.stockReports.title') }}
                        </a>
                    </li>



                </ul>
            </li>
            {{-- Reports End--}}











            <li class="nav-item">
                <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                    <i class="nav-icon fa fa-sign-out aria-hidden="true"">

                    </i>
                    {{ trans('global.logout') }}
                </a>
            </li>
        </ul>

        <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
            <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
        </div>
        <div class="ps__rail-y" style="top: 0px; height: 869px; right: 0px;">
            <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 415px;"></div>
        </div>
    </nav>
    <button class="sidebar-minimizer brand-minimizer" type="button"></button>
</div>
