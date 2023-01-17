<!-- Top Bar Start -->
<div class="topbar">

    <!-- LOGO -->
    <div class="topbar-left">
        {{-- <a href="index.html" class="logo"><span>Frame<span>works</span></span><i class="mdi mdi-layers"></i></a> --}}
        <!-- Image logo -->
        <a href="{{ route('dashboard') }}" class="logo">
            <span>
                <img src="{{ url('public') }}/assets/images/logo.png" alt="" height="60">
            </span>
            <i>
                <img src="{{ url('public') }}/assets/images/logo.png" alt="" height="28">
            </i>
        </a>
    </div>

    <!-- Button mobile view to collapse sidebar menu -->
    <div class="navbar navbar-default" role="navigation">
        <div class="container">

            <!-- Navbar-left -->
            <ul class="nav navbar-nav navbar-left">
                <li>
                    <button class="button-menu-mobile open-left waves-effect">
                        <i class="mdi mdi-menu"></i>
                    </button>
                </li>
            </ul>

            <!-- Right(Notification) -->
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown user-box">
                    <a href="" class="dropdown-toggle waves-effect user-link" data-toggle="dropdown" aria-expanded="true">
                        <img src="{{ url('public') }}/assets/images/users/avatar-1.jpg" alt="user-img" class="img-circle user-img">
                    </a>

                    <ul class="dropdown-menu dropdown-menu-right arrow-dropdown-menu arrow-menu-right user-list notify-list">
                        <li>
                            <h5>Hi, {{ Auth::user()->name }}</h5>
                        </li>
                        <li><a href="{{ route('myprofile') }}"><i class="ti-user m-r-5"></i>My Profile</a></li>
                        <li><a href="{{ route('changepassword') }}"><i class="ti-settings m-r-5"></i> Change Password</a></li>
                        <!-- <li><a href="javascript:void(0)"><i class="ti-lock m-r-5"></i> Lock screen</a></li> -->
                        <li>
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); 
                            document.getElementById('logout-form').submit();">
                                <i class="ti-power-off m-r-5"></i>
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                        </li>
                    </ul>
                </li>

            </ul> <!-- end navbar-right -->

        </div><!-- end container -->
    </div><!-- end navbar -->
</div>
<!-- Top Bar End -->