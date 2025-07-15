<!-- Surat Tugas -->
<li class="nav-item has-treeview {{ request()->is('formpst/index_keluar') || request()->is('formpst/index_masuk') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('formpst/index_keluar') || request()->is('formpst/index_masuk') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>
            Surat Tugas
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formpst.index_keluar') }}" class="nav-link {{ request()->is('formpst/index_keluar') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Surat Keluar</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('formpst.index_masuk') }}" class="nav-link {{ request()->is('formpst/index_masuk') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Surat Masuk</p>
            </a>
        </li>
    </ul>
</li>

<!-- List Keberangkatan -->
<li class="nav-item">
    <a href="{{ route('formpst.show_ticket') }}" class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane"></i>
        <p>List Keberangkatan</p>
    </a>
</li>

<!-- Master Data -->
<li class="nav-item has-treeview {{ request()->is('ho/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('ho/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>
            Master Data
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('ho.user') }}" class="nav-link {{ request()->is('ho/user') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>User</p>
            </a>
        </li>
    </ul>
</li>
