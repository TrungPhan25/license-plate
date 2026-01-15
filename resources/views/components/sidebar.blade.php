<!-- Sidebar Overlay (Mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- Sidebar -->
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">Menu chính</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/violations*') ? 'active' : '' }}" href="{{ route('admin.violations.index') }}">
                <i class="fas fa-car"></i>
                Vi phạm giao thông
            </a>
        </li>
    </ul>

    <div class="sidebar-header">Quản lý</div>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users"></i>
                Người dùng
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('settings*') ? 'active' : '' }}" href="#">
                <i class="fas fa-cogs"></i>
                Cài đặt
            </a>
        </li>
    </ul>
</nav>