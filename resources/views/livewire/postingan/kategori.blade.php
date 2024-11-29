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
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modal-formAdd"><i class="fas fa-plus-circle"></i> Tambah Data</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive border p-0">
                        <table class="table table-hover text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Kategori</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 25px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listdata as $row)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $row->kategori }}</td>
                                        <td>{{ $row->deskripsi }}</td>
                                        <td>
                                            <button type="button" wire:click="edit('{{ $row->id }}')" class="btn btn-sm btn-warning">Edit</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data kosong!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    @include('livewire.postingan.form-kategori')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('close-modal', (event) => {
                alert(event.message);
                //toastr[event.type](event.message);
                close_modal('modal-formAdd');
            });

            Livewire.on('open-modal', (event) => {
                open_modal('modal-formEdit');    
            });
        });

        function open_modal(modal)
        {
            $('#'+modal).modal('show');
        }

        function close_modal(modal)
        {
            $('#'+modal).modal('hide');
            $("[data-dismiss=modal]").trigger({ type: "click" });
        }
    </script>
</div>
