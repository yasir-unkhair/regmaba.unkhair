@extends('layouts.backend')

@section('content')
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
                <div class="row">
                    <div class="col-md-3">

                        <!-- Profile Image -->
                        <div class="card card-primary card-outline">
                            <div class="card-body box-profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle"
                                        src="{{ asset('images/avatar5.png') }}" alt="User profile picture">
                                </div>

                                <h3 class="profile-username text-center">{{ $tab1->nama_peserta }}</h3>

                                <p class="text-muted text-center">{{ $tab1->nomor_peserta }}</p>
                                <hr>
                                <strong>Jalur Peserta:</strong>
                                <p class="text-muted">
                                    {{ $tab1->jalur }}
                                </p>

                                <hr>

                                <strong>Nomor KIP:</strong>
                                <p class="text-muted">
                                    {{ $tab1->kip ?? '-' }}
                                </p>

                                <hr>

                                <strong>Pebanding Pendapatan Ayah:</strong>
                                <p class="text-muted">
                                    {{ $tab2->pebanding_penghasilan_ayah ? $tab2->pebanding_penghasilan_ayah : 'Rp. 0' }}
                                </p>

                                <hr>

                                <strong>Pebanding Pendapatan Ibu:</strong>
                                <p class="text-muted">
                                    {{ $tab2->pebanding_penghasilan_ibu ? $tab2->pebanding_penghasilan_ibu : 'Rp. 0' }}
                                </p>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->

                        <!-- About Me Box -->
                        <livewire:Verifikator.VerifikasiPesertaukt peserta_id="{{ $tab1->id }}">
                            <!-- /.card -->
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" href="#data-diri" data-toggle="tab">DATA
                                            DIRI</a></li>
                                    <li class="nav-item"><a class="nav-link" href="#kondisi-keluarga"
                                            data-toggle="tab">KONDISI
                                            KELUARGA</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#pembiayaan-studi"
                                            data-toggle="tab">PEMBIAYAAN STUDI</a>
                                    </li>
                                    <li class="nav-item"><a class="nav-link" href="#berkas" data-toggle="tab">BUKTI BERKAS
                                            DUKUNG</a>
                                    </li>
                                </ul>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="data-diri">
                                        <div class="table-responsive mb-0">
                                            <table class="table border border-black mb-0" style="font-size:13px;">
                                                <tr>
                                                    <td class="text-right" width="30%">NIK :</td>
                                                    <td width="70%">{{ $tab1->nik }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Nama Peserta :</td>
                                                    <td>{{ $tab1->nama_peserta }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Jenis Kelamin :</td>
                                                    <td>{{ $tab1->jk == 'L' ? 'Laki-Laki' : 'Perempuan' }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Golongan Darah :</td>
                                                    <td>{{ get_referensi($tab1->golongan_darah) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Agama :</td>
                                                    <td>{{ $tab1->agama }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Tempat dan Tanggal Lahir :</td>
                                                    <td>{{ $tab1->tpl_lahir . ', ' . $tab1->tgl_lahir }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Alamat Asal :</td>
                                                    <td>{{ $tab1->alamat_asal }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Alamat Di Ternate :</td>
                                                    <td>{{ $tab1->alamat_tte }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">No Handphone Mahasiswa :</td>
                                                    <td>{{ $tab1->hp }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">No Handphone Orangtua :</td>
                                                    <td>{{ $tab1->hportu }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Tahun Ijazah/Lulus SLTA :</td>
                                                    <td>{{ $tab1->thn_lulus }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">NISN :</td>
                                                    <td>{{ $tab1->nisn }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">NPSN :</td>
                                                    <td>{{ $tab1->npsn }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Sekolah Asal :</td>
                                                    <td>{{ $tab1->sekolah_asal }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Program Studi :</td>
                                                    <td>{{ $tab1->prodi?->jenjang_prodi . ' - ' . $tab1->prodi?->nama_prodi }}
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="kondisi-keluarga">
                                        <div class="table-responsive mb-0">
                                            <table class="table border border-black mb-0" style="font-size:13px;">
                                                <tr>
                                                    <td class="text-right" width="30%">Nama Ayah :</td>
                                                    <td width="70%">{{ $tab2->nama_ayah }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Nama Ibu :</td>
                                                    <td>{{ $tab2->nama_ibu }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Nama Wali :</td>
                                                    <td>{{ $tab2->nama_wali }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Keberadaan Orangtua :</td>
                                                    <td>{{ get_referensi($tab2->keberadaan_ortu) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Jumlah Kakak :</td>
                                                    <td>{{ $tab2->jml_kakak }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Jumlah Adik :</td>
                                                    <td>{{ $tab2->jml_adik }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Jumlah Tanggungan Yang Sedang Kuliah :</td>
                                                    <td>{{ $tab2->jml_kuliah }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Jumlah Tanggungan Yang Sedang Sekolah :</td>
                                                    <td>{{ $tab2->jml_sekolah }}</td>
                                                </tr>
                                                <tr class="border border-danger">
                                                    <td colspan="2" class="p-0"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Pekerjaan Ayah :</td>
                                                    <td>{{ get_referensi($tab2->pekerjaan_ayah) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Pangkat, Golongan, Jabatan Pekerjaan Ayah :</td>
                                                    <td>{{ $tab2->pangkat_ayah }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Penghasilan Ayah :</td>
                                                    <td>Rp. {{ number_format($tab2->penghasilan_ayah) }}</td>
                                                </tr>
                                                <tr class="border border-danger">
                                                    <td colspan="2" class="p-0"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Pekerjaan Ibu :</td>
                                                    <td>{{ get_referensi($tab2->pekerjaan_ibu) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Pangkat, Golongan, Jabatan Pekerjaan Ibu :</td>
                                                    <td>{{ $tab2->pangkat_ibu }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Penghasilan Ibu :</td>
                                                    <td>Rp. {{ number_format($tab2->penghasilan_ibu) }}</td>
                                                </tr>
                                                <tr class="border border-danger">
                                                    <td colspan="2" class="p-0"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Luas Lahan Yang DImiliki Orangtua :</td>
                                                    <td>{{ get_referensi($tab2->luas_lahan) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Aset Lain Yang DImiliki Orangtua :</td>
                                                    <td>{{ tampil_aset($tab2->aset_ortu) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Kepemilikan Rumah :</td>
                                                    <td>{{ get_referensi($tab2->kepemilikan_rumah) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Kondisi Rumah :</td>
                                                    <td>{{ get_referensi($tab2->kondisi_rumah) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Lokasi Tempat Tinggal :</td>
                                                    <td>{{ get_referensi($tab2->lokasi_rumah) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Daya Listrik :</td>
                                                    <td>{{ get_referensi($tab2->daya_listrik) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Bantuan Siswa Miskin (SMA/SMK/MA) :</td>
                                                    <td>{{ get_referensi($tab2->bantuan_siswa_miskin) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="pembiayaan-studi">
                                        <div class="table-responsive mb-0">
                                            <table class="table border border-black mb-0" style="font-size:13px;">
                                                <tr>
                                                    <td class="text-right" width="30%">Biaya Studi Oleh :</td>
                                                    <td width="70%">{{ get_referensi($tab3->biaya_studi) }}</td>
                                                </tr>
                                                <tr class="border border-danger">
                                                    <td colspan="2" class="p-0"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Pekerjaan Anda :</td>
                                                    <td>{{ get_referensi($tab3->pekerjaan_sendiri) . ($tab3->detail_pekerjaan_sendiri ? ', ' . $tab3->detail_pekerjaan_sendiri : '') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Pangkat, Golongan, Jabatan Pekerjaan Anda :</td>
                                                    <td>{{ $tab3->pangkat_sendiri }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Luas Lahan Yang Anda Miliki :</td>
                                                    <td>{{ get_referensi($tab3->lahan_sendiri) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Aset Lain Yang Anda Miliki :</td>
                                                    <td>{{ tampil_aset($tab3->aset_sendiri) . ($tab3->aset_lainnya ? ', ' . $tab2->aset_lainnya : '') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Penghasilan Anda :</td>
                                                    <td>Rp. {{ rupiah($tab3->penghasilan_sendiri) }}</td>
                                                </tr>
                                                <tr class="border border-danger">
                                                    <td colspan="2" class="p-0"></td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Wali Anda :</td>
                                                    <td>{{ get_referensi($tab3->wali) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Pekerjaan Wali :</td>
                                                    <td>{{ get_referensi($tab3->pekerjaan_wali) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Pangkat, Golongan, Jabatan Pekerjaan Wali :</td>
                                                    <td>{{ $tab3->pangkat_wali }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Luas Lahan Yang Dimiliki Wali :</td>
                                                    <td>{{ get_referensi($tab3->lahan_wali) }}</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Aset Lain Yang Dimiliki Wali :</td>
                                                    <td>{{ tampil_aset($tab3->aset_wali) . ($tab3->aset_wali_lainnya ? ', ' . $tab3->aset_wali_lainnya : '') }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">Penghasilan Wali :</td>
                                                    <td>Rp. {{ number_format($tab3->penghasilan_wali) }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="berkas">
                                        <div class="table-responsive p-0 mb-2">
                                            <table class="table table-condensed table-bordered" style="width: 100%">
                                                <thead class="bg-light">
                                                    <tr>
                                                        <th>Berkas Bukti Dukung</th>
                                                        <th>Status</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($dokumen as $row)
                                                        @if (!is_array($row))
                                                            <tr style="background-color:#d1ecf1">
                                                                <th colspan="3">{{ $row }}</th>
                                                            </tr>
                                                        @else
                                                            <tr>
                                                                <td>
                                                                    {!! $row['detail'] !!}
                                                                    <sup>{!! $row['wajib'] == 'Y' ? '<span class="text-danger">*Wajib</span>' : '' !!}</sup>
                                                                    <br>
                                                                    <small class="text-muted">
                                                                        (Format file: <b>*pdf, *jpg, *jpeg</b> dan maks
                                                                        <b>1MB</b>)
                                                                    </small>
                                                                    <input type="hidden" name="detail"
                                                                        id="detail{{ $loop->index }}"
                                                                        value="{{ $row['detail'] }}">
                                                                </td>
                                                                <td>
                                                                    {!! $row['upload']
                                                                        ? '<span class="text-success">Sudah Diupload</span>'
                                                                        : '<span class="text-danger">Belum Diupload!</span>' !!}
                                                                </td>
                                                                <td>
                                                                    @if ($row['upload'])
                                                                        <button
                                                                            onclick="popupWindow('{{ route('frontend.lihatdokumen', encode_arr($row['upload'])) }}', 'View Bukti Dukung', 900, 600)"
                                                                            class="btn btn-sm btn-success">
                                                                            <i class="fa fa-eye"></i> View
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-content -->
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
