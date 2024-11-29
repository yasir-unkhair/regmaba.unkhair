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
    <title>{{ $nama_sub_aplikasi }} - {{$nama_departemen}}</title>
    <meta name="description" content="{{$nama_sub_aplikasi}} - {{$nama_departemen}}" />
    <meta name="keywords" content="">
    <meta name="author" content="{{$author}}" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon icon -->
    <link rel="icon" href="{{ asset('images/'.$logo) }}" type="image/x-icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminlte3') }}/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminlte3') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminlte3') }}/dist/css/adminlte.min.css">
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h2"><b>{{ $nama_aplikasi }}</b></a>
            </div>
            <div class="card-body">
                @yield('content')
            </div>
            
            <div class="card-footer">
                <strong>&copy; 2024 <a href="#">{{ $author }}</a>.</strong> {{ $nama_departemen }}.
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte3') }}/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminlte3') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminlte3') }}/dist/js/adminlte.min.js"></script>
</body>

</html>