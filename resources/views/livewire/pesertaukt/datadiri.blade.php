<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $judul }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $subjudul }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content pl-2 pr-2">
        <div class="container-fluid">
            {!! flashAllert() !!}
            <!-- Default box -->
            <form wire:submit="save" class="form-horizontal">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $subjudul }}</h3>

                        <div class="card-tools"></div>
                    </div>

                    <div class="card-body">
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">NIK <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="nik" class="form-control" placeholder="NIK">
                                @error('nik')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Nama Peserta (KTP) <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="nama_peserta" class="form-control"
                                    placeholder="Nama Peserta Sesuai KTP">
                                @error('nama_peserta')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Jenis Kelamin <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="jk" value="L"
                                        {{ $jk == 'L' ? 'checked' : '' }}>
                                    <label class="form-check-label">Laki-Laki</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" wire:model="jk" value="P"
                                        {{ $jk == 'P' ? 'checked' : '' }}>
                                    <label class="form-check-label">Perempuan</label>
                                </div>
                                @error('jk')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Golongan Darah <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select wire:model="golongan_darah" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach (master_referensi('Golongan Darah') as $ref)
                                        <option value="{{ $ref->id }}"
                                            {{ $golongan_darah == $ref->referensi ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('golongan_darah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Agama <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select wire:model="agama" class="form-control">
                                    <option value="">-- Pilih Agama --</option>
                                    @foreach (master_referensi('Agama') as $ref)
                                        <option value="{{ $ref->referensi }}"
                                            {{ $agama == $ref->referensi ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('agama')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Tempat dan Tanggal Lahir <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-6">
                                <input type="text" wire:model="tpl_lahir" class="form-control"
                                    placeholder="Tempat Lahir">
                                @error('tpl_lahir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col-sm-4">
                                <div class="datepicker date input-group">
                                    <input type="text" placeholder="Choose Date" class="form-control"
                                        wire:model="tgl_lahir">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                    </div>
                                </div>
                                @error('tgl_lahir')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Alamat Asal <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="alamat_asal" class="form-control"
                                    placeholder="Alamat Asal">
                                @error('alamat_asal')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Alamat Di Ternate <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="alamat_tte" class="form-control"
                                    placeholder="Alamat Ternate">
                                @error('alamat_tte')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">No Handphone Mahasiswa <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="hp" class="form-control"
                                    placeholder="HP Mahasiswa">
                                @error('hp')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                                <small class="text-muted">Nomor HP yang saya isikan adalah nomor HP yang dapat
                                    dihubungi terutama menggunakan WA dan saya setuju jika nomor saya dibagikan kepada
                                    pihak lain untuk keperluan penerimaan mahasiswa baru.</small>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">No Handphone Orangtua <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="hportu" class="form-control"
                                    placeholder="HP Orangtua">
                                @error('hportu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Tahun Ijazah/Lulus SLTA <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select wire:model="thn_lulus" class="form-control">
                                    <option value="">-- Pilih Tahun --</option>
                                    @for ($thn = date('Y'); $thn >= 2018; $thn--)
                                        <option value="{{ $thn }}"
                                            {{ $thn_lulus == $thn ? 'selected' : '' }}>
                                            {{ $thn }}</option>
                                    @endfor
                                </select>
                                @error('thn_lulus')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">NISN <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="nisn" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">NPSN <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="npsn" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Sekolah Asal <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="sekolah_asal" class="form-control">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Program Studi Yang Lulus <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="prodi" class="form-control" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button type="submit" class="btn btn-sm btn-primary" wire:loading.attr="disabled"
                            wire:target="save">
                            <span wire:loading.remove wire.target="save">
                                <i class="fa fa-save"></i> Simpan
                            </span>
                            <span wire:loading wire.target="save">Please wait...</span>
                        </button>
                    </div>
                </div>
                <!-- /.card -->
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @push('style')
        <!-- datepicker styles -->
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker3.min.css">
    @endpush

    @push('script')
        <!-- Datepicker -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
        <script>
            $(function() {
                $('.datepicker').datepicker({
                    language: "es",
                    autoclose: true,
                    format: "dd-mm-yyyy"
                });
            });
        </script>
    @endpush
</div>
