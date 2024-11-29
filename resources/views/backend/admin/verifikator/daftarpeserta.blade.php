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

                                <h3 class="profile-username text-center">{{ $user->name }}</h3>

                                <p class="text-muted text-center">{{ $user->email }}</p>

                                <ul class="list-group list-group-unbordered mb-3">
                                    <li class="list-group-item">
                                        <b>Jalur </b>
                                        <span class="float-right badge bg-info"
                                            style="font-size:11px;">{{ $jalur }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Tahun </b>
                                        <span class="float-right badge bg-success"
                                            style="font-size:11px;">{{ $tahun }}</span>
                                    </li>
                                    <li class="list-group-item">
                                        <b>Jumlah Peserta</b>
                                        <a class="float-right badge bg-warning" style="font-size:11px;">
                                            {{ $jml_peserta }}
                                        </a>
                                    </li>
                                </ul>

                                <a href="{{ route('admin.verifikator.penugasan') }}"
                                    class="btn btn-secondary btn-block"><b><i class="fa fa-arrow-circle-left"></i>
                                        Kembali</b></a>
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
                                                <div class="col-md-4">
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
                                        </fieldset>

                                        <div class="table-responsive">
                                            <table class="table table-condensed table-bordered" style="width: 100%"
                                                id="{{ $datatable2['id_table'] }}">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left" style="width:5%">#</th>
                                                        <th class="text-left">No. Peserta</th>
                                                        <th class="text-left">Nama Peserta</th>
                                                        <th class="text-left">Program Studi</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
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

        @push('script')
            <script type="text/javascript">
                $(function() {
                    var table = $("#{{ $datatable2['id_table'] }}").DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: {
                            url: "{{ $datatable2['url'] }}",
                            data: function(d) {
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


                    $('#prodi_id').change(function() {
                        table.draw();
                    });

                    if ($('#prodi_id').val()) {
                        table.draw();
                    }
                });
            </script>
        @endpush
    </div>
@endsection
