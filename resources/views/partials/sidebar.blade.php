


<style>
    /* === Corporate Style Sidebar === */
    .main-sidebar {
    background: linear-gradient(to bottom, #e6f2ff, #f0f8ff) !important;
    color: #2c3e50 !important;
    border-right: 1px solid #cfd8dc;
}
.main-sidebar .profile-initials {
    background-color: #71b7ff; /* warna biru asli logo */
    color: #fff;
}

    .main-sidebar .brand-link {
        background-color: #e9ecef !important;
        color: #2c3e50;
        font-weight: 600;
    }

    .main-sidebar .user-panel {
        background-color: #ffffff;
        border-bottom: 1px solid #dcdcdc;
        padding: 15px 12px;
        color: #2c3e50;
        
    }

    .main-sidebar .profile-initials {
        background-color: #007bff; /* biru korporat */
        color: #fff;
        width: 35px;
        height: 35px;
        font-size: 18px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        text-transform: uppercase;
    }

    .main-sidebar .status {
        color: #6c757d;
        font-size: 12px;
    }

    .main-sidebar .nav-link {
        color: #34495e;
        transition: all 0.2s ease-in-out;
        position: relative;
        border-radius: 6px;
        margin: 2px 6px;
        padding: 8px 12px;
    }

    .main-sidebar .nav-link:hover {
        background-color: #e2e6ea;
        color: #212529 !important;
    }

    .main-sidebar .nav-link.active {
        background-color: #dbe9ff;
        color: #0d47a1 !important;
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
        background-color: #007bff; /* indikator biru */
        border-radius: 2px;
    }

    .main-sidebar .nav-icon {
        margin-right: 8px;
        color: #6c757d;
        transition: color 0.3s ease;
    }

    .main-sidebar .nav-link.active .nav-icon {
        color: #0d47a1;
    }

    /* State: expanded */
.main-sidebar.sidebar-expanded {
    width: 230px;
    transition: width 0.3s;
}

.main-sidebar.sidebar-expanded .nav-link p {
    display: inline;
}

.main-sidebar.sidebar-expanded .nav-icon {
    margin-right: 8px;
}

/* State: collapsed */
.main-sidebar.sidebar-collapsed {
    width: 60px;
    transition: width 0.3s;
    overflow-x: hidden;
}

.main-sidebar.sidebar-collapsed .nav-link p {
    display: none;
}

.main-sidebar.sidebar-collapsed .user-panel,
.main-sidebar.sidebar-collapsed .info,
.main-sidebar.sidebar-collapsed .status,
.main-sidebar.sidebar-collapsed .badge {
    display: none;
}

.main-sidebar.sidebar-collapsed .profile-initials {
    margin: auto;
}

/* Navigation items hover tooltip */
.main-sidebar.sidebar-collapsed .nav-link {
    position: relative;
}

.main-sidebar.sidebar-collapsed .nav-link:hover::after {
    content: attr(data-title);
    position: absolute;
    left: 100%;
    top: 50%;
    transform: translateY(-50%);
    background-color: #fff;
    color: #000;
    padding: 5px 10px;
    white-space: nowrap;
    border-radius: 4px;
    box-shadow: 0 0 5px rgba(0,0,0,0.2);
    margin-left: 10px;
    z-index: 1000;
}
</style>

<button id="sidebarToggle" class="btn btn-link px-2 py-1 text-dark position-fixed" style="top: 10px; left: 10px; z-index: 999;">
    <i class="fas fa-bars"></i>
</button>


<aside class="main-sidebar elevation-2">
    <!-- User Panel -->
    <div class="user-panel d-flex align-items-center px-3">
        <div class="image me-3">
            <div class="profile-initials">
                {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
            </div>
        </div>
        <div class="info" style="min-width: 0;">
            <a href="#" class="d-block fw-bold" style="font-size: 15px;">
                {{ Auth::user()->nama_lengkap }}
            </a>
            <p class="status mb-1">
                {{ Auth::user()->role }} - {{ Auth::user()->cabang_asal }}
            </p>
            <span class="badge bg-success" style="font-size: 12px;">Online</span>
        </div>
    </div>

    <!-- Sidebar Navigation -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            {{-- Role-specific sidebar --}}
            @php
                $user = auth()->user();
            @endphp

            @switch(true)
                @case($user->role === 'bm')
                    @include('partials.sidebar.bm')
                    @break

                @case($user->role === 'hrd' && $user->cabang_asal !== 'HO')
                    @include('partials.sidebar.hrd_cabang')
                    @break

                @case($user->role === 'nm')
                    @include('partials.sidebar.nm')
                    @break

                @case(($user->role === 'hrd' && $user->cabang_asal === 'HO') || $user->role === 'admin')
                    @include('partials.sidebar.hrd_ho_admin')
                    @break

                @case($user->role === 'pegawai')
                    @include('partials.sidebar.pegawai')
                    @break
            @endswitch
        </ul>
    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sidebar = document.querySelector('.main-sidebar');
        const toggleBtn = document.getElementById('sidebarToggle');

        toggleBtn.addEventListener('click', function () {
            sidebar.classList.toggle('sidebar-collapsed');
            sidebar.classList.toggle('sidebar-expanded');
        });
    });
</script>

