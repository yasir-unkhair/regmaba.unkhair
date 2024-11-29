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
                    <div class="card-header">
                        <h3 class="card-title">{{ $judul }}</h3>

                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.maba.carimaba') }}" method="post">
                            @csrf
                            <div class="form-group row">
                                <label for="level" class="col-sm-2 col-form-label">Ketik No. Peserta</label>
                                <div class="col-sm-5">
                                    <div class="input-group">
                                        <input type="text" name="nomor_peserta"
                                            value="{{ old('nomor_peserta', $nomor_peserta) }}"
                                            class="form-control @error('nomor_peserta') is-invalid @enderror"
                                            placeholder="No. Peserta">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i> Cari Maba
                                            </button>
                                        </div>
                                    </div>

                                    @error('nomor_peserta')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </form>

                        @if ($peserta)
                            <br>
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
                                        <td>{{ $peserta->prodi?->jenjang_prodi . ' - ' . $peserta->prodi?->nama_prodi }}
                                        </td>
                                        <td class="text-right bg-light">Besar Tagihan UKT :</td>
                                        <td>Rp. {{ number_format($peserta->verifikasiberkas?->nominal_ukt) }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="alert warna-success text-center h3">
                                <span class="text-primary">Nomor Pokok Mahasiswa (NPM):</span>
                                {!! trim($peserta->npm) ? '<div class="mt-2"><b>' . $peserta->npm . '</b></div>' : '' !!}

                                {!! $notif_generatenpm > 0 ? '<br><span style="font-size:13px;" class="text-muted">Sedang memuat...</span>' : '' !!}

                                @if (!$peserta->npm && !$notif_generatenpm)
                                    <br>
                                    <button type="button"
                                        onclick="document.location='{{ route('admin.maba.actgeneratenpm', encode_arr(['peserta_id' => $peserta->id])) }}'"
                                        class="btn btn-danger mt-2" title="Generate NPM">
                                        <i class="fa fa-cogs"></i> Generate NPM
                                    </button>
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
