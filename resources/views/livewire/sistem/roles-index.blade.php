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
                        <button type="button" class="btn btn-sm btn-primary" onclick="open_modal('ModalUpdateRole')"><i
                                class="fas fa-plus-circle"></i> Tambah Data</button>
                    </div>
                </div>
                <div class="card-body" wire:ignore>
                    <div class="table-responsive p-0 mb-2">
                        <table class="table table-condensed table-bordered" style="width: 100%" id="id-datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Deskripsi</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($listdata as $row)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->description }}</td>
                                        <td>
                                            <button type="button" wire:click="edit('{{ $row->id }}')"
                                                class="btn btn-sm btn-warning">Edit</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('livewire.sistem.roles-modal')

    @push('script')
        <script>
            document.addEventListener('livewire:init', () => {
                Livewire.on('close-modal', (event) => {
                    //alert(event.message);
                    close_modal('ModalUpdateRole');
                });

                Livewire.on('open-modal', (event) => {
                    open_modal('ModalUpdateRole');
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
        </script>
    @endpush
</div>
