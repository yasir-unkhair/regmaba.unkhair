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
                                    <label for="inputEmail3" class="col-sm-2 col-form-label">Pilih Fakultas</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" id="fakultas_id">
                                            <option value="">-- Tampil Berdasarkan Fakultas --</option>
                                            @foreach ($fakultas as $row)
                                                <option value="{{ $row->id }}">
                                                    {{ $row->nama_fakultas }}
                                                </option>
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
                                        <th>#</th>
                                        <th>Program Studi</th>
                                        <th>Jenjang</th>
                                        <th>Fakultas</th>
                                        <th>
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

        <livewire:master.prodi />

        <!-- /.content -->
        @push('script')
            <script type="text/javascript">
                $(function() {
                    var table = $("#{{ $datatable2['id_table'] }}").DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ $datatable2['url'] }}",
                            data: function(d) {
                                d.fakultas_id = $('#fakultas_id').val()
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


                    $('#fakultas_id').change(function() {
                        table.draw();
                    });

                    if ($('#fakultas_id').val()) {
                        table.draw();
                    }
                });
            </script>

            <script>
                document.addEventListener('livewire:init', () => {
                    Livewire.on('close-modal', (event) => {
                        //alert(event.message);
                        close_modal('ModalUpdate');
                    });

                    Livewire.on('open-modal', (event) => {
                        open_modal('ModalUpdate');
                    });
                });

                function edit(prodi_id) {
                    Livewire.dispatch('edit-prodi', {
                        prodi_id: prodi_id
                    });
                }

                function open_modal(modal) {
                    //alert(modal);
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
            </script>
        @endpush
    </div>
@endsection
