<aside class="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('images/logo.png') }}" alt="GAS" class="sidebar-logo">
            <span class="brand-text">Admin Panel</span>
        </a>
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-times"></i>
        </button>
    </div>

    <div class="sidebar-menu">
        <ul class="nav flex-column">
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.loan-types.index') }}" class="nav-link {{ request()->routeIs('admin.loan-types.*') ? 'active' : '' }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Loan Types</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.slideshows.index') }}" class="nav-link {{ request()->routeIs('admin.slideshows.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i>
                    <span>Slideshows</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i>
                    <span>Blog Posts</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.jobs.index') }}" class="nav-link {{ request()->routeIs('admin.jobs.*') ? 'active' : '' }}">
                    <i class="fas fa-briefcase"></i>
                    <span>Job Positions</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.job-applications') }}" class="nav-link {{ request()->routeIs('admin.job-applications') ? 'active' : '' }}">
                    <i class="fas fa-file-alt"></i>
                    <span>Applications</span>
                    @php
                        $pendingApps = \App\Models\JobApplication::where('status', 'pending')->count();
                    @endphp
                    @if($pendingApps > 0)
                    <span class="badge bg-danger">{{ $pendingApps }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.complaints.index') }}" class="nav-link {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>Complaints</span>
                    @php
                        $pendingComplaints = \App\Models\Complaint::where('status', 'pending')->count();
                    @endphp
                    @if($pendingComplaints > 0)
                    <span class="badge bg-warning text-dark">{{ $pendingComplaints }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-item">
                <a href="{{ route('admin.messages.index') }}" class="nav-link {{ request()->routeIs('admin.messages.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i>
                    <span>Messages</span>
                    @php
                        $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count();
                    @endphp
                    @if($unreadMessages > 0)
                    <span class="badge bg-info">{{ $unreadMessages }}</span>
                    @endif
                </a>
            </li>

            <li class="nav-divider"></li>

            <li class="nav-item">
                <a href="{{ route('home') }}" class="nav-link" target="_blank">
                    <i class="fas fa-external-link-alt"></i>
                    <span>Visit Website</span>
                </a>
            </li>

            <li class="nav-item">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="nav-link btn btn-link text-start w-100" style="border: none; background: none;">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
    </div>
</aside>
