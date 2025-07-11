<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Form Persetujuan</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Bootstrap & AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- Plugin Styles -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/nice-forms.css@1.1.0/nice-forms.min.css" rel="stylesheet">

    <!-- jQuery & Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- jQuery UI for Autocomplete -->
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</head>


<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Navbar Search -->
      <li class="nav-item">
        <a class="nav-link" data-widget="navbar-search" href="#" role="button">
          <i class="fas fa-search"></i>
        </a>
        <div class="navbar-search-block">
          <form class="form-inline">
            <div class="input-group input-group-sm">
              <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
              <div class="input-group-append">
                <button class="btn btn-navbar" type="submit">
                  <i class="fas fa-search"></i>
                </button>
                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </div>
          </form>
        </div>
      </li>

      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-comments"></i>
          <span class="badge badge-danger navbar-badge">3</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user8-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  John Pierce
                  <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">I got your message bro</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <!-- Message Start -->
            <div class="media">
              <img src="dist/img/user3-128x128.jpg" alt="User Avatar" class="img-size-50 img-circle mr-3">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Nora Silvester
                  <span class="float-right text-sm text-warning"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">The subject goes here</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
            <!-- Message End -->
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>
        {{-- <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <i class="fa fa-caret-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <a href="{{ route('data_diri.biodata') }}" class="dropdown-item">Show Profile</a>
                        <a href="{{ url('logout') }}" class="dropdown-item">Logout</a>
                    </div>
                </li>
            </ul>
        </nav> --}}
        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- User Panel -->
            <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center px-3">
                <div class="image me-3">
                    <div class="profile-initials"
                        style="width: 35px; height: 35px; background-color: #80bdc2; color: white; font-size: 18px; display: flex; align-items: center; justify-content: center; border-radius: 50%; text-transform: uppercase;">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap, 0, 1)) }}
                    </div>
                </div>
                <div class="info" style="min-width: 0;">
                    <a href="#" class="d-block text-white fw-bold"
                        style="font-size: 15px; white-space: normal; word-break: break-word;">
                        {{ Auth::user()->nama_lengkap }}
                    </a>
                    <p class="status text-light mb-1" style="font-size: 12px;">
                        {{ Auth::user()->role }} - {{ Auth::user()->cabang_asal }}
                    </p>
                    <span class="badge bg-success" style="font-size: 12px;">Online</span>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <li class="nav-item">
                        <a href="{{ route('dashboard') }}"
                            class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    @if (auth()->user()->role === 'bm')
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('formpst/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Surat Tugas<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('formpst.index_keluar') }}"
                                        class="nav-link {{ request()->is('formpst/index_keluar') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Keluar</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('formpst.index_masuk') }}"
                                        class="nav-link {{ request()->is('formpst/index_masuk') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('formpst.index_surat') }}"
                                        class="nav-link {{ request()->is('formpst/index_surat') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Tugas</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('formpst.show_ticket') }}"
                                class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plane"></i>
                                <p>List keberangkatan</p>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->role === 'hrd' && auth()->user()->cabang_asal !== 'HO')
                        {{-- <li class="nav-item">
                            <a href="{{ route('formpst.form') }}"
                                class="nav-link {{ request()->is('formpst/form') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>Pengajuan Surat Tugas</p>
                            </a>
                        </li> --}}
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('formpst/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p>Surat Tugas<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('formpst.index_keluar') }}"
                                        class="nav-link {{ request()->is('formpst/index_keluar') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Keluar</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('formpst.index_masuk') }}"
                                        class="nav-link {{ request()->is('formpst/index_masuk') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Masuk</p>
                                    </a>
                                </li>
                                {{-- <li class="nav-item">
                                    <a href="{{ route('formpst.index_surat') }}"
                                        class="nav-link {{ request()->is('formpst/index_surat') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Tugas</p>
                                    </a>
                                </li> --}}
                            </ul>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('formpst.show_ticket') }}"
                                class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plane"></i>
                                <p>List keberangkatan</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('ho/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Master Data<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">

                                <li class="nav-item">
                                    <a href="{{ route('ho.user') }}"
                                        class="nav-link {{ request()->is('ho/user') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (auth()->user()->role === 'nm')
                        <li class="nav-item">
                            <a href="{{ route('formpst.form') }}"
                                class="nav-link {{ request()->is('formpst/form') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-copy"></i>
                                <p>Pengajuan Surat Tugas</p>
                            </a>
                        </li>
                        {{-- <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('formpst/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p> Surat Tugas<i class="fas fa-angle-left right"></i></p>
                            </a> --}}
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('formpst.index_keluar') }}"
                                    class="nav-link {{ request()->is('formpst/index_keluar') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat Keluar</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('formpst.index_masuk') }}"
                                    class="nav-link {{ request()->is('formpst/index_masuk') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat Masuk</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('formpst.index_surat') }}"
                                    class="nav-link {{ request()->is('formpst/index_surat') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Surat Tugas</p>
                                </a>
                            </li>
                        </ul>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('formpst.ticket') }}"
                                class="nav-link {{ request()->is('formpst/ticket') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-car"></i>
                                <p>Ticketing </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('formpst.show_ticket') }}"
                                class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-car"></i>
                                <p>List keberangkatan </p>
                            </a>
                        </li>
                    @endif

                    @if ((auth()->user()->role === 'hrd' && auth()->user()->cabang_asal === 'HO') || auth()->user()->role === 'admin')
                        <!-- List Surat (Gabungan HO dan Cabang) -->
                        @php
                            // cocokkan semua URL/formpst/index_keluar…
                            $isListSurat = request()->is('formpst/index_keluar*');
                        @endphp

                        <li class="nav-item {{ $isListSurat ? 'menu-open' : '' }}">
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

                                        <p>Surat dari cabang</p>
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

                        {{-- <li class="nav-item">
                            <a href="{{ route('formpst.index_surat') }}"
                                class="nav-link {{ request()->is('formpst/index_surat') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Daftar Surat Tugas</p>
                            </a>
                        </li> --}}
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

                        <!-- Master Data -->
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('ho/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-building"></i>
                                <p>Master Data<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ho.cabang') }}"
                                        class="nav-link {{ request()->is('ho/cabang') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Cabang</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ho.tujuan') }}"
                                        class="nav-link {{ request()->is('ho/tujuan') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Daftar Penugasan</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ho.departemen') }}"
                                        class="nav-link {{ request()->is('ho/departemen') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Departemen</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ho.maskapai') }}"
                                        class="nav-link {{ request()->is('ho/maskapai') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Maskapai</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ho.transport') }}"
                                        class="nav-link {{ request()->is('ho/transport') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Transport</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ho.user') }}"
                                        class="nav-link {{ request()->is('ho/user') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>User</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif


                    @if (auth()->user()->role === 'pegawai')
                        <li class="nav-item">
                            <a href="#" class="nav-link {{ request()->is('formpst/*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-envelope"></i>
                                <p> Surat Tugas<i class="fas fa-angle-left right"></i></p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('formpst.index_keluar') }}"
                                        class="nav-link {{ request()->is('formpst/index_keluar') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Keluar</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('formpst.index_masuk') }}"
                                        class="nav-link {{ request()->is('formpst/index_masuk') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Masuk</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('formpst.index_surat') }}"
                                        class="nav-link {{ request()->is('formpst/index_surat') ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Surat Tugas</p>
                                    </a>
                                </li>
                            </ul>
                            @if (auth()->user()->departemen === 'QCT')
                        <li class="nav-item">
                            <a href="{{ route('formpst.index_surat') }}"
                                class="nav-link {{ request()->is('formpst/index_surat') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-book"></i>
                                <p>Daftar Surat Tugas </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('formpst.ticket') }}"
                                class="nav-link {{ request()->is('formpst/ticket') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-car"></i>
                                <p>Ticketing </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('formpst.show_ticket') }}"
                                class="nav-link {{ request()->is('formpst/show_ticket') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-plane"></i>
                                <p>List keberangkatan </p>
                            </a>
                        </li>
                    @endif
                    </li>
                    @endif
                </ul>
            </nav>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6"></div>
                    </div>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                    @yield('scripts')
                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer text-center py-2 bg-white">
            <strong>&copy; {{ date('Y') }} PT. Adonai Alfa Omega</strong>
        </footer>
    </div>

    <!-- jQuery (utama) -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button); // Resolusi konflik tooltip
    </script>

    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- DataTables (versi AdminLTE + Bootstrap 4) -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

    <!-- ChartJS, Sparkline, JQVMap, Knob -->
    <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
    <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>

    <!-- Daterangepicker -->
    <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Summernote -->
    <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

    <!-- overlayScrollbars -->
    <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Select2 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- FullCalendar -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
    </script>

    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>


    <!-- Inisialisasi Plugin dan Fitur -->
    <script>
        $(function() {
            // DataTables
            $('#example1').DataTable({
                responsive: true,
                lengthChange: false,
                autoWidth: false,
                buttons: [{
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    'copy', 'csv', 'excel', 'pdf'
                ],
                columnDefs: [{
                    targets: -1,
                    orderable: false
                }]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            // Select2
            $('#tujuan, #cabang, #cabang_asal').select2({
                placeholder: "Pilih...",
                allowClear: true,
                width: 'auto'
            });

            // SweetAlert Toast Example
            var Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });

            $('.swalDefaultSuccess').click(function() {
                Toast.fire({
                    icon: 'success',
                    title: 'Berhasil disimpan!'
                });
            });

            $(document).ready(function() {
                $('#tujuan').select2({
                    placeholder: "Pilih Tujuan",
                    allowClear: true,
                });
            });

            $(document).ready(function() {
                $('#cabang').select2({
                    placeholder: "Pilih cabang",
                    allowClear: true,
                });

            });
            $(document).ready(function() {
                $('#cabang_asal').select2({
                    placeholder: "Pilih cabang",
                    allowClear: true,
                    width: 'auto'
                });
            });

            // Menjaga menu tetap terbuka saat item diklik
            $('.nav-link').on('click', function() {
                var $this = $(this);
                if ($this.next('.nav-treeview').length) {
                    $this.next('.nav-treeview').toggle();
                }
            });
        });
    </script>
</body>

</html>
