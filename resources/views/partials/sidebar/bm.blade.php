@php
    $isSuratTugas = request()->is('formpst/index_keluar') ||
                    request()->is('formpst/index_masuk') ||
                    request()->is('formpst/index_surat');
@endphp

<!-- === Section Title (opsional) === -->
<li class="nav-header">SURAT TUGAS</li>

<!-- Menu Surat Tugas -->
<li class="nav-item">
    <a href="{{ route('formpst.index_keluar') }}"
       class="nav-link {{ request()->is('formpst/index_keluar') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope-open-text"></i>
        <p>Surat Keluar</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('formpst.index_masuk') }}"
       class="nav-link {{ request()->is('formpst/index_masuk') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Surat Masuk</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('formpst.index_surat') }}"
       class="nav-link {{ request()->is('formpst/index_surat') ? 'active' : '' }}">
        <i class="nav-icon fas fa-file-alt"></i>
        <p>Surat Tugas</p>
    </a>
</li>

<!-- === Section Title (opsional) === -->
<li class="nav-header">TIKET</li>

<!-- Menu List Keberangkatan -->
<li class="nav-item">
    <a href="{{ route('formpst.show_ticket') }}"
       class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane"></i>
        <p>List Keberangkatan</p>
    </a>
</li>
