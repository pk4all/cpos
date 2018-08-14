<!-- Navigation Bar-->
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">

            <!-- Logo container-->
            <div class="logo">
                <!-- Text Logo -->
                <!--<a href="index.html" class="logo">-->
                <!--UBold-->
                <!--</a>-->
                <!-- Image Logo -->
                <a href="/" class="logo">
                    <img src="{{ asset("assets/images/logo_dark.png")}}" alt="" height="20" class="logo-lg">
                    <img src="{{ asset("assets/images/logo_sm.png")}}" alt="" height="24" class="logo-sm">
                </a>

            </div>
            <!-- End Logo container-->


            <div class="menu-extras topbar-custom">
                <ul class="navigation-menu list-inline float-left mb-0">

                    <li>
                        <a href="/"> <i class="md md-dashboard"></i>Dashboard</a>
                    </li>
                    <!--<li class="has-submenu">
                        <a href="#"><i class="md md-account-circle"></i>User</a>
                        <ul class="submenu">
                            <li>
                                <a href="/users">User List</a>
                            </li>
                            <li>
                                <a href="/users/create">Add New User</a>
                            </li>
                            <li>
                                <a href="/user-roles">Role List</a>
                            </li>
                            <li>
                                <a href="/user-roles/create">Add New Role</a>
                            </li>
                        </ul>
                    </li>-->
                   @if(is_array(Auth::user()->permissions) && key_exists('demon', Auth::user()->permissions) && Auth::user()->permissions['demon']=='yes')
                    <li class="has-submenu">
                        <a href="#"><i class="md-account-child"></i>Company</a>
                        <ul class="submenu">
                            <li>
                                <a href="/company">Company List</a>
                            </li>
                            <li>
                                <a href="/company/create">Add New Company</a>
                            </li>

                        </ul>
                    </li>
                    @else
                    <li class="has-submenu {{Request::segment(1)==null?'':'active'}}">
                        <a href="/setup"><i class="md  md-settings"></i>Setup</a>
                    </li>
                    @endif
                </ul>

                <ul class="list-inline float-right mb-0">

                    <li class="menu-item list-inline-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-light waves-effect" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <i class="dripicons-bell noti-icon"></i>
                            <span class="badge badge-pink noti-icon-badge">4</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg" aria-labelledby="Preview">
                            <!-- item-->
                            <div class="dropdown-item noti-title">
                                <h5><span class="badge badge-danger float-right">5</span>Notification</h5>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-success"><i class="icon-bubble"></i></div>
                                <p class="notify-details">Robert S. Taylor commented on Admin<small class="text-muted">1 min ago</small></p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-info"><i class="icon-user"></i></div>
                                <p class="notify-details">New user registered.<small class="text-muted">1 min ago</small></p>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <div class="notify-icon bg-danger"><i class="icon-like"></i></div>
                                <p class="notify-details">Carlos Crouch liked <b>Admin</b><small class="text-muted">1 min ago</small></p>
                            </a>

                            <!-- All-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item notify-all">
                                View All
                            </a>

                        </div>
                    </li>

                    <li class="list-inline-item dropdown notification-list">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                           aria-haspopup="false" aria-expanded="false">
                            <img src="{{ asset("assets/images/users/avatar-1.jpg")}}" alt="user" class="rounded-circle">
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown " aria-labelledby="Preview">
                            <!-- item-->
                            @if(Auth::user())
                            <a href="/profile" class="dropdown-item notify-item">
                                <i class="md md-account-circle"></i> <span>{{ucfirst(Auth::user()->name)}}</span>
                            </a>
                            @else
                            <a href="/login" class="dropdown-item notify-item">
                                <i class="md md-account-circle"></i> <span>Login</span>
                            </a>
                            @endif

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="md md-settings"></i> <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="md md-lock-open"></i> <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:.submit();" class="dropdown-item notify-item">
                                <form action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                    <i class="md md-settings-power"></i> <span onclick="$('form:first').submit()">Logout</span>
                                </form>

                            </a>

                        </div>
                    </li>

                </ul>
            </div>
            <!-- end menu-extras -->

            <div class="clearfix"></div>

        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->
    <!-- menu should be added here -->

</header>
<!-- End Navigation Bar-->
