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
                        <h1 class="m-0">{{ $judul }}</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">{{ $judul }}</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content pl-2 pr-2">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-body">

                        <div class="table-responsive">
                            <iframe
                                src="{{ route('cetak.formulirukt', encode_arr(['peserta_id' => session('peserta_id'), 'output' => 'I'])) }}"
                                width="100%" height="700">
                            </iframe>

                            <br>
                            <center>
                                <div class="alert warna-danger">
                                    <a href="{{ route('cetak.formulirukt', encode_arr(['peserta_id' => session('peserta_id'), 'output' => 'D'])) }}"
                                        class="btn btn-danger">
                                        <i class="fa fa-print"></i>
                                        Print Formulir
                                    </a>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
@endsection
