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
                        <button type="button" onclick="open_modal('ModalUpdate')" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus-circle"></i> Tambah Data
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-1">
                            <select class="form-control" wire:model.live.debounce.350="perPage">
                                <option value="5" {{ ($perPage == 5) ? 'selected' : '' }}>5</option>
                                <option value="10" {{ ($perPage == 10) ? 'selected' : '' }}>10</option>
                                <option value="20" {{ ($perPage == 20) ? 'selected' : '' }}>20</option>
                                <option value="50" {{ ($perPage == 50) ? 'selected' : '' }}>50</option>
                            </select>
                        </div>
                        <div class="col-md-8"></div>
                        <div class="col-md-3">
                            <div class="input-group">
                                <input type="text" name="table_search" class="form-control float-right" placeholder="Pencarian..." wire:model.live.debounce.350ms="pencarian">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive mb-2 border p-0">
                        <table class="table table-hover text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 10px">#</th>
                                    <th>Judul</th>
                                    <th>Tanggal</th>
                                    <th>Author</th>
                                    <th style="width: 25px">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listdata as $row)
                                    <tr>
                                        <td>{{ ($listdata ->currentpage()-1) * $listdata ->perpage() + $loop->index + 1 }}</td>
                                        <td>{{ $row->judul }}</td>
                                        <td>
                                            {!! ($row->publish) ? '<span class="text-success">Published</span>' : '<span class="text-default">Drafts</span>' !!} <br>
                                            {{ tgl_indo($row->updated_at) }}
                                        </td>
                                        <td>{{ $row->user->name ?? '' }}</td>
                                        <td>
                                            <a href="#" wire:click="edit('{{ $row->id }}')" class="btn btn-sm btn-warning">Edit</a>
                                            <button 
                                                type="button" 
                                                wire:click="delete('{{ $row->id }}')"
                                                wire:confirm="Apakah Anda yakin ingin menghapus file ini?" 
                                                class="btn btn-sm btn-danger">Hapus</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">Data kosong!</td>
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

        @include('livewire.file.download-modal')
    </section>
    <!-- /.content -->

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

        function open_modal(modal)
        {
            //alert(modal);
            $('#'+modal).modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        }

        function close_modal(modal)
        {
            $('#'+modal).modal('hide');
            $("[data-dismiss=modal]").trigger({ type: "click" });
        }
    </script>
</div>
