<div class="topbar">

    <nav class="navbar-custom">

        <ul class="list-unstyled topbar-right-menu float-right mb-0">

            <li class="hide-phone app-search">
                {{-- <form>
                    <input type="text" placeholder="Search..." class="form-control">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form> --}}
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button"
                   aria-haspopup="false" aria-expanded="false">
                    <img src="{{asset('files/avatar/default.jpg')}}" alt="p" class="rounded-circle"> <span class="ml-1">{{auth()->user()->name}}<i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-animated profile-dropdown">
                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h6 class="text-overflow m-0">Hi {{auth()->user()->name}}</h6>
                    </div>

                    <!-- item-->
                    <a href="{{route('logout')}}" class="dropdown-item notify-item">
                        <i class="fi-power"></i> <span>Logout</span>
                    </a>

                </div>
            </li>

        </ul>

        <ul class="list-inline menu-left mb-0">
            <li class="float-left">
                <button class="button-menu-mobile open-left disable-btn">
                    <i class="dripicons-menu"></i>
                </button>
            </li>
            <li>
                <div class="page-title-box">
                    <h4 class="page-title">@yield('title')</h4>
                    {{ Breadcrumbs::render() }}
                </div>
            </li>

        </ul>

    </nav>

</div>