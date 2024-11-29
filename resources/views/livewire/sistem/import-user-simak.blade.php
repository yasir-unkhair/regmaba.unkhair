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
            {!! flashAllert() !!}
            <!-- Default box -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $judul }}</h3>

                    <div class="card-tools">
                        <a href="{{ route('admin.pengguna') }}" class="btn btn-sm btn-default">
                            <i class="fas fa-arrow-alt-circle-left"></i> Kembali
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a href="#" class="nav-link {{ $currentStep == 1 ? 'active bg-light' : 'disabled' }}">
                                <i class="fa fa-user"></i> Pengguna
                            </a>
                        </li>

                        <li class="nav-item" role="presentation">
                            <a href="#" class="nav-link {{ $currentStep == 2 ? 'active bg-light' : 'disabled' }}">
                                <i class="fa fa-shield"></i> Role Pengguna
                            </a>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade {{ $currentStep == 1 ? 'show active' : '' }}" role="tabpanel"
                            aria-labelledby="username-tab">
                            <form wire:submit="check" method="post" class="form-horizontal">
                                <br>
                                <div class="form-group row">
                                    <label for="level" class="col-sm-2 col-form-label">Level Penguna</label>
                                    <div class="col-sm-5">
                                        <select wire:model="level" class="form-control" id="level">
                                            <option value="">-- Pilih --</option>
                                            <option value="admin" {{ $level == 'admin' ? 'selected' : '' }}>Admin
                                            </option>
                                            <option value="dosen"{{ $level == 'dosen' ? 'selected' : '' }}>Dosen
                                            </option>
                                        </select>
                                        @error('level')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="username" class="col-sm-2 col-form-label">Username Penguna</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model="username" class="form-control" id="username"
                                            placeholder="Username Pengunna">
                                        @error('username')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-sm btn-info" wire:loading.attr="disabled"
                                            wire:target="check">
                                            <span wire:loading.remove wire.target="check">Selanjutnya <i
                                                    class="fa fa-arrow-circle-right"></i></span>
                                            <span wire:loading wire.target="check">Please wait...</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade {{ $currentStep == 2 ? 'show active' : '' }}" role="tabpanel"
                            aria-labelledby="role-tab">
                            <form wire:submit="save" method="post" class="form-horizontal">
                                <br>
                                <div class="form-group row">
                                    <label for="level" class="col-sm-2 col-form-label">Nama Pengguna</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model="name" class="form-control"
                                            placeholder="Nama Pengguna">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="level" class="col-sm-2 col-form-label">Email</label>
                                    <div class="col-sm-10">
                                        <input type="text" wire:model="email" class="form-control"
                                            placeholder="Email Pengguna">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="level" class="col-sm-2 col-form-label">Role Pengguna</label>
                                    <div class="col-sm-10">
                                        @foreach ($roles as $row)
                                            <div class="form-check">
                                                <input type="checkbox" wire:model="role_pengguna"
                                                    class="form-check-input" value="{{ $row->name }}"
                                                    id="check{{ $loop->index }}">
                                                <label class="form-check-label"
                                                    for="check{{ $loop->index }}">{{ ucwords($row->name) }}</label>
                                            </div>
                                        @endforeach

                                        @error('role_pengguna')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <button type="button" wire:click="back('1')"
                                            class="btn btn-default btn-sm"><i class="fa fa-arrow-circle-left"></i>
                                            Kembali</button>
                                        <button type="submit" class="btn btn-sm btn-primary"
                                            wire:loading.attr="disabled" wire:target="save">
                                            <span wire:loading.remove wire.target="save"><i class="fa fa-save"></i>
                                                Simpan</span>
                                            <span wire:loading wire.target="save">Please wait...</span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
