<li class="nav-item">
    <a href="{{ route('formpst.form') }}" class="nav-link {{ request()->is('formpst/form') ? 'active' : '' }}">
        <i class="nav-icon fas fa-copy"></i><p>Pengajuan Surat Tugas</p>
    </a>
</li>
<li class="nav-item has-treeview {{ request()->is('formpst/*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ request()->is('formpst/*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i><p>Surat Tugas<i class="fas fa-angle-left right"></i></p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item"><a href="{{ route('formpst.index_keluar') }}" class="nav-link {{ request()->is('formpst/index_keluar') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Surat Keluar</p></a></li>
        <li class="nav-item"><a href="{{ route('formpst.index_masuk') }}" class="nav-link {{ request()->is('formpst/index_masuk') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Surat Masuk</p></a></li>
        <li class="nav-item"><a href="{{ route('formpst.index_surat') }}" class="nav-link {{ request()->is('formpst/index_surat') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Surat Tugas</p></a></li>
    </ul>
</li>
<li class="nav-item">
    <a href="{{ route('formpst.ticket') }}" class="nav-link {{ request()->is('formpst/ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-car"></i><p>Ticketing</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('formpst.show_ticket') }}" class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane"></i><p>List Keberangkatan</p>
    </a>
</li>
