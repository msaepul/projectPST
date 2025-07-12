<style>
    /* === Light Minimal Sidebar === */
    .main-sidebar {
        background-color: #ffffff !important;
        color: #333 !important;
        border-right: 1px solid #e0e0e0;
    }

    .main-sidebar .brand-link {
        background-color: #f1f2f6 !important;
        color: #333;
        font-weight: 600;
    }

    .main-sidebar .nav-link {
        color: #333;
        transition: all 0.2s ease-in-out;
        position: relative;
        border-radius: 6px;
        margin: 2px 6px;
        padding: 8px 12px;
    }

    .main-sidebar .nav-link:hover {
        background-color: #f1f1f1;
        color: #9ACDFF !important;
    }

    /* === Tampilan ACTIVE minimalis === */
    .main-sidebar .nav-link.active {
        background-color: transparent;
        color: #9ACDFF !important;
        font-weight: 600;
        position: relative;
    }

    .main-sidebar .nav-link.active::before {
        content: '';
        position: absolute;
        left: 0;
        top: 10%;
        bottom: 10%;
        width: 4px;
        background-color: #9ACDFF;
        border-radius: 2px;
    }

    .main-sidebar .nav-link.active i.nav-icon {
        color: #9ACDFF;
    }

    .main-sidebar .nav-icon {
        margin-right: 8px;
        transition: color 0.3s ease;
    }

    .main-sidebar .user-panel {
        background-color: #f9fafc;
        border-bottom: 1px solid #ddd;
        padding: 15px 12px;
        color: #333;
    }

    .main-sidebar .user-panel .profile-initials {
        background-color: #ffb347;
        color: #fff;
    }

    .main-sidebar .status {
        color: #666;
    }
</style>

<aside class="main-sidebar elevation-2">
    <div class="user-panel d-flex align-items-center px-3">
        <div class="image me-3">
            <div class="profile-initials"
                style="width: 35px; height: 35px; font-size: 18px;
                     display: flex; align-items: center; justify-content: center;
                     border-radius: 50%; text-transform: uppercase;">
                {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
            </div>
        </div>
        <div class="info" style="min-width: 0;">
            <a href="#" class="d-block fw-bold" style="font-size: 15px;">
                {{ Auth::user()->nama_lengkap }}
            </a>
            <p class="status mb-1" style="font-size: 12px;">
                {{ Auth::user()->role }} - {{ Auth::user()->cabang_asal }}
            </p>
            <span class="badge bg-success" style="font-size: 12px;">Online</span>
        </div>
    </div>

    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- Role-specific sidebar --}}
            @if (auth()->user()->role === 'bm')
                @include('partials.sidebar.bm')
            @elseif (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal !== 'HO')
                @include('partials.sidebar.hrd_cabang')
            @elseif (auth()->user()->role === 'nm')
                @include('partials.sidebar.nm')
            @elseif ((auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO') || auth()->user()->role === 'admin')
                @include('partials.sidebar.hrd_ho_admin')
            @elseif (auth()->user()->role === 'pegawai')
                @include('partials.sidebar.pegawai')
            @endif
        </ul>
    </nav>
</aside>
