@extends('layouts.backend')

@section('content')
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
                            <table class="table border border-black" style="font-size:14px;">
                                <tr>
                                    <td class="text-right bg-light" width="15%">Nomor Peserta :</td>
                                    <td width="35%">
                                        {{ $peserta->nomor_peserta }}
                                    </td>

                                    <td class="text-right bg-light" width="15%">Jalur Pendaftaran :</td>
                                    <td width="35%">
                                        {{ $peserta->jalur }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right bg-light">Nama Lengkap :</td>
                                    <td>{{ $peserta->nama_peserta }}</td>

                                    <td class="text-right bg-light">Tahun :</td>
                                    <td>{{ $peserta->setup?->tahun }}</td>
                                </tr>
                                <tr>
                                    <td class="text-right bg-light">Fakultas :</td>
                                    <td>{{ $peserta->fakultas?->nama_fakultas }}</td>
                                    <td class="text-right bg-light">Kategori UKT :</td>
                                    <td>
                                        @if ($peserta->status == '5' && $peserta->verifikasiberkas?->vonis_ukt == 'kip-k')
                                            <span class="text-success"><b>KIP-K</b></span>
                                        @elseif(
                                            $peserta->status == '5' &&
                                                in_array($peserta->verifikasiberkas?->vonis_ukt, ['k1', 'k2', 'k3', 'k4', 'k5', 'k6', 'k7', 'k8']))
                                            <b class="text-success">UKT
                                                {{ strtoupper($peserta->verifikasiberkas?->vonis_ukt) }}</b>
                                        @else
                                            <span class="text-danger">Status UKT Sedang Dalam Verifikasi!</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td class="text-right bg-light">Program Studi :</td>
                                    <td>{{ $peserta->prodi?->jenjang_prodi . ' - ' . $peserta->prodi?->nama_prodi }}</td>
                                    <td class="text-right bg-light">Besar Tagihan UKT :</td>
                                    <td>Rp. {{ number_format($peserta->verifikasiberkas?->nominal_ukt) }}</td>
                                </tr>

                                {{-- tampil nominal IPI bagi jalur mandiri --}}
                                {{-- @dump($peserta->jalurmasuk?->referensi) --}}
                                @if ($peserta->jalur == 'MANDIRI')
                                    <tr>
                                        <td class="text-right bg-light" colspan="3">Selain Tagihan UKT, Anda Juga
                                            Dikenakan
                                            Biaya IPI :</td>
                                        <td>Rp. {{ number_format($peserta->verifikasiberkas?->biaya_ipi) }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>

                        @if ($peserta->status == '5' && $peserta->verifikasiberkas?->vonis_ukt == 'kip-k')
                            <div class="alert warna-success h3 text-center">Selanjutnya Dapat Menunggu Informasi Berikutnya
                                Melalui
                                Website
                                Unkhair <a href="https://unkhair.ac.id" class="text-success">https://unkhair.ac.id</a>, Atau
                                Dapat Cek Secara
                                Berkala Akun Facebook/Instagram
                                Kehumasan
                                Unkhair Untuk Informasi Selanjutnya.</div>
                            <br>
                        @elseif ($peserta->status == '5' && $peserta->verifikasiberkas?->vonis_ukt != 'kip-k')
                            @if (!$peserta->verifikasiberkas?->bayar_ukt)
                                <div class="alert warna-success text-center h3">
                                    <span>
                                        Silahkan Download Billing Dan Lakukan Pembayaran di Bank <br>
                                        Pembayaran UKT Dimulai Tanggal
                                        <b class="text-danger">
                                            {{ tgl_indo(pecah_jadwal($tgl_pembayaran_ukt, 0), false) }} s/d
                                            {{ tgl_indo(pecah_jadwal($tgl_pembayaran_ukt, 1), false) }}
                                        </b>
                                    </span>
                                    <br>
                                    <button class="btn btn-primary mt-2" type="button"
                                        onclick="location.href='{{ route('peserta.pembayaran') }}';">
                                        <i class="fa fa-money"></i> Pembayaran UKT
                                    </button>
                                </div>
                            @else
                                <div class="alert warna-success text-center h3">
                                    <span class="text-primary">Nomor Pokok Mahasiswa (NPM):</span>
                                    {!! trim($peserta->npm) ? '<div class="mt-2"><b>' . $peserta->npm . '</b></div>' : '' !!}

                                    {!! $notif_generatenpm > 0 ? '<br><span style="font-size:13px;" class="text-muted">Sedang memuat...</span>' : '' !!}
                                </div>
                            @endif
                        @endif
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
    </div>
@endsection
