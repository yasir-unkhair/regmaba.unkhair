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
                            <li class="breadcrumb-item active">Data Peserta</li>
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
                    <form action="{{ route('admin.datapeserta.actupload') }}" method="post" class="form-horizontal">
                        <div class="card-header">
                            <h3 class="card-title">{{ $judul }}</h3>

                            <div class="card-tools"></div>
                        </div>

                        <div class="card-body">
                            @csrf
                            <input type="hidden" name="setup_id" id="setup_id" value="{{ $setup->id }}">
                            <input type="hidden" name="jalur" id="jalur" value="{{ $jalur }}">

                            <div class="callout callout-info mb-2">
                                <b>Petunjun pengisian:</b><br>
                                1. Silahkan lengkapi kolom yang mengandung tanda bintang (<span
                                    class="text-danger">*</span>). <br>
                                2. Jangan memasukan simbol-simbol tertentu. <br>
                                3. Maksimal data yang di proses sebanyak 1000 data.
                            </div>

                            @if (session('galat'))
                                {{-- @dump(session('galat'), session('galat')['data']) --}}
                                <div class="row mt-2">
                                    <div class="col-md-12 col-md-offset-1">
                                        <div class="alert alert-danger alert-dismissible">
                                            <button type="button" class="close" data-dismiss="alert"
                                                aria-hidden="true">×</button>
                                            <h4><i class="icon fa fa-ban"></i> Error!</h4>
                                            @if (array_key_exists('data', session('galat')))
                                                @foreach (session('galat')['data']->all() as $error)
                                                    {{ $error }}<br>
                                                @endforeach
                                            @endif

                                            @if (array_key_exists('jalur', session('galat')))
                                                @foreach (session('galat')['jalur']->all() as $error)
                                                    {{ $error }}<br>
                                                @endforeach
                                            @endif

                                            @if (array_key_exists('peserta', session('galat')))
                                                @foreach (session('galat')['peserta'] as $val)
                                                    @foreach ($val['errors']->all() as $error)
                                                        Data baris {{ $val['baris'] }} - {{ $error }} <br>
                                                    @endforeach
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="table-responsive p-0 mt-4">
                                <input type="hidden" name="data" id="json-peserta" value="">
                                <div id="tbl-peserta"></div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" id="btn-submit" class="btn btn-info">
                                <i class="fa fa-save"></i> Simpan Data (0)
                            </button>
                        </div>
                    </form>
                </div>
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    @push('style')
        <link rel="stylesheet" media="screen" href="{{ asset('adminlte3/plugins/handsontable/handsontable.full.min.css') }}">
    @endpush

    @push('script')
        <script src="{{ asset('adminlte3/plugins/handsontable/handsontable.full.min.js') }}"></script>

        <script>
            var base_url = "{{ route('admin.datapeserta.index') }}";
            var id_setup = "{{ $setup->id }}";
            var firstLoad = true;
            var peserta_overload = false;
            var data =
                @if (old('data'))
                    {!! old('data') !!}
                @else
                    []
                @endif ;

            const hot = new Handsontable(document.getElementById('tbl-peserta'), {
                startRows: 5,
                startCols: 16,
                rowHeaders: true,
                manualColumnResize: true, // true user bisa lebar/kecilkan kolom
                maxRows: 1000,
                dataSchema: {
                    nomor_peserta: null,
                    nisn: null,
                    nama_peserta: null,
                    //jk: null,
                    jalur: "{{ $jalur }}",
                    kode_prodi: null,
                    tpl_lahir: null,
                    tgl_lahir: null,
                    //nik: null,
                    //alamat_asal: null,
                    npsn: null,
                    sekolah_asal: null,
                    nomor_kip: null,
                    pebanding_penghasilan_ayah: null,
                    pebanding_penghasilan_ibu: null,
                },

                contextMenu: true,
                data: data,
                height: 500,
                stretchH: 'all',
                minSpareCols: 1,
                minSpareRows: 1000,
                language: 'id',
                columns: [{
                        type: 'text',
                        data: 'nomor_peserta',
                        title: 'NOMOR PESERTA <span class="text-danger">*</span>',
                        width: 120,
                    },
                    {
                        type: 'text',
                        data: 'nisn',
                        title: 'NISN <span class="text-danger">*</span>',
                        width: 100
                    },
                    {
                        type: 'text',
                        data: 'nama_peserta',
                        title: 'NAMA LENGKAP <span class="text-danger">*</span>',
                        width: 250
                    },
                    /*{
                        type: 'dropdown',
                        data: 'jk',
                        title: 'JK',
                        width: 50,
                        source: ['L', 'P']
                    },*/
                    {
                        type: 'text',
                        data: 'jalur',
                        title: 'JALUR',
                        readOnly: true,
                        width: 100
                    },
                    {
                        type: 'text',
                        data: 'kode_prodi',
                        title: 'KODE PRODI <span class="text-danger">*</span>',
                        width: 100
                    },
                    {
                        type: 'text',
                        data: 'tpl_lahir',
                        title: 'TEMPAT LAHIR',
                        width: 150
                    },
                    {
                        type: 'text',
                        data: 'tgl_lahir',
                        title: 'TANGGAL LAHIR',
                        width: 100
                    },
                    /*{
                        type: 'text',
                        data: 'nik',
                        title: 'NIK',
                        width: 200
                    },
                    {
                        type: 'text',
                        data: 'alamat_asal',
                        title: 'ALAMAT LENGKAP',
                        width: 500
                    },*/
                    {
                        type: 'text',
                        data: 'npsn',
                        title: 'NPSN <span class="text-danger">*</span>',
                        width: 100
                    },
                    {
                        type: 'text',
                        data: 'sekolah_asal',
                        title: 'SEKOLAH ASAL <span class="text-danger">*</span>',
                        width: 250
                    },
                    {
                        type: 'text',
                        data: 'nomor_kip',
                        title: 'NOMOR KIP',
                        width: 150
                    },
                    {
                        type: 'text',
                        data: 'pebanding_penghasilan_ayah',
                        title: 'PENGHASILAN AYAH',
                        width: 200
                    },
                    {
                        type: 'text',
                        data: 'pebanding_penghasilan_ibu',
                        title: 'PENGHASILAN IBU',
                        width: 200
                    }
                ],
                afterChange: function(change, source) {
                    //alert(source);
                    summary(this.getData());
                },
                afterRemoveRow: function() {
                    summary(this.getData());
                }
            });

            function summary(data) {
                if (!data) {
                    return;
                }
                var count = 0;
                for (var i = 0; i < data.length; i++) {
                    if (data[i].nomor_peserta && data[i].nisn && data[i].nama_peserta && data[i].kode_prodi && data[i].npsn) {
                        count++;
                    }
                }

                if (count) {
                    $('#json-peserta').val(JSON.stringify(data));
                }

                $('#btn-submit').html('<i class="fa fa-save"></i> Simpan Data (' + count + ')');
                console.log(count);
            }
        </script>
    @endpush
@endsection
