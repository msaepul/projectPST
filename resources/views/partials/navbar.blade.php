<!-- === Animated Navbar === -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light px-3">
    <!-- Branding -->
    <a href="https://www.arnonbakery.com/" class="navbar-brand animated-brand">
        <img src="{{ asset('dist/img/arnon.png') }}" alt="Logo Arnon" class="logo me-2" height="32">
        {{-- <span>Arnon</span> --}}
    </a>

    <!-- Left Navbar (Optional) -->
    <ul class="navbar-nav ms-3">
        <li class="nav-item">
            <!-- Tambah item jika perlu -->
        </li>
    </ul>

    <!-- Right Navbar -->
    <ul class="navbar-nav ms-auto">
        <li class="nav-item dropdown">
            <a href="#" class="dropdown-item logout-animated text-danger"
                onclick="event.preventDefault(); animateLogout();">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar
            </a>

            <form id="logout-form" action="/logout" method="POST" class="d-none">
                @csrf
            </form>
        </li>
    </ul>
</nav>


<!-- === JavaScript for Logout Animation === -->
<script>
    function animateLogout() {
        const link = document.querySelector('.logout-animated');
        link.classList.add('clicked');
        setTimeout(() => {
            document.getElementById('logout-form').submit();
        }, 200); // Delay logout for animation
    }
</script>

<!-- Bootstrap (Opsional) -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
    /* === Navbar Appearance Animation === */
    .main-header {
        animation: fadeInNavbar 0.6s ease-in-out;
        background: linear-gradient(to right, #ffffff, #f8f9fa);
        transition: background-color 0.5s ease;
    }

    @keyframes fadeInNavbar {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .main-header:hover {
        background-color: #f0f4f8;
    }

    /* === Navbar Branding Animation === */
    .navbar-brand.animated-brand {
        font-weight: bold;
        font-size: 1.25rem;
        animation: slideInLeft 0.8s ease-out;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    @keyframes slideInLeft {
        from {
            opacity: 0;
            transform: translateX(-30px);
        }

        to {
            opacity: 1;
            transform: translateX(0);
        }
    }

    /* === Navbar Items Hover Effect === */
    .navbar-nav .nav-item a {
        transition: color 0.3s ease, transform 0.3s ease;
    }

    .navbar-nav .nav-item a:hover {
        color: #007bff;
        transform: translateY(-2px);
    }

    /* === Logout Animation === */
    .logout-animated {
        position: relative;
        overflow: hidden;
        display: inline-block;
        padding: 8px 16px;
        font-weight: 600;
        color: #dc3545 !important;
        transition: all 0.3s ease;
    }

    .logout-animated::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(220, 53, 69, 0.1);
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
        z-index: -1;
    }

    .logout-animated:hover::after {
        transform: scaleX(1);
    }

    .logout-animated:hover {
        color: #fff !important;
        background-color: #dc3545 !important;
        border-radius: 6px;
    }

    .logout-animated.clicked {
        transform: scale(0.95);
        transition: transform 0.1s ease;
    }

    .logout-animated:hover i {
        animation: bounceIcon 0.6s;
    }

    @keyframes bounceIcon {
        0% {
            transform: translateY(0);
        }

        30% {
            transform: translateY(-5px);
        }

        60% {
            transform: translateY(3px);
        }

        100% {
            transform: translateY(0);
        }
    }

    /* === Branding Logo and Text === */
    .navbar-brand.animated-brand {
        font-weight: bold;
        font-size: 1.25rem;
        animation: slideInLeft 0.8s ease-out;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .navbar-brand img.logo {
        height: 32px;
        transition: transform 0.3s ease;
    }

    .navbar-brand:hover img.logo {
        transform: rotate(-3deg) scale(1.05);
    }
</style>
