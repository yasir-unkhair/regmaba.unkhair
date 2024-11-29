<div>
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('images/avatar5.png') }}"
                            alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->email }}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                        <li class="list-group-item">
                            <b>Jalur </b>
                            <span class="float-right badge bg-info" style="font-size:11px;">{{ $jalur }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Tahun </b>
                            <span class="float-right badge bg-success"
                                style="font-size:11px;">{{ $tahun }}</span>
                        </li>
                        <li class="list-group-item">
                            <b>Jumlah Peserta</b>
                            <a href="{{ route('admin.verifikator.daftarpeserta', encode_arr(['verifikator_id' => $user->id, 'jalur' => $jalur])) }}"
                                class="float-right badge bg-warning" style="font-size:11px;">
                                {{ $jml_peserta }}
                            </a>
                        </li>
                    </ul>

                    <a href="{{ route('admin.verifikator.penugasan') }}" class="btn btn-secondary btn-block"><b><i
                                class="fa fa-arrow-circle-left"></i> Kembali</b></a>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#activity"
                                data-toggle="tab">{{ $judul }}</a>
                        </li>
                    </ul>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content">
                        <div class="active tab-pane" id="activity">
                            <fieldset class="border p-2 mb-3 shadow-sm">
                                <legend class="float-none w-auto p-2">Filter Data</legend>
                                <div class="row mb-2">
                                    <div class="col-md-1">
                                        <select class="form-control" wire:model.live.debounce.350="perPage">
                                            <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10
                                            </option>
                                            <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20
                                            </option>
                                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select class="form-control" wire:model.live.debounce.350="prodi_id">
                                            <option value="">-- Filter Program Studi --</option>
                                            @foreach ($fakultas as $row)
                                                <optgroup label="{{ $row->nama_fakultas }}">
                                                    @foreach ($row->prodi()->orderBy('jenjang_prodi', 'ASC')->get() as $prodi)
                                                        <option value="{{ $prodi->id }}">
                                                            {{ $prodi->jenjang_prodi }} -
                                                            {{ $prodi->nama_prodi }}
                                                        </option>
                                                    @endforeach
                                                </optgroup>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-3"></div>
                                    <div class="col-md-4">
                                        <div class="input-group">
                                            <input type="text" name="table_search" class="form-control float-right"
                                                placeholder="Ketik Nama / Nomor Peserta"
                                                wire:model.live.debounce.350ms="pencarian">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="table-responsive">
                                <table class="table table-condensed table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-left" style="width:5%">Pilih</th>
                                            <th class="text-left">No. Peserta</th>
                                            <th class="text-left">Nama Peserta</th>
                                            <th class="text-left">Program Studi</th>
                                            <th class="text-left">Verifikator</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($pesertaukt as $row)
                                            @php
                                                $checked = false;
                                                $disabled = false;
                                                $color = '';

                                                $verifikator = $row->verifikasiberkas?->verifikator_id;
                                                $rekomendasi = $row->verifikasiberkas?->rekomendasi;

                                                // jika id_verifikator sama maka ceklist
                                                if ($verifikator && $verifikator == $verifikator_id) {
                                                    $checked = true;
                                                    $color = 'warna-info';
                                                }

                                                // jika id_verifikator tidak sama maka disabled dan di ceklist
                                                if ($verifikator && $verifikator != $verifikator_id) {
                                                    $disabled = true;
                                                    $checked = true;
                                                    $color = 'warna-warning';
                                                }

                                                // jika verifikator sudah verifikasi maka disabled
                                                if ($rekomendasi) {
                                                    $disabled = true;
                                                    $color = 'warna-warning';
                                                    if ($verifikator && $verifikator == $verifikator_id) {
                                                        $checked = true;
                                                        $color = 'warna-info';
                                                    }
                                                }
                                            @endphp
                                            <tr class="{{ $color }}">
                                                <td>
                                                    @if ($disabled)
                                                        <span class="text-danger badge bg-danger"
                                                            style="font-size:10px;">
                                                            <i class="fa fa-times" aria-hidden="true"></i>
                                                        </span>
                                                    @else
                                                        <input type="checkbox"
                                                            onclick="pilih('{{ encode_arr(['verifikator_id' => $verifikator_id, 'peserta_id' => $row->id]) }}', '{{ $row->nomor_peserta }}')"
                                                            id="pilih-{{ $row->nomor_peserta }}"
                                                            value="{{ $row->id }}"
                                                            {{ $checked ? 'checked' : '' }}
                                                            {{ $disabled ? 'disabled' : '' }}>
                                                    @endif
                                                </td>
                                                <td>{{ $row->nomor_peserta }}</td>
                                                <td>{{ $row->nama_peserta }}</td>
                                                <td>
                                                    {{ $row->prodi?->jenjang_prodi . ' - ' . $row->prodi?->nama_prodi }}
                                                </td>
                                                <td>
                                                    {{ $row->verifikasiberkas->verifikator->name ?? '' }}
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">Data kosong!</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {{ $pesertaukt->links() }}
                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            </div>
            <!-- /.card -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    @push('script')
        <script>
            function pilih(params, nomor_peserta) {
                var act = 'remove';
                if ($('#pilih-' + nomor_peserta).is(':checked')) {
                    act = 'add';
                }

                Livewire.dispatch('act-pilih', {
                    params: params,
                    act: act
                });
            }
        </script>
    @endpush
</div>
