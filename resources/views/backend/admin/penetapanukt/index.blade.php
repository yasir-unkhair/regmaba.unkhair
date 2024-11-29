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
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $judul }}</h3>

                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        <fieldset class="border p-2 mb-3 shadow-sm">
                            <legend class="float-none w-auto p-2">Filter Data</legend>
                            <form class="form-horizontal ml-2">
                                <div class="form-group row">
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Pilih Jalur
                                        Masuk</label>
                                    <div class="col-sm-2">
                                        <select name="jalur" class="form-control" id="jalur">
                                            <option value="">-- Pilih --</option>
                                            @foreach ($referensi as $ref)
                                                <option value="{{ encode_arr(['jalur' => $ref->referensi]) }}"
                                                    {{ data_params(old('jalur'), 'jalur') == $ref->referensi ? 'selected' : '' }}>
                                                    {{ $ref->referensi }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-md-5">
                                        <select class="form-control" id="prodi_id">
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
                                </div>
                            </form>
                        </fieldset>

                        <div class="table-responsive p-0 mb-2">
                            <table class="table table-condensed table-bordered" style="width: 100%"
                                id="{{ $datatable2['id_table'] }}">
                                <thead>
                                    <tr>
                                        <th class="text-left" style="width:5%">#</th>
                                        <th class="text-left">No. Peserta</th>
                                        <th class="text-left">Nama Lengkap</th>
                                        <th class="text-left">Program Studi</th>
                                        <th class="text-left">Rekomendasi</th>
                                        <th class="text-left">UKT</th>
                                        <th class="text-left">
                                            <center>Aksi</center>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

    <livewire:admin.penetapanukt />

    @push('script')
        <script type="text/javascript">
            var table;
            $(function() {
                table = $("#{{ $datatable2['id_table'] }}").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ $datatable2['url'] }}",
                        data: function(d) {
                            d.jalur = $('#jalur').val(),
                                d.prodi_id = $('#prodi_id').val()
                        }
                    },
                    columns: [
                        @foreach ($datatable2['columns'] as $row)
                            {
                                data: "{{ $row['data'] }}",
                                name: "{{ $row['name'] }}",
                                orderable: {{ $row['orderable'] }},
                                searchable: {{ $row['searchable'] }}
                            },
                        @endforeach
                    ]
                });

                $('#jalur').change(function() {
                    table.draw();
                });

                $('#prodi_id').change(function() {
                    table.draw();
                });
            });

            window.addEventListener('livewire:init', event => {
                Livewire.on('load-datatable', (event) => {
                    table.draw();
                });

                Livewire.on('close-modal', (event) => {
                    close_modal('ModalForm');
                });

                Livewire.on('open-modal', (event) => {
                    open_modal('ModalForm');
                });
            });

            function modal_penetapanukt(params) {
                Livewire.dispatch('modal-penetapanukt', {
                    params: params
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
@endsection
