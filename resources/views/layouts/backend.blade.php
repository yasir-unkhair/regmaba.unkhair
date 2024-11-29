<!DOCTYPE html>
<html lang="en">

    @php
        $pengaturan = pengaturan();
        $nama_sub_aplikasi = $pengaturan['nama-sub-aplikasi'];
        $nama_departemen = $pengaturan['nama-departemen'];
        $author = $pengaturan['author'];
        $logo = $pengaturan['logo'];
        $nama_aplikasi = $pengaturan['nama-aplikasi'];
    @endphp

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $nama_sub_aplikasi }} - {{ $nama_departemen }}</title>
        <meta name="description" content="{{ $nama_sub_aplikasi }} - {{ $nama_departemen }}" />
        <meta name="keywords" content="">
        <meta name="author" content="{{ $author }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Favicon icon -->
        <link rel="icon" href="{{ asset('images/' . $logo) }}" type="image/x-icon">

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet"
            href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('adminlte3') }}/plugins/fontawesome-free/css/all.min.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('adminlte3') }}/dist/css/adminlte.min.css">

        <link href="https://cdn.datatables.net/2.0.1/css/dataTables.dataTables.min.css" rel="stylesheet">

        <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.min.css " rel="stylesheet">

        @stack('style')

        <style>
            .warna-success {
                background-color: #d4edda;
            }

            .warna-info {
                background-color: #d1ecf1;
            }

            .warna-warning {
                background-color: #fff3cd;
            }

            .warna-danger {
                background-color: #f8d7da;
            }

            .warna-primary {
                background-color: #cce5ff;
            }

            .nav-tabs .nav-link.active {
                font-weight: bold;
                background-color: transparent;
                border-bottom: 3px solid #dd0000;
                border-right: none;
                border-left: none;
                border-top: none;
            }
        </style>

    </head>

    <body class="sidebar-mini control-sidebar-slide-open layout-fixed">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light border">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                                class="fas fa-bars"></i></a>
                    </li>
                </ul>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Navbar Search -->
                    @if (auth()->user()->roles()->count() > 1)
                        <li class="nav-item">
                            <select class="form-control form-control-md" onchange="location = this.value;">
                                <option value="">-- Ganti Peran --</option>
                                @foreach (auth()->user()->roles()->get() as $role)
                                    <option value="{{ route('change.role', $role->name) }}"
                                        {{ session('role') == $role->name ? 'selected' : '' }}>
                                        {{ ucwords(str_replace('-', ' ', $role->name)) }}</option>
                                @endforeach
                            </select>
                        </li>
                    @endif

                    <li class="nav-item">
                        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                            <i class="fas fa-expand-arrows-alt"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar elevation-4 sidebar-dark-lightblue">
                <!-- Brand Logo -->
                <a href="#" class="brand-link bg-light bg-white">
                    <img src="{{ asset('images/' . $logo) }}" alt="Unkhair Logo"
                        class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light"><b>{{ $nama_aplikasi }}</b></span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="{{ asset('images/user.png') }}" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{ auth()->user()->name }}</a>
                            @if (session('role'))
                                <a href="#" class="d-block">
                                    <span class="badge bg-primary">
                                        {{ ucwords(str_replace('-', ' ', session('role'))) }}
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- SidebarSearch Form -->
                    <div class="form-inline">
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        @include('layouts.menu-admin')
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">

                @yield('content')

            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer text-sm">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> {{ $pengaturan['versi'] }}
                </div>
                <strong>&copy; 2024 <a href="https://adminlte.io">{{ $nama_sub_aplikasi }}</a>.</strong>
                {{ $nama_departemen }}.
            </footer>
        </div>
        <!-- ./wrapper -->

        <!-- jQuery -->
        <script src="{{ asset('adminlte3') }}/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('adminlte3') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="{{ asset('adminlte3') }}/dist/js/adminlte.min.js"></script>

        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('adminlte3') }}/dist/js/demo.js"></script>

        <!-- datatble js -->
        <script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>

        <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.all.min.js "></script>

        @stack('script')

        <script type="text/javascript">
            $(function() {
                @if (isset($datatable) && $datatable)
                    var table = $("#{{ $datatable['id_table'] }}").DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: "{{ $datatable['url'] }}",
                        columns: [
                            @foreach ($datatable['columns'] as $row)
                                {
                                    data: "{{ $row['data'] }}",
                                    name: "{{ $row['name'] }}",
                                    orderable: {{ $row['orderable'] }},
                                    searchable: {{ $row['searchable'] }}
                                },
                            @endforeach
                        ]
                    });
                @elseif (isset($datatable) && empty($datatable))
                    var table = $('#id-datatable').DataTable();
                @else
                    var table = $('#id-datatable').DataTable();
                @endif
            });

            function formatRupiah(angka, prefix) {
                var number_string = angka.replace(/[^,\d]/g, '').toString(),
                    split = number_string.split(','),
                    sisa = split[0].length % 3,
                    rupiah = split[0].substr(0, sisa),
                    ribuan = split[0].substr(sisa).match(/\d{3}/gi);

                if (ribuan) {
                    separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }

                rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
                return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
            }

            function popupWindow(url, title, w, h) {
                var y = window.outerHeight / 2 + window.screenY - (h / 2)
                var x = window.outerWidth / 2 + window.screenX - (w / 2)
                return window.open(url, title,
                    'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=no, copyhistory=no, width=' +
                    w + ', height=' + h + ', top=' + y + ', left=' + x);
            }

            function handleFileUpload(form_name) {
                var form = document.getElementById(form_name);
                $("#loading-" + form_name).html('<span class="text-primary">Sedang proses upload...</span>')

                form.submit();
            }

            function copy(params) {
                var copyText = params;
                navigator.clipboard.writeText(copyText);
                $('.copytext').html('Copied!');
            }

            function upperCaseFirst(str) {
                return str.charAt(0).toUpperCase() + str.substring(1);
            }

            window.addEventListener('livewire:init', event => {
                Livewire.on('alert', (event) => {
                    Swal.fire({
                        icon: event.type,
                        title: upperCaseFirst(event.type),
                        text: event.message
                    });
                });
            });
        </script>

        <!-- Sweet Alert Plugin Js -->
        @include('sweetalert::alert')
    </body>

</html>
