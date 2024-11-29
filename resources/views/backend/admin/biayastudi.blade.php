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
                        <h3 class="card-title">
                            Biaya Studi
                            <span class="badge badge-secondary" style="font-size:13px;">
                                {{ $prodi->kode_prodi }} -
                                {{ $prodi->nama_prodi }}
                                ({{ $prodi->jenjang_prodi }})
                            </span>
                        </h3>
                        <div class="card-tools"></div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <fieldset class="border p-2 mb-3 shadow-sm">
                                    <legend class="float-none w-auto p-2">Daftar Biaya UKT</legend>
                                    <livewire:master.biayaukt prodi_id="{{ $prodi->id }}" />
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset class="border p-2 mb-3 shadow-sm">
                                    <legend class="float-none w-auto p-2">Daftar Biaya IPI</legend>
                                    <livewire:master.biayaipi prodi_id="{{ $prodi->id }}" />
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        @push('script')
            <script>
                document.addEventListener('livewire:init', () => {
                    Livewire.on('close-modal', (event) => {
                        //alert(event.modal);
                        close_modal(event.modal);
                    });

                    Livewire.on('open-modal', (event) => {
                        //alert(event.modal);
                        open_modal(event.modal);
                    });
                });

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

                var nominal_ukt = document.getElementById('nominal_ukt');
                nominal_ukt.addEventListener('keyup', function(e) {
                    nominal_ukt.value = formatRupiah(this.value, 'Rp. ');
                });

                var nominal_ipi = document.getElementById('nominal_ipi');
                nominal_ipi.addEventListener('keyup', function(e) {
                    nominal_ipi.value = formatRupiah(this.value, 'Rp. ');
                });
            </script>
        @endpush
    </div>
@endsection
