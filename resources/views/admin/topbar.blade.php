<nav class="navbar navbar-expand navbar-light bg-white topbar shadow mb-4 py-2 px-4">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Navbar Items -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Hapus Alerts dan Messages dari navbar -->

        <!-- Divider -->
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Icon Dropdown with Name and Role -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-lg text-gray-600"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <!-- Nama dan Role -->
                @if(session('user'))
                    <div class="px-3 py-2 text-secondary small">
                        {{ session('user')['name'] ?? '' }}
                        @if(session('user')['role'] ?? false)
                            <br><span class="text-muted">{{ ucfirst(session('user')['role']) }}</span>
                        @endif
                    </div>
                    <div class="dropdown-divider"></div>
                @endif

                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                        Logout
                    </button>
                </form>
            </div>
        </li>


    </ul>
</nav>
