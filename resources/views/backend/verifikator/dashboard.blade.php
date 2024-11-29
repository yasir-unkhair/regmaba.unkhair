@extends('layouts.backend')

@section('content')
    @php
        $pengaturan = pengaturan();
    @endphp
    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content pl-2 pr-2">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ $total }}</h3>

                                <p>TOTAL MABA {{ $tahun }}</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-primary">
                            <div class="inner">
                                <h3>{{ $jml_snbp }}</h3>

                                <p>MABA SNBP</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $jml_snbt }}</h3>

                                <p>MABA SNBT</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $jml_mandiri }}</h3>

                                <p>MABA MANDIRI</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="#" class="small-box-footer">More info <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <!-- ./col -->
                </div>
                <!-- /.row -->

                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center g-5">
                            <div class="col-lg-3">
                                <img src="{{ asset('images/dashboard.png') }}" class="img-fluid opacity-85" alt="images"
                                    loading="lazy">
                            </div>
                            <div class="col-lg-9 px-xl-5">
                                <h4 class="mb-2">
                                    Selamat datang <b>{{ Auth::user()->name }}</b> di {{ $pengaturan['nama-sub-aplikasi'] }}
                                    {{ $pengaturan['nama-departemen'] }}
                                </h4>
                                <p class="lead-dashboard mb-4">{{ $pengaturan['nama-sub-aplikasi'] }} merupakan sistem
                                    informasi
                                    yang dirancang khusus untuk mengelola data UKT Mahasiswa Baru. Sehingga Universitas
                                    Khairun dapat menyediakan layanan yang lebih efektif dan efisien.</p>
                                <div class="d-grid gap-3 d-md-flex justify-content-md-start">
                                    <livewire:Auth.Logout tampilan="logout2">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
