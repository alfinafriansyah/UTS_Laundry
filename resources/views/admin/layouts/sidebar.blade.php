<ul class="sidebar-nav" id="sidebar-nav">

    <li class="nav-item">
    <a class="nav-link {{ ($activeMenu != 'dashboard') ? 'collapsed' : '' }}" href="{{ url('admin/') }}">
        <i class="bi bi-grid"></i>
        <span>Dashboard</span>
    </a>
    </li><!-- End Dashboard Nav -->

    <li class="nav-item">
    <a class="nav-link {{ ($activeMenu != 'transaksi') ? 'collapsed' : '' }}" href="{{ url('admin/transaksi') }}">
        <i class="bi bi-cash"></i>
        <span>Transaksi</span>
    </a>
    <li class="nav-item">
    <a class="nav-link {{ ($activeMenu != 'history') ? 'collapsed' : '' }}" href="{{ url('admin/history') }}">
        <i class="bi bi-list-check"></i>
        <span>History Transaksi</span>
    </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
    <a class="nav-link {{ ($activeMenu != 'user') ? 'collapsed' : '' }}" href="{{ url('admin/user') }}">
        <i class="bi bi-person-badge"></i>
        <span>User</span>
    </a>
    </li>
    <li class="nav-item">
    <a class="nav-link {{ ($activeMenu != 'paket') ? 'collapsed' : '' }}" href="{{ url('admin/paket') }}">
        <i class="bi bi-file-text"></i>
        <span>Paket</span>
    </a>
    </li>
    <li class="nav-item">
    <a class="nav-link {{ ($activeMenu != 'pelanggan') ? 'collapsed' : '' }}" href="{{ url('admin/pelanggan') }}">
        <i class="bi bi-people"></i>
        <span>Pelanggan</span>
    </a>
    </li>
    <li class="nav-item">
    <a onclick = "confirmStaffAccess(event)" class="nav-link collapsed" href="#">
        <i class="bi bi-power"></i>
        <span>Ganti Role</span>
    </a>
    </li>

</ul>