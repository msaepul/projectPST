<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Form Persetujuan')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- CSS Frameworks & Plugins -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
    <link rel="stylesheet" href="https://unpkg.com/nice-forms.css/nice-forms.css">

    <!-- Custom Styles -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <title>Form Persetujuan</title>



    <!-- Bootstrap & AdminLTE -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- Plugin Styles -->

    <!-- Custom CSS -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/nice-forms.css@1.1.0/nice-forms.min.css" rel="stylesheet">

    <!-- jQuery & Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <!-- Bootstrap Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        :root {
            --main-bg: #f4f6f9;
            --primary: #007bff;
            --secondary: #6c757d;
            --success: #28a745;
            --danger: #dc3545;
            --warning: #ffc107;
            --light: #f8f9fa;
            --dark: #343a40;
            --rounded: 0.5rem;
            --transition: all 0.3s ease-in-out;
        }

        body {
            background-color: var(--main-bg);
            font-family: 'Source Sans Pro', sans-serif, Arial, sans-serif;
            font-size: 15px;
            line-height: 1.6;
        }

        .card {
            border-radius: var(--rounded);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.05);
            border: none;
            overflow: hidden;
        }

        .card-header,
        .card-footer {
            background-color: #fff;
            border-bottom: 1px solid #dee2e6;
            font-weight: 600;
            color: #495057;
        }

        /* .form-control,
        .select2-container .select2-selection--single {
            border-radius: var(--rounded);
            transition: var(--transition);
        } */

        /* .form-control:focus,
        .select2-container--default .select2-selection--single:focus {
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            border-color: var(--primary);
        } */

        .btn {
            border-radius: var(--rounded);
            transition: var(--transition);
            font-weight: 500;
            padding: 0.5rem 1.2rem;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Pastikan tinggi dan teks Select2 sejajar tengah */
        .select2-container--default .select2-selection--single {
            height: 38px;
            /* atau samakan dengan input yang lain */
            display: flex;
            align-items: center;
            padding-left: 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        /* Hilangkan offset atas dari teks */
        .select2-selection__rendered {
            line-height: normal !important;
            padding-left: 0 !important;
            padding-right: 0 !important;
        }

        /* Tanda panahnya tetap di kanan */
        .select2-selection__arrow {
            height: 100% !important;
            top: 0 !important;
            right: 6px;
        }


        .form-group {
            margin-bottom: 1rem;
        }

        /* Table Styling */
        .table th,
        .table td {
            vertical-align: middle !important;
        }

        /* Sidebar */
        .main-sidebar {
            background: #222d32;
            transition: width 0.3s ease;
        }

        .main-sidebar .nav-link {
            transition: background-color 0.2s ease-in-out, color 0.2s ease-in-out;
        }

        .main-sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            border-radius: var(--rounded);
        }

        .main-sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.05);
            border-radius: var(--rounded);
            color: #fff;
        }

        /* User Panel */
        .user-panel {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding-bottom: 10px;
        }

        .profile-initials {
            font-weight: bold;
        }

        /* SweetAlert Toast */
        .swal2-popup {
            font-size: 14px !important;
            font-family: 'Source Sans Pro', sans-serif;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .card-header h4 {
                font-size: 16px;
            }

            .btn {
                font-size: 14px;
            }

            .main-sidebar {
                font-size: 14px;
            }

            .user-panel .info a {
                font-size: 14px;
            }

            .user-panel .status {
                font-size: 11px;
            }
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('partials.navbar')

        <!-- Sidebar -->
        @include('partials.sidebar')


        <!-- Content -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">@yield('header')</div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <section class="content">
                <div class="container-fluid">@yield('content')</div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer text-center py-2 bg-white">
            <strong>&copy; {{ date('Y') }} PT. Adonai Alfa Omega</strong>
        </footer>
    </div>

    <!-- Scripts -->
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
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
    </script>

    <!-- jQuery & JS Libraries -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- PDF.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.min.js"></script>
    <script>
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.4.120/pdf.worker.min.js';
    </script>

    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.js') }}"></script>




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

    @stack('scripts')
</body>

</html>
