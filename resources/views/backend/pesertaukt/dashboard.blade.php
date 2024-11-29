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
                <div class="card">
                    <div class="card-body">
                        <h3>Alur Pemberkasan</h3>
                        <div class="table-responsive">
                            <div class="wizard">
                                <a href="{{ route('peserta.datadiri') }}"
                                    class="{{ $peserta->update_data_diri ? 'current text-light' : '' }}">
                                    <span class="badge badge-warning">1</span> Formulir UKT
                                </a>
                                <a href=""
                                    class="{{ in_array($peserta->status, ['2', '3', '4', '5']) ? 'current text-light' : '' }}">
                                    <span class="badge badge-warning">2</span> Upload Berkas Dukung
                                </a>
                                <a href=""
                                    class="{{ in_array($peserta->status, ['3', '4', '5']) ? 'current text-light' : '' }}">
                                    <span class="badge badge-warning">3</span> Finalisasi
                                </a>
                                <a class="{{ in_array($peserta->status, ['4', '5']) ? 'current text-light' : '' }}">
                                    <span class="badge badge-warning">4</span> Proses Verifikasi
                                </a>
                                <a class="{{ $peserta->status == 5 ? 'current text-light' : '' }}">
                                    <span class="badge badge-warning">5</span> Penetapan UKT
                                </a>
                            </div>
                        </div>
                        <br>

                        <p style="font-size:13px;">
                            <b>Silahkan lengkapi data-data yang diperlukan:</b><br>
                            1. &nbsp;Formulir UKT <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.1. &nbsp;Melengkapi
                            <a href="{{ route('peserta.datadiri') }}" class="text-primary">Data Diri</a>
                            {!! $peserta->update_data_diri
                                ? '<span class="text-success"><i class="fa fa-check"></i></span>'
                                : '<span class="text-muted"><i class="fa fa-spinner"></i></span>' !!}
                            <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.2. &nbsp;Melengkapi
                            <a href="{{ route('peserta.kondisikeluarga') }}" class="text-primary">Kondisi Keluarga</a>
                            {!! $peserta->update_kondisi_keluarga
                                ? '<span class="text-success"><i class="fa fa-check"></i></span>'
                                : '<span class="text-muted"><i class="fa fa-spinner"></i></span>' !!}
                            <br>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;1.3. &nbsp;Melengkapi
                            <a href="{{ route('peserta.pembiayaanstudi') }}" class="text-primary">Pembiayaan Studi</a>
                            {!! $peserta->update_pembiayaan_studi
                                ? '<span class="text-success"><i class="fa fa-check"></i></span>'
                                : '<span class="text-muted"><i class="fa fa-spinner"></i></span>' !!}
                            <br>
                            2. &nbsp;<a href="" class="text-primary">Upload Berkas Dukung
                                {!! in_array($peserta->status, [2, 3, 4, 5])
                                    ? '<span class="text-success"><i class="fa fa-check"></i></span>'
                                    : '<span class="text-muted"><i class="fa fa-spinner"></i></span>' !!}</a>
                            <br>
                            3. &nbsp;<a href="" class="text-primary">Finalisasi
                                {!! in_array($peserta->status, [3, 4, 5])
                                    ? '<span class="text-success"><i class="fa fa-check"></i></span>'
                                    : '<span class="text-muted"><i class="fa fa-spinner"></i></span>' !!}</a>
                            <br>
                            4. &nbsp;<a href="#" class="text-primary">Verifikasi Berkas
                                {!! in_array($peserta->status, [4, 5])
                                    ? '<span class="text-success"><i class="fa fa-check"></i></span>'
                                    : '<span class="text-muted"><i class="fa fa-spinner"></i></span>' !!}</a>
                            <br>
                            5. &nbsp;<a href="#" class="text-primary">Penetapan UKT
                                {!! in_array($peserta->status, [5])
                                    ? '<span class="text-success"><i class="fa fa-check"></i></span>'
                                    : '<span class="text-muted"><i class="fa fa-spinner"></i></span>' !!}</a>
                            <br>
                        </p>

                        @if ($peserta->status == 2)
                            <div class="callout callout-warning warna-warning">
                                <button type="button" class="close" data-dismiss="alert"
                                    aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-exclamation-triangle"></i> Informasi!</h5>
                                Segera melakukan finalisasi agar data pengajuan anda segera di proses verifikasi oleh
                                panitia.
                            </div>
                        @endif

                        <hr>
                        <p style="font-size:13px;">
                            Customer Service <b>{{ $pengaturan['nama-sub-aplikasi'] }} -
                                {{ $pengaturan['nama-departemen'] }}</b> <br>
                            Hotline WA: <span class="text-primary">0813-4578-xxxx</span> <br>
                            Email: <span class="text-primary">-</span> <br>
                            Website: <a href="" class="text-primary">www.unkhair.ac.id/</a>
                        </p>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('style')
        <style>
            .wizard a {
                padding: 10px 12px 10px;
                margin-right: 5px;
                background: #efefef;
                position: relative;
                display: inline-block;
            }

            .wizard a:before {
                width: 0;
                height: 0;
                border-top: 20px inset transparent;
                border-bottom: 20px inset transparent;
                border-left: 20px solid #fff;
                position: absolute;
                content: "";
                top: 0;
                left: 0;
            }

            .wizard a:after {
                width: 0;
                height: 0;
                border-top: 20px inset transparent;
                border-bottom: 20px inset transparent;
                border-left: 20px solid #efefef;
                position: absolute;
                content: "";
                top: 0;
                right: -20px;
                z-index: 2;
            }

            .wizard a:first-child:before,
            .wizard a:last-child:after {
                border: none;
            }

            .wizard a:first-child {
                -webkit-border-radius: 4px 0 0 4px;
                -moz-border-radius: 4px 0 0 4px;
                border-radius: 4px 0 0 4px;
            }

            .wizard a:last-child {
                -webkit-border-radius: 0 4px 4px 0;
                -moz-border-radius: 0 4px 4px 0;
                border-radius: 0 4px 4px 0;
            }

            .wizard .badge {
                margin: 0 5px 0 18px;
                position: relative;
                top: -1px;
            }

            .wizard a:first-child .badge {
                margin-left: 0;
            }

            .wizard .current {
                background: #007ACC;
                color: #fff;
            }

            .wizard .current:after {
                border-left-color: #007ACC;
            }
        </style>
    @endpush
@endsection
