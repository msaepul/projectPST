@php
    use Illuminate\Support\Str;

    $currentPath = request()->path();
    $isListSurat = Str::contains($currentPath, ['formpst/index_keluar', 'formpst/index_keluar_ho']);
    $isMasterData = Str::startsWith($currentPath, 'ho/');
@endphp

<!-- === List Surat === -->
<li class="nav-item has-treeview {{ $isListSurat ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ $isListSurat ? 'active' : '' }}">
        <i class="nav-icon fas fa-envelope"></i>
        <p>
            List Surat
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('formpst.index_keluar', ['tipe' => 'cabang']) }}"
               class="nav-link {{ request()->fullUrlIs('*tipe=cabang*') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Surat dari Cabang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('formpst.index_keluar_ho', ['cabang' => 'HO']) }}"
               class="nav-link {{ request()->get('cabang') === 'HO' ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i>
                <p>Surat dari HO</p>
            </a>
        </li>
    </ul>
</li>

<!-- === Ticketing === -->
<li class="nav-item">
    <a href="{{ route('formpst.ticket') }}"
       class="nav-link {{ request()->is('formpst/ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-car"></i>
        <p>Ticketing</p>
    </a>
</li>

<!-- === List Keberangkatan === -->
<li class="nav-item">
    <a href="{{ route('formpst.show_ticket') }}"
       class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
        <i class="nav-icon fas fa-plane"></i>
        <p>List Keberangkatan</p>
    </a>
</li>

<!-- === Master Data === -->
<li class="nav-item has-treeview {{ $isMasterData ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ $isMasterData ? 'active' : '' }}">
        <i class="nav-icon fas fa-building"></i>
        <p>
            Master Data
            <i class="fas fa-angle-left right"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('ho.cabang') }}"
               class="nav-link {{ request()->is('ho/cabang') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Cabang</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ho.tujuan') }}"
               class="nav-link {{ request()->is('ho/tujuan') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Daftar Penugasan</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ho.departemen') }}"
               class="nav-link {{ request()->is('ho/departemen') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Departemen</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ho.maskapai') }}"
               class="nav-link {{ request()->is('ho/maskapai') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Maskapai</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ho.transport') }}"
               class="nav-link {{ request()->is('ho/transport') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>Transport</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('ho.user') }}"
               class="nav-link {{ request()->is('ho/user') ? 'active' : '' }}">
                <i class="far fa-circle nav-icon"></i><p>User</p>
            </a>
        </li>
    </ul>
</li>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.nav-item.has-treeview > a').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.closest('.has-treeview');
                const submenu = parent.querySelector('.nav-treeview');

                parent.classList.toggle('menu-open');
                if (submenu) {
                    submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                }
            });
        });
    });
</script>
@endpush

