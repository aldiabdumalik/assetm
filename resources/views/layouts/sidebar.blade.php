<div class="left side-menu">
    <div class="slimscroll-menu" id="remove-scroll">
        <!-- LOGO -->
        <div class="topbar-left">
            <a href="#" class="logo">
                <span>
                    <img src="{{asset('templates/assets/images/laravel.svg')}}" alt="" height="35">
                </span>
                <i>
                    <img src="{{asset('templates/assets/images/laravel.svg')}}" alt="" height="28">
                </i>
            </a>
        </div>
        <!-- User box -->
        <div class="user-box">
            <div class="user-img">
                <img src="{{asset('files/avatar/default.jpg')}}" alt="user-img" title="p" class="rounded-circle img-fluid">
            </div>
            <h5>
                <a href="#">
                    {{auth()->user()->name}}
                </a>
            </h5>
            <p class="text-muted">
                {{auth()->user()->level == 1 ? 'Admin' : 'Staff'}}
            </p>
        </div>
        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul class="metismenu" id="side-menu">

                <li>
                    <a href="{{route('dashboard')}}">
                        <i class="fi-air-play"></i> <span> Dashboard </span>
                    </a>
                </li>

                @if (auth()->user()->level == 1)
                    
                <li>
                    <a href="javascript: void(0);"><i class="fi-cog"></i> <span> Master </span> <span class="menu-arrow"></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li><a href="{{route('user')}}">User</a></li>
                        <li><a href="{{route('regional')}}">Regional</a></li>
                        <li><a href="{{route('item')}}">Item</a></li>
                    </ul>
                </li>

                @endif

                <li>
                    <a href="{{route('arrival')}}">
                        <i class="fi-inbox"></i> <span> I.G.I </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('testing')}}">
                        <i class="fi-cog"></i> <span> Uji Fungsi </span>
                    </a>
                </li>

                <li>
                    <a href="{{route('packing')}}">
                        <i class="fi-box"></i> <span> Packing List</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('pengiriman')}}">
                        <i class="fi-location"></i> <span> Pengiriman</span>
                    </a>
                </li>

                <li>
                    <a href="{{route('dashboard')}}">
                        <i class="fi-download"></i> <span> Report </span>
                    </a>
                </li>

            </ul>
        </div>
        <!-- Sidebar -->
        <div class="clearfix"></div>
    </div>
    <!-- Sidebar -left -->
</div>