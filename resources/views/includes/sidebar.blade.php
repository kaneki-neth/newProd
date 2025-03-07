<div id="sidebar" class="app-sidebar" data-bs-theme="dark">
    <!-- BEGIN scrollbar -->
    <div class="app-sidebar-content" data-scrollbar="true" data-height="100%">
        <!-- BEGIN menu -->
        <div class="menu">
            <div class="menu-profile">
                <a href="javascript:;" class="menu-profile-link" data-toggle="app-sidebar-profile"
                    data-target="#appSidebarProfileMenu">
                    <div class="menu-profile-cover with-shadow"></div>
                    <!-- <div class="menu-profile-image">
                        <img src="{{ asset('assets/img/user/user-13.jpg') }}" alt="" />
                    </div> -->
                    <div class="menu-profile-info">
                        <div class="d-flex align-items-center">
                            <div class="flex-grow-1 text-center">
                                <!-- <img src="{{ url('/images/_logo.pngz') }}" alt="user_profile" width="80px"> -->
                                <img src="{{url('web/assets/img/matix_logo_white.png')}}" width="80px" data-aos="fade-in">
                            </div>
                            <div class="menu-caret ms-auto"></div>
                        </div>
                        <!-- <small>Frontend developer</small> -->
                    </div>
                </a>
            </div>
            <div id="appSidebarProfileMenu" class="collapse">
                @if(Auth::user()->can('company_settings'))
                    <div class="menu-item pt-5px" id="company_settings">
                        <a href="/settings/company" class="menu-link">
                            <div class="menu-icon"><i class="fa fa-cog"></i></div>
                            <div class="menu-text">Company Settings</div>
                        </a>
                    </div>
                @endif
                <div class="menu-item" id="myAccount">
                    <a href="/settings/myAccount" class="menu-link">
                        <div class="menu-icon"><i class="fa fa-user"></i></div>
                        <div class="menu-text"> My Account</div>
                    </a>
                </div>
                <div class="menu-divider m-0"></div>
            </div>

            <!-- <div class="menu-search mb-n3">
                <input type="text" class="form-control" placeholder="Sidebar menu filter..." data-sidebar-search="true" />
			</div> -->

            <div class="menu-header">Navigation</div>
            <div class="menu-item" id="home">
                <a href="/home" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-home"></i>
                    </div>
                    <div class="menu-text">Home</div>
                </a>
            </div>

            <div class="menu-item" id="category">
                <a href="/category" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-boxes-stacked"></i>
                    </div>
                    <div class="menu-text">Categories</div>
                </a>
            </div>

            <div class="menu-item" id="material">
                <a href="/material" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-boxes-stacked"></i>
                    </div>
                    <div class="menu-text">Materials</div>
                </a>
            </div>
            <div class="menu-item" id="videos">
                <a href="/videos" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-video"></i>
                    </div>
                    <div class="menu-text">Videos</div>
                </a>
            </div>
            <div class="menu-item" id="news_events">
                <a href="/news_events" class="menu-link">
                    <div class="menu-icon">
                        <i class="fa fa-newspaper"></i>
                    </div>
                    <div class="menu-text">News & Events</div>
                </a>
            </div>

            @if(Auth::user()->can('role-full') || Auth::user()->can('role-view') || Auth::user()->can('user-full') || Auth::user()->can('user-view'))
                <div class="menu-item has-sub" id="SysAdmin">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fa fa-key"></i>
                        </div>
                        <div class="menu-text">System Administration</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu" id="Sys_admin">
                        @if(Auth::user()->can('role-full') || Auth::user()->can('role-view'))
                            <div class="menu-item" id="role">
                                <a href="/sys_admin/role_controller" class="menu-link">
                                    <div class="menu-text">Roles</div>
                                </a>
                            </div>
                        @endif
                        @if(Auth::user()->can('user-full') || Auth::user()->can('user-view'))
                            <div class="menu-item" id="user">
                                <a href="/sys_admin/user" class="menu-link">
                                    <div class="menu-text">Users</div>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            @endif

            @if(Auth::user()->can('look_up_view') || Auth::user()->can('look_up_full'))
                <div class="menu-item has-sub" id="application">
                    <a href="javascript:;" class="menu-link">
                        <div class="menu-icon">
                            <i class="fa fa-gears"></i>
                        </div>
                        <div class="menu-text">Application Settings</div>
                        <div class="menu-caret"></div>
                    </a>
                    <div class="menu-submenu" id="developer">
                        <div class="menu-item has-sub" id="lookup">
                            <a href="javascript:;" class="menu-link">
                                <div class="menu-text">Developer</div>
                                <div class="menu-caret"></div>
                            </a>

                            <div class="menu-submenu">
                                <div class="menu-item" id="look">
                                    <a href="{{ route('app_lookup.index') }}" class="menu-link" id="look">
                                        <div class="menu-text">Lookups</div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- BEGIN minify-button -->
            <div class="menu-item d-flex">
                <a href="javascript:;"
                    class="app-sidebar-minify-btn ms-auto d-flex align-items-center text-decoration-none"
                    data-toggle="app-sidebar-minify"><i class="fa fa-angle-double-left"></i></a>
            </div>
            <!-- END minify-button -->
        </div>
        <!-- END menu -->
    </div>
    <!-- END scrollbar -->
</div>
<div class="app-sidebar-bg" data-bs-theme="dark"></div>
<div class="app-sidebar-mobile-backdrop"><a href="#" data-dismiss="app-sidebar-mobile" class="stretched-link"></a></div>