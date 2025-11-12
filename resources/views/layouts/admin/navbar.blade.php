<nav class="admin-navbar">
    <div class="navbar-left">
        <button class="menu-toggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>
    </div>

    <div class="navbar-right">
        <div class="navbar-time">
            <i class="far fa-clock me-2"></i>
            <span id="current-time"></span>
        </div>

        <a href="#" class="navbar-user">
            <div class="navbar-user-avatar">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <span class="d-none d-md-inline">{{ auth()->user()->name }}</span>
        </a>
    </div>
</nav>
