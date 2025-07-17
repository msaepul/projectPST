@php
    use Illuminate\Support\Str;

    $currentPath = request()->path();
@endphp

<!-- === SECTION: LIST SURAT === -->
<li class="nav-header">LIST SURAT</li>

<li class="nav-item">
    <a href="{{ route('formpst.index_keluar', ['tipe' => 'cabang']) }}"
       class="nav-link {{ request()->fullUrlIs('*tipe=cabang*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope-open-text"></i>
        <p>Surat dari Cabang</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('formpst.index_keluar_ho', ['cabang' => 'HO']) }}"
       class="nav-link {{ request()->get('cabang') === 'HO' ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>Surat dari HO</p>
    </a>
</li>

<!-- === SECTION: TICKETING === -->
<li class="nav-header">TICKETING</li>

<li class="nav-item">
    <a href="{{ route('formpst.ticket') }}"
       class="nav-link {{ request()->is('formpst/ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-car"></i>
        <p>Ticketing</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('formpst.show_ticket') }}"
       class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane"></i>
        <p>List Keberangkatan</p>
    </a>
</li>

<!-- === SECTION: MASTER DATA === -->
<li class="nav-header">MASTER DATA</li>

<li class="nav-item">
    <a href="{{ route('ho.cabang') }}"
       class="nav-link {{ request()->is('ho/cabang') ? 'active' : '' }}">
        <i class="nav-icon fas fa-code-branch"></i>
        <p>Cabang</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('ho.tujuan') }}"
       class="nav-link {{ request()->is('ho/tujuan') ? 'active' : '' }}">
        <i class="nav-icon fas fa-map-marker-alt"></i>
        <p>Daftar Penugasan</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('ho.departemen') }}"
       class="nav-link {{ request()->is('ho/departemen') ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>Departemen</p>
    </a>
</li>

<li class="nav-item">
    <a href="{{ route('ho.maskapai') }}"
       class="nav-link {{ request()->is('ho/maskapai') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane-departure"></i>
        <p>Maskapai</p>
    </a>
</li>

{{-- <li class="nav-item">
    <a href="{{ route('ho.transport') }}"
       class="nav-link {{ request()->is('ho/transport') ? 'active' : '' }}">
        <i class="nav-icon fas fa-shuttle-van"></i>
        <p>Transport</p>
    </a>
</li> --}}

<li class="nav-item">
    <a href="{{ route('ho.user') }}"
       class="nav-link {{ request()->is('ho/user') ? 'active' : '' }}">
        <i class="nav-icon fas fa-users-cog"></i>
        <p>User</p>
    </a>
</li>
