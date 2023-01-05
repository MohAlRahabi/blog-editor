<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('home')}}" class="brand-link">
        <img src="{{asset('images/logo.png')}}" alt="Website Logo" class="d-block" style="opacity: .8;width: 60%;margin: 0 auto;">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                @role(\App\Enums\UserRoleEnum::ADMIN)
                <li class="nav-item">
                    <a href="{{route('users.index')}}" class="nav-link {{ \Illuminate\Support\Str::startsWith(request()->fullUrl(),route('users.index')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                        </p>
                    </a>
                </li>
                @endrole

                <li class="nav-item">
                    <a href="{{route('articles.index')}}" class="nav-link {{ \Illuminate\Support\Str::startsWith(request()->fullUrl(),route('articles.index')) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-newspaper"></i>
                        <p>
                            Articles
                        </p>
                    </a>
                </li>

                {{--add new link--}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
