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
                    <div class="card-header">
                        <h3 class="card-title">{{ $judul }}</h3>

                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
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
                                    @php
                                        $total = 0;
                                    @endphp
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
                                                        (Format file: <b>*pdf, *jpg, *jpeg</b> dan maks <b>1MB</b>)
                                                    </small>
                                                    <input type="hidden" name="detail" id="detail{{ $loop->index }}"
                                                        value="{{ $row['detail'] }}">
                                                </td>
                                                <td>
                                                    {!! $row['upload']
                                                        ? '<span class="text-success">Sudah Diupload</span>'
                                                        : '<span class="text-danger">Belum Diupload!</span>' !!}
                                                </td>
                                                <td>
                                                    <input type="hidden" name="urutan" id="urutan{{ $loop->index }}"
                                                        value="{{ $row['urutan'] }}">
                                                    <input type="hidden" name="dokumen" id="dokumen{{ $loop->index }}"
                                                        value="{{ $row['dokumen'] }}">
                                                    @if ($row['upload'])
                                                        <input type="hidden" name="dokumen_old"
                                                            id="dokumen_old{{ $loop->index }}"
                                                            value="{{ encode_arr($row['upload']) }}">
                                                        <button
                                                            onclick="popupWindow('{{ route('frontend.lihatdokumen', encode_arr($row['upload'])) }}', 'View Bukti Dukung', 900, 600)"
                                                            class="btn btn-sm btn-success">
                                                            <i class="fa fa-eye"></i> View
                                                        </button>
                                                        @php
                                                            $total++;
                                                        @endphp
                                                    @else
                                                        <input type="hidden" name="dokumen_old"
                                                            id="dokumen_old{{ $loop->index }}" value="">
                                                    @endif
                                                    <button class="btn btn-sm btn-primary btn-file text-light"
                                                        onclick="modal_show('{{ $loop->index }}')">
                                                        <i class="fa fa-upload"></i> Upload
                                                    </button>
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>

                            {{-- <div class="alert alert-info">
                                <h5>Jumlah Berkas Yang Berhasil Diupload Sebanyak <b>{{ $total }}</b></h5>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

        <livewire:pesertaukt.upload-bukti-dukung />

        @push('script')
            <script src="{{ asset('adminlte3') }}/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

            <script>
                $(function() {
                    bsCustomFileInput.init();
                });
            </script>

            <script>
                window.addEventListener('livewire:init', event => {
                    Livewire.on('close-modal', (event) => {
                        close_modal('ModalForm');
                    });

                    Livewire.on('open-modal', (event) => {
                        open_modal('ModalForm');
                    });
                });

                function modal_show(index) {
                    let detail = $('#detail' + index).val();
                    let urutan = $('#urutan' + index).val();
                    let dokumen = $('#dokumen' + index).val();
                    let dokumen_old = $('#dokumen_old' + index).val();
                    Livewire.dispatch('modal-open', {
                        detail: detail,
                        urutan: urutan,
                        dokumen: dokumen,
                        dokumen_old: dokumen_old
                    });
                }

                function open_modal(id) {
                    $('#' + id).modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                }

                function close_modal(id) {
                    $('#' + id).modal('hide');
                    $("[data-dismiss=modal]").trigger({
                        type: "click"
                    });
                }
            </script>
        @endpush
    </div>
@endsection
