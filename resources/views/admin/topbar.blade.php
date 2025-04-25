<nav class="navbar navbar-expand navbar-light bg-white topbar shadow mb-4 py-2 px-4">

    <!-- Sidebar Toggle -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Navbar Items -->
    <ul class="navbar-nav ml-auto align-items-center">

        <!-- Alerts -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button"
                data-toggle="dropdown">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">Alerts</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <div class="icon-circle bg-primary text-white mr-3">
                        <i class="fas fa-file-alt"></i>
                    </div>
                    <div>
                        <div class="small text-gray-500">Dec 12, 2024</div>
                        Monthly report is ready to download!
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Show all alerts</a>
            </div>
        </li>

        <!-- Messages -->
        <li class="nav-item dropdown no-arrow mx-2">
            <a class="nav-link dropdown-toggle" href="#" id="messagesDropdown" role="button"
                data-toggle="dropdown">
                <i class="fas fa-envelope fa-fw"></i>
                <span class="badge badge-danger badge-counter">7</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow" aria-labelledby="messagesDropdown">
                <h6 class="dropdown-header">Messages</h6>
                <a class="dropdown-item d-flex align-items-center" href="#">
                    <img class="rounded-circle mr-3" src="img/undraw_profile_1.svg" width="40" alt="">
                    <div>
                        <div class="text-truncate">Hi, can you help me with a problem I'm having?</div>
                        <div class="small text-gray-500">Emily · 58m</div>
                    </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Read more messages</a>
            </div>
        </li>

        <!-- Divider -->
        <div class="topbar-divider d-none d-sm-block"></div>

        <!-- User Icon Only -->
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-lg text-gray-600"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="{{ url('/logout') }}" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>

    </ul>
</nav>
