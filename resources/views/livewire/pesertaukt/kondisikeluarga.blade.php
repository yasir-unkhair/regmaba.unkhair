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
            <form wire:submit="save" class="form-horizontal">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $subjudul }}</h3>

                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Nama Ayah <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="nama_ayah" class="form-control"
                                    placeholder="Nama Ayah">
                                @error('nama_ayah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Nama Ibu <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="nama_ibu" class="form-control" placeholder="Nama Ibu">
                                @error('nama_ibu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Nama Wali</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="nama_wali" class="form-control"
                                    placeholder="Nama Wali">
                                @error('nama_wali')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Keberadaan Orangtua <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select wire:model="keberadaan_ortu" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach (master_referensi('Keberadaan Orangtua') as $ref)
                                        <option value="{{ $ref->id }}"
                                            {{ $keberadaan_ortu == $ref->referensi ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('keberadaan_ortu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Jumlah Kakak <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="jml_kakak" class="form-control" placeholder="0">
                                @error('jml_kakak')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Jumlah Adik <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="jml_adik" class="form-control" placeholder="0">
                                @error('jml_adik')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Jumlah Tanggungan Yang Sedang Kuliah
                                <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="jml_kuliah" class="form-control" placeholder="0">
                                @error('jml_kuliah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Jumlah Tanggungan Yang Sedang Sekolah
                                <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="jml_sekolah" class="form-control" placeholder="0">
                                @error('jml_sekolah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Pekerjaan Ayah <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select wire:model="pekerjaan_ayah" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach (master_referensi('Pekerjaan') as $ref)
                                        <option value="{{ $ref->id }}"
                                            {{ $pekerjaan_ayah == $ref->referensi ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('pekerjaan_ayah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Pangkat, Golongan, Jabatan Pekerjaan
                                Ayah</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="pangkat_ayah" class="form-control"
                                    placeholder="Pangkat, Golongan, Jabatan">
                                @error('pangkat_ayah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Penghasilan Ayah <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="penghasilan_ayah" id="penghasilan_ayah"
                                    class="form-control" placeholder="">
                                @error('penghasilan_ayah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Pekerjaan Ibu <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select wire:model="pekerjaan_ibu" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach (master_referensi('Pekerjaan') as $ref)
                                        <option value="{{ $ref->id }}"
                                            {{ $pekerjaan_ibu == $ref->id ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('pekerjaan_ibu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Pangkat, Golongan, Jabatan Pekerjaan
                                Ibu</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="pangkat_ibu" class="form-control"
                                    placeholder="Pangkat, Golongan, Jabatan">
                                @error('pangkat_ibu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Penghasilan Ibu <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="penghasilan_ibu" id="penghasilan_ibu"
                                    class="form-control" placeholder="">
                                @error('penghasilan_ibu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Luas Lahan Yang Dimiliki Orangtua
                                <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select wire:model="luas_lahan" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach (master_referensi('Luas Lahan') as $ref)
                                        <option value="{{ $ref->id }}"
                                            {{ $luas_lahan == $ref->id ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('luas_lahan')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Aset Lain Yang Dimiliki Orangtua
                                <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Aset') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" wire:model="aset_ortu" class="form-check-input"
                                            value="{{ $ref->id }}"
                                            @if (in_array($ref->id, $aset_ortu)) checked @endif
                                            id="check{{ $ref->id }}">
                                        <label class="form-check-label"
                                            for="check{{ $ref->id }}">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('aset_ortu')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Kepemilikan Rumah <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Kepemilikan Rumah') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="kepemilikan_rumah"
                                            value="{{ $ref->id }}"
                                            {{ $kepemilikan_rumah == $ref->id ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('kepemilikan_rumah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Kondisi Rumah <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Kondisi Rumah') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="kondisi_rumah"
                                            value="{{ $ref->id }}"
                                            {{ $kondisi_rumah == $ref->id ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('kondisi_rumah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Lokasi Tempat Tinggal <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Lokasi Tempat Tinggal') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="lokasi_rumah"
                                            value="{{ $ref->id }}"
                                            {{ $lokasi_rumah == $ref->id ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('lokasi_rumah')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Daya Listrik <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Daya Listrik') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="daya_listrik"
                                            value="{{ $ref->id }}"
                                            {{ $daya_listrik == $ref->id ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('daya_listrik')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Bantuan Siswa Miskin (SMA/SMK/MA)
                                <sup class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Bantuan Siswa Miskin') as $ref)
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio"
                                            wire:model="bantuan_siswa_miskin" value="{{ $ref->id }}"
                                            {{ $bantuan_siswa_miskin == $ref->id ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('bantuan_siswa_miskin')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
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
            </form>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @push('script')
        <script>
            var penghasilan_ayah = document.getElementById('penghasilan_ayah');
            penghasilan_ayah.addEventListener('keyup', function(e) {
                penghasilan_ayah.value = formatRupiah(this.value, 'Rp. ');
            });

            var penghasilan_ibu = document.getElementById('penghasilan_ibu');
            penghasilan_ibu.addEventListener('keyup', function(e) {
                penghasilan_ibu.value = formatRupiah(this.value, 'Rp. ');
            });
        </script>
    @endpush
</div>
