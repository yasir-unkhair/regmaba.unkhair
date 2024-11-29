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
                        <h4 class="sub-title">Silahkan lengkapi kolom berikut: </h4>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Biaya Studi Oleh <sup
                                    class="text-danger">*</sup></label>
                            <div class="col-sm-10">
                                <select wire:model="biaya_studi" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach (master_referensi('Biaya Studi') as $ref)
                                        <option value="{{ $ref->id }}"
                                            {{ $biaya_studi == $ref->id ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('biaya_studi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h6 class="sub-title text-danger" style="font-size:12px;">Isian Dibawah ini diisi bila yang
                            Biaya Studi Biaya Sendiri</h6>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Pekerjaan Anda</label>
                            <div class="col-sm-4">
                                <select wire:model="pekerjaan_sendiri" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach (master_referensi('Pekerjaan') as $ref)
                                        <option value="{{ $ref->id }}"
                                            {{ $pekerjaan_sendiri == $ref->id ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('pekerjaan_sendiri')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <input type="text" wire:model="detail_pekerjaan_sendiri" class="form-control"
                                    placeholder="Sebutkan pekerjaan anda">
                                @error('detail_pekerjaan_sendiri')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Pangkat, Golongan, Jabatan Pekerjaan
                                Anda</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="pangkat_sendiri" class="form-control"
                                    placeholder="Pangkat, Golongan, Jabatan">
                                @error('pangkat_sendiri')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Luas Lahan Yang Anda Miliki</label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Luas Lahan') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="lahan_sendiri"
                                            value="{{ $ref->id }}"
                                            {{ $lahan_sendiri == $ref->id ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('lahan_sendiri')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Aset Lain Yang Anda Miliki</label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Aset') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" wire:model="aset_sendiri" class="form-check-input"
                                            value="{{ $ref->id }}"
                                            @if (in_array($ref->id, $aset_sendiri)) checked @endif
                                            id="check{{ $ref->id }}">
                                        <label class="form-check-label"
                                            for="check{{ $ref->id }}">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                <input type="text" wire:model="aset_lainnya" class="form-control"
                                    placeholder="Sebutkan aset anda lainnya">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Penghasilan Anda</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="penghasilan_sendiri" id="penghasilan_sendiri"
                                    class="form-control" placeholder="">
                                @error('penghasilan_sendiri')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <br>
                        <h6 class="sub-title text-danger" style="font-size:12px;">Isian Dibawah ini diisi bila yang
                            Biaya Studi Ditanggung oleh Wali</h6>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Wali Anda</label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Wali') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="wali"
                                            value="{{ $ref->id }}" {{ $wali == $ref->id ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('wali')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Pekerjaan Wali</label>
                            <div class="col-sm-10">
                                <select wire:model="pekerjaan_wali" class="form-control">
                                    <option value="">-- Pilih --</option>
                                    @foreach (master_referensi('Pekerjaan') as $ref)
                                        <option value="{{ $ref->id }}"
                                            {{ $pekerjaan_wali == $ref->id ? 'selected' : '' }}>
                                            {{ $ref->referensi }}</option>
                                    @endforeach
                                </select>
                                @error('pekerjaan_wali')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Pangkat, Golongan, Jabatan Pekerjaan
                                Wali</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="pangkat_wali" class="form-control"
                                    placeholder="Pangkat, Golongan, Jabatan">
                                @error('pangkat_wali')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Luas Lahan Yang Dimiliki
                                Wali</label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Luas Lahan') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" wire:model="lahan_wali"
                                            value="{{ $ref->id }}"
                                            {{ $lahan_wali == $ref->id ? 'checked' : '' }}>
                                        <label class="form-check-label">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                @error('lahan_wali')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Aset Lain Yang Dimiliki Wali</label>
                            <div class="col-sm-10">
                                @foreach (master_referensi('Aset') as $ref)
                                    <div class="form-check form-check-inline">
                                        <input type="checkbox" wire:model="aset_wali" class="form-check-input"
                                            value="{{ $ref->id }}"
                                            @if (in_array($ref->id, $aset_wali)) checked @endif
                                            id="check{{ $ref->id }}">
                                        <label class="form-check-label"
                                            for="check{{ $ref->id }}">{{ $ref->referensi }}</label>
                                    </div>
                                @endforeach
                                <input type="text" wire:model="aset_wali_lainnya" class="form-control"
                                    placeholder="Sebutkan aset wali lainnya">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="username" class="col-sm-2 col-form-label">Penghasilan Wali</label>
                            <div class="col-sm-10">
                                <input type="text" wire:model="penghasilan_wali" id="penghasilan_wali"
                                    class="form-control" placeholder="">
                                @error('penghasilan_wali')
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
                <!-- /.card -->
            </form>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @push('script')
        <script>
            var penghasilan_sendiri = document.getElementById('penghasilan_sendiri');
            penghasilan_sendiri.addEventListener('keyup', function(e) {
                penghasilan_sendiri.value = formatRupiah(this.value, 'Rp. ');
            });

            var penghasilan_wali = document.getElementById('penghasilan_wali');
            penghasilan_wali.addEventListener('keyup', function(e) {
                penghasilan_wali.value = formatRupiah(this.value, 'Rp. ');
            });
        </script>
    @endpush
</div>
