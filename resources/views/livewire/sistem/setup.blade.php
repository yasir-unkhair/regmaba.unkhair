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
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $judul }}</h3>

                    <div class="card-tools">
                        <div class="input-group">
                            <select class="form-control" onchange="tampilkan(this.value)">
                                <option value="">-- Pilih Tahun --</option>
                                @foreach ($listtahun as $row)
                                    <option value="{{ $row->tahun }}" {{ $row->tampil ? 'selected' : '' }}>
                                        {{ $row->tahun }}</option>
                                @endforeach
                            </select>
                            <span class="input-group-append">
                                <button type="button" class="btn btn-sm btn-primary"
                                    onclick="open_modal('ModalUpdateSetup')"><i class="fas fa-plus-circle"></i> Tambah
                                    Tahun</button>
                            </span>
                        </div>
                    </div>
                </div>
                <form wire:submit="updatesetup" class="form-horizontal">
                    <div class="card-body">
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Tahun</label>
                            <div class="col-sm-3">
                                <input type="text" class="form-control" wire:model="tahun" readonly>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="inputEmail3" class="col-sm-2 col-form-label">Aktif</label>
                            <div class="col-sm-3">
                                <select class="form-control {{ $aktif == 'Y' ? 'is-valid' : 'is-invalid' }}"
                                    wire:model="aktif">
                                    <option value="Y" {{ $aktif == 'Y' ? 'selected' : '' }}>Ya</option>
                                    <option value="N" {{ $aktif == 'N' ? 'selected' : '' }}>Tidak</option>
                                </select>
                            </div>
                        </div>
                        <fieldset class="border p-2 shadow-sm">
                            <legend class="float-none w-auto p-2 text-primary">Jalur SNBP</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Registrasi SNBP:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="registrasi_snbp" id="registrasi_snbp"
                                                class="form-control input-daterange">
                                        </div>
                                        @error('registrasi_snbp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @php
                                            $str_durasi = '';
                                            if (strlen($registrasi_snbp) > 3) {
                                                $jarak = range_tanggal($registrasi_snbp);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($registrasi_snbp, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pengisian Formulir SNBP:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="pengisian_snbp" id="pengisian_snbp"
                                                class="form-control input-daterange">
                                        </div>
                                        @error('pengisian_snbp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @php
                                            $str_durasi = '';
                                            if (strlen($pengisian_snbp) > 3) {
                                                $jarak = range_tanggal($pengisian_snbp);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($pengisian_snbp, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pembayaran SNBP:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="pembayaran_snbp" id="pembayaran_snbp"
                                                class="form-control input-daterange">
                                        </div>
                                        @error('pembayaran_snbp')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                        @php
                                            $str_durasi = '';
                                            if (strlen($pembayaran_snbp) > 3) {
                                                $jarak = range_tanggal($pembayaran_snbp);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($pembayaran_snbp, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="border p-2 mt-2 shadow-sm">
                            <legend class="float-none w-auto p-2 text-success">Jalur SNBT</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Registrasi SNBT:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="registrasi_snbt" id="registrasi_snbt"
                                                class="form-control input-daterange">
                                        </div>
                                        @php
                                            $str_durasi = '';
                                            if (strlen($registrasi_snbt) > 3) {
                                                $jarak = range_tanggal($registrasi_snbt);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($registrasi_snbt, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pengisian Formulir SNBP:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="pengisian_snbt" id="pengisian_snbt"
                                                class="form-control input-daterange">
                                        </div>
                                        @php
                                            $str_durasi = '';
                                            if (strlen($pengisian_snbt) > 3) {
                                                $jarak = range_tanggal($pengisian_snbt);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($pengisian_snbt, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pembayaran SNBT:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="pembayaran_snbt" id="pembayaran_snbt"
                                                class="form-control input-daterange">
                                        </div>
                                        @php
                                            $str_durasi = '';
                                            if (strlen($pembayaran_snbt) > 3) {
                                                $jarak = range_tanggal($pembayaran_snbt);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($pembayaran_snbt, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="border p-2 mt-2 shadow-sm">
                            <legend class="float-none w-auto p-2 text-danger">Jalur MANDIRI</legend>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Registrasi MANDIRI:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="registrasi_mandiri"
                                                id="registrasi_mandiri" class="form-control input-daterange">
                                        </div>
                                        @php
                                            $str_durasi = '';
                                            if (strlen($registrasi_mandiri) > 3) {
                                                $jarak = range_tanggal($registrasi_mandiri);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($registrasi_mandiri, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pengisian Formulir MANDIRI:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="pengisian_mandiri"
                                                id="pengisian_mandiri" class="form-control input-daterange">
                                        </div>
                                        @php
                                            $str_durasi = '';
                                            if (strlen($pengisian_mandiri) > 3) {
                                                $jarak = range_tanggal($pengisian_mandiri);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($pengisian_mandiri, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Pembayaran MANDIRI:</label>
                                        <div wire:ignore>
                                            <input type="text" wire:model="pembayaran_mandiri"
                                                id="pembayaran_mandiri" class="form-control input-daterange">
                                        </div>
                                        @php
                                            $str_durasi = '';
                                            if (strlen($pembayaran_mandiri) > 3) {
                                                $jarak = range_tanggal($pembayaran_mandiri);
                                                $str = '';
                                                if ($jarak->d) {
                                                    $str .= $jarak->d . ' hari ';
                                                }
                                                if ($jarak->h) {
                                                    $str .= $jarak->h . ' jam ';
                                                }
                                                if ($jarak->i) {
                                                    $str .= $jarak->i . ' menit';
                                                }
                                                $str_durasi = '<span class="badge badge-success">' . $str . '</span>';

                                                $str = status_jadwal($pembayaran_mandiri, 'string');
                                                if ($str == 'segera' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-secondary ml-2">Segera..</span>';
                                                } elseif ($str == 'dalam-proses' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-info ml-2">Sedang berlangsung..</span>';
                                                } elseif ($str == 'selesai' && $aktif == 'Y') {
                                                    $str_durasi .=
                                                        '<span class="badge badge-danger ml-2">Selesai!</span>';
                                                }
                                            }
                                            echo $str_durasi;
                                        @endphp
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled"
                            wire:target="updatesetup">
                            <span wire:loading.remove wire.target="updatesetup">Simpan</span>
                            <span wire:loading wire.target="updatesetup">
                                <span class="spinner-border spinner-border-sm" role="status"
                                    aria-hidden="true"></span>
                                Please wait...
                            </span>
                        </button>
                    </div>
                    <!-- /.card-footer -->
                </form>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('livewire.sistem.setup-modal')

    @push('style')
        <link rel="stylesheet" type="text/css"
            href="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    @endpush

    @push('script')
        <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
        <!-- Include Date Range Picker -->
        <script type="text/javascript" src="https://cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
        <script>
            $('.input-daterange').daterangepicker({
                timePicker: true,
                timePickerIncrement: 10,
                locale: {
                    format: 'YYYY/MM/DD H:mm'
                }
            });

            $('#registrasi_snbp').change(function() {
                //console.log($(this).val());
                @this.set('registrasi_snbp', $(this).val());
            });

            $('#pengisian_snbp').change(function() {
                //console.log($(this).val());
                @this.set('pengisian_snbp', $(this).val());
            });

            $('#pembayaran_snbp').change(function() {
                //console.log($(this).val());
                @this.set('pembayaran_snbp', $(this).val());
            });

            $('#registrasi_snbt').change(function() {
                //console.log($(this).val());
                @this.set('registrasi_snbt', $(this).val());
            });

            $('#pengisian_snbt').change(function() {
                //console.log($(this).val());
                @this.set('pengisian_snbt', $(this).val());
            });

            $('#pembayaran_snbt').change(function() {
                //console.log($(this).val());
                @this.set('pembayaran_snbt', $(this).val());
            });

            $('#registrasi_mandiri').change(function() {
                //console.log($(this).val());
                @this.set('registrasi_mandiri', $(this).val());
            });

            $('#pengisian_mandiri').change(function() {
                //console.log($(this).val());
                @this.set('pengisian_mandiri', $(this).val());
            });

            $('#pembayaran_mandiri').change(function() {
                //console.log($(this).val());
                @this.set('pembayaran_mandiri', $(this).val());
            });
        </script>
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('close-modal', (event) => {
                    //alert(event.message);
                    close_modal('ModalUpdateSetup');
                });

                Livewire.on('open-modal', (event) => {
                    open_modal('ModalUpdateSetup');
                });
            });

            function open_modal(modal) {
                $('#' + modal).modal({
                    backdrop: 'static',
                    keyboard: false,
                    show: true
                });
            }

            function close_modal(modal) {
                $('#' + modal).modal('hide');
                $("[data-dismiss=modal]").trigger({
                    type: "click"
                });
            }

            function tampilkan(value) {
                Livewire.dispatch('tampilkan-setup', {
                    tahun: value
                });
            }
        </script>
    @endpush
</div>
