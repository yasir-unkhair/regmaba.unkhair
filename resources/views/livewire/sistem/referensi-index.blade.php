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
                        <button type="button" class="btn btn-sm btn-info"
                            wire:click="open_modal('ModalUpdateSubReferensi')"><i class="fas fa-plus-circle"></i> Tambah
                            Sub Referensi</button>
                        <button type="button" class="btn btn-sm btn-primary"
                            wire:click="open_modal('ModalUpdateReferensi')"><i class="fas fa-plus-circle"></i> Tambah
                            Referensi</button>
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
                                    <th>Referensi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listdata as $row)
                                    <tr class="bg-light text-bold">
                                        <td>{{ ($listdata->currentpage() - 1) * $listdata->perpage() + $loop->index + 1 }}
                                        </td>
                                        <td>{{ $row->referensi }}</td>
                                        <td>
                                            <button type="button"
                                                wire:click="edit('{{ $row->id }}', 'ModalUpdateReferensi')"
                                                class="btn btn-sm btn-warning">Edit</button>
                                        </td>
                                    </tr>
                                    @foreach ($row->subReferensi()->orderBy('created_at', 'ASC')->get() as $sub)
                                        <tr>
                                            <td></td>
                                            <td><span style="font-size:11px"><i class="fa fa-long-arrow-right"
                                                        aria-hidden="true"></i></span> {{ $sub->referensi }}</td>
                                            <td>
                                                <button type="button"
                                                    wire:click="edit('{{ $row->id }}', 'ModalUpdateSubReferensi')"
                                                    class="btn btn-sm btn-warning">Edit</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="3">Data kosong!</td>
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

    @include('livewire.sistem.referensi-modal')

    @push('script')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('close-modal', (event) => {
                    //alert(event.message);
                    close_modal(event.modal_id);
                });

                Livewire.on('open-modal', (event) => {
                    console.log(event.referensi);
                    open_modal(event.modal_id);
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
