<header class="topbar" data-navbarbg="skin5">
    <nav class="navbar top-navbar navbar-expand-md navbar-dark">
        <div class="navbar-header" data-logobg="skin5">
            <!-- This is for the sidebar toggle which is visible on mobile only -->
            <a class="nav-toggler waves-effect waves-light d-block d-md-none" href="javascript:void(0)"><i class="ti-menu ti-close"></i></a>
            <!-- ============================================================== -->
            <!-- Logo -->
            <!-- ============================================================== -->
            <a class="navbar-brand" href="{{route('dashboard')}}">
                <!-- Logo icon -->
                <b class="logo-icon p-l-10">
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    
                    <div><img src="{{asset('upload/images/'.Session::get('companySettings')[0]['vertical_logo'])}}" alt="homepage" width="60" height="55" class="light-logo" /> {{Session::get('companySettings')[0]['name']}}</div>
                    <!-- <img src="{{asset('backend/assets/images/logo-icon.png')}}" alt="homepage" class="light-logo" /> -->

                </b>
                <!--End Logo icon -->
                 <!-- Logo text -->
                <span class="logo-text">
                     <!-- dark Logo text -->
                     <!-- <img src="{{asset('backend/assets/images/logo-text.png')}}" alt="homepage" class="light-logo" /> -->
                  
                </span>
                <!-- Logo icon -->
                <!-- <b class="logo-icon"> -->
                    <!--You can put here icon as well // <i class="wi wi-sunset"></i> //-->
                    <!-- Dark Logo icon -->
                    <!-- <img src="{{asset('public/backend/')}}assets/images/logo-text.png" alt="homepage" class="light-logo" /> -->

                <!-- </b> -->
                <!--End Logo icon -->
            </a>
           
            <a class="topbartoggler d-block d-md-none waves-effect waves-light" href="javascript:void(0)" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><i class="ti-more"></i></a>
        </div>
        <!-- ============================================================== -->
        <!-- End Logo -->
        <!-- ============================================================== -->
        <div class="navbar-collapse collapse" id="navbarSupportedContent" data-navbarbg="skin5">
            <!-- ============================================================== -->
            <!-- toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-left mr-auto">
                <li class="nav-item d-none d-md-block"><a class="nav-link sidebartoggler waves-effect waves-light" href="javascript:void(0)" data-sidebartype="mini-sidebar"><i class="mdi mdi-menu font-24"></i></a></li>
                <!-- ============================================================== -->
                <!-- create new -->
                <!-- ============================================================== -->

                <!-- ============================================================== -->
                <!-- Search -->
                <!-- ============================================================== -->
                <li class="nav-item search-box"> <a class="nav-link waves-effect waves-dark" href="javascript:void(0)"><i class="ti-search"></i></a>
                    <form class="app-search position-absolute">
                        <input type="text" class="form-control" placeholder="Search &amp; enter"> <a class="srh-btn"><i class="ti-close"></i></a>
                    </form>
                </li>
            </ul>
            <!-- ============================================================== -->
            <!-- Right side toggle and nav items -->
            <!-- ============================================================== -->
            <ul class="navbar-nav float-right">
                <!-- Message -->
                <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle waves-effect waves-dark" href="" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="font-24 mdi mdi-comment-processing"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right mailbox animated bounceInDown" aria-labelledby="2">
                        <ul class="list-style-none">
                            <li>
                                <div class="">
                                    <a href="javascript:void(0)" class="link border-top">
                                        <div class="d-flex no-block align-items-center p-10">
                                            <span class="btn btn-success btn-circle"><i class="ti-calendar"></i></span>
                                            <div class="m-l-10">
                                                <h5 class="m-b-0">Event today</h5>
                                                <span class="mail-desc">Just a reminder that event</span>
                                            </div>
                                        </div>
                                    </a>
                                    <a href="javascript:void(0)" class="link border-top">
                                        <div class="d-flex no-block align-items-center p-10">
                                            <span class="btn btn-info btn-circle"><i class="ti-settings"></i></span>
                                            <div class="m-l-10">
                                                <h5 class="m-b-0">Settings</h5>
                                                <span class="mail-desc">You can customize this template</span>
                                            </div>
                                        </div>
                                    </a>

                                </div>
                            </li>
                        </ul>
                    </div>
                </li> -->
                <!-- Message -->

              
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark pro-pic" href="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{(!empty(Auth::user()->image))?url('upload/user_images/'.Auth::user()->image):url('upload/no-image.jpg')}}" alt="user" class="rounded-circle" width="31"></a>
                    <div class="dropdown-menu dropdown-menu-right user-dd animated">
                        <a class="dropdown-item" href=""><i class="ti-user m-r-5 m-l-5"></i>{{Auth::user()->name}}</a>
                        <a class="dropdown-item" href="{{route('users.edit_user_password')}}"  onclick="showUserInfo()"><i class="fas fa-edit"></i></i> Update Password</a>

                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item dropdown-footer">
                            <i class="fas fa-sign-out-alt m-l-5"></i>
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- User profile and search -->
                <!-- ============================================================== -->
            </ul>
        </div>
    </nav>
</header>
<div id="loading" style="display:none;">
    <img id="loading-image" src="{{url('upload/images/loader.gif')}}" alt="Loading..."  />
</div>