<!-- Section Title (bisa pakai CSS custom atau tag h6) -->
<li class="nav-header">SURAT TUGAS</li>

<!-- Menu tanpa collapse -->
<li class="nav-item">
    <a href="{{ route('formpst.index_keluar') }}" class="nav-link {{ request()->is('formpst/index_keluar') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope-open"></i>
        <p>Surat Keluar</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('formpst.index_masuk') }}" class="nav-link {{ request()->is('formpst/index_masuk') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Surat Masuk</p>
    </a>
</li>

<!-- Item tambahan -->
<li class="nav-item">
    <a href="{{ route('formpst.show_ticket') }}" class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane"></i>
        <p>List Keberangkatan</p>
    </a>
</li>

<!-- Section Title -->
<li class="nav-header">MASTER DATA</li>

<li class="nav-item">
    <a href="{{ route('ho.user') }}" class="nav-link {{ request()->is('ho/user') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users"></i>
        <p>User</p>
    </a>
</li>
