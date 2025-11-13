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

  @php
    $role = auth()->user()->role ?? null;

    // Lightweight counts (guard in try/catch to avoid issues if tables missing)
    $unreadMessages = 0;
    $pendingComplaints = 0;

    try { $unreadMessages = \App\Models\ContactMessage::where('is_read', false)->count(); } catch (\Throwable $e) {}
    try { $pendingComplaints = \App\Models\Complaint::where('status','pending')->count(); } catch (\Throwable $e) {}

    // Helper for active states
    $isActive = fn(string $namePattern) => request()->routeIs($namePattern) ? 'active' : '';
  @endphp

  <div class="sidebar-menu">
    <ul class="nav flex-column">

      <li class="nav-item">
        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ $isActive('admin.dashboard') }}">
          <i class="fas fa-chart-line"></i>
          <span>Dashboard</span>
        </a>
      </li>

      {{-- Customers: visible to admin/superadmin/sale/marketing --}}
      @if(in_array($role, ['admin','superadmin','sale','marketing']))
      <li class="nav-item">
        <a href="{{ route('admin.customers.index') }}" class="nav-link {{ $isActive('admin.customers.*') }}">
          <i class="fas fa-user-friends"></i>
          <span>Customers</span>
        </a>
      </li>
      @endif

      {{-- Loan Types: typically admin-only (allow superadmin/admin) --}}
      @if(in_array($role, ['admin','superadmin']))
      <li class="nav-item">
        <a href="{{ route('admin.loan-types.index') }}" class="nav-link {{ $isActive('admin.loan-types.*') }}">
          <i class="fas fa-hand-holding-usd"></i>
          <span>Loan Types</span>
        </a>
      </li>

      {{-- Slideshows --}}
      <li class="nav-item">
        <a href="{{ route('admin.slideshows.index') }}" class="nav-link {{ $isActive('admin.slideshows.*') }}">
          <i class="fas fa-images"></i>
          <span>Slideshows</span>
        </a>
      </li>

      {{-- Blog Posts --}}
      <li class="nav-item">
        <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ $isActive('admin.blogs.*') }}">
          <i class="fas fa-newspaper"></i>
          <span>Blog Posts</span>
        </a>
      </li>

      {{-- Job Positions / Applications --}}
      <li class="nav-item">
        <a href="{{ route('admin.jobs.index') }}" class="nav-link {{ $isActive('admin.jobs.*') }}">
          <i class="fas fa-briefcase"></i>
          <span>Job Positions</span>
        </a>
      </li>

      <li class="nav-item">
        <a href="{{ route('admin.job-applications') }}" class="nav-link {{ $isActive('admin.job-applications') }}">
          <i class="fas fa-file-alt"></i>
          <span>Applications</span>
          @if($pendingApplications = (\App\Models\JobApplication::where('status','pending')->count() ?? 0))
            @if($pendingApplications > 0)
              <span class="badge bg-danger">{{ $pendingApplications }}</span>
            @endif
          @endif
        </a>
      </li>

      {{-- Complaints --}}
      <li class="nav-item">
        <a href="{{ route('admin.complaints.index') }}" class="nav-link {{ $isActive('admin.complaints.*') }}">
          <i class="fas fa-exclamation-triangle"></i>
          <span>Complaints</span>
          @if($pendingComplaints > 0)
            <span class="badge bg-warning text-dark">{{ $pendingComplaints }}</span>
          @endif
        </a>
      </li>

      {{-- Messages --}}
      <li class="nav-item">
        <a href="{{ route('admin.messages.index') }}" class="nav-link {{ $isActive('admin.messages.*') }}">
          <i class="fas fa-envelope"></i>
          <span>Messages</span>
          @if($unreadMessages > 0)
            <span class="badge bg-info">{{ $unreadMessages }}</span>
          @endif
        </a>
      </li>
      @endif

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
