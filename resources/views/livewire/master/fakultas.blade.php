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

                    <div class="card-tools pr-2">
                        <button type="button" class="btn btn-sm btn-primary" wire:loading.attr="disabled"
                            wire:click="importSimak">
                            <span wire:loading.remove wire.target="importSimak"><i class="fas fa-download"></i> Import
                                SIMAK</span>
                            <span wire:loading wire.target="importSimak"><span class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span> Please wait...</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-1">
                            <select class="form-control" wire:model.live.debounce.350="perPage">
                                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>5</option>
                                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                                <option value="20" {{ $perPage == 20 ? 'selected' : '' }}>20</option>
                                <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="table_search" class="form-control float-right"
                                    placeholder="Pencarian..." wire:model.live.debounce.350ms="pencarian">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive p-0 mb-2">
                        <table class="table table-condensed table-bordered" style="width: 100%">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fakultas</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listdata as $row)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->nama_fakultas }}</td>
                                        <td>{{ $row->status }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data kosong!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $listdata->links() }}
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    @push('script')
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
