<div class="modal fade" wire:ignore.self id="ModalUpdatePengguna" tabindex="-1" aria-labelledby="ModalUpdatePenggunaLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="save">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalUpdatePenggunaLabel">Form Pengguna</h4>
                    <button type="button" class="close" wire:click="_reset">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" wire:model="id">
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control" id="name" wire:model="name" placeholder="Nama">
                        @error('name')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" wire:model="email"
                            placeholder="Email">
                        @error('email')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="roles_pengguna">Role Pengguna</label>
                        <select multiple class="form-control" wire:model="roles_pengguna">
                            @foreach (roles() as $row)
                                <option value="{{ $row->name }}" @if (in_array($row->name, $roles_pengguna)) selected @endif>
                                    {{ $row->name }}</option>
                            @endforeach
                        </select>
                        @error('roles_pengguna')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Username Login</label>
                        <input type="text" class="form-control" id="username" wire:model="username"
                            placeholder="Username Login">
                        @error('username')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="username">Password Login</label>
                        <input type="password" class="form-control" id="password" wire:model="password"
                            placeholder="Password Login">
                        @error('password')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group mb-0">
                        <div class="icheck-primary mb-0">
                            <input type="checkbox" wire:model="is_active" {{ $is_active ? 'checked' : '' }}
                                value="1">
                            <label for="remember">
                                Aktif
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                        <span wire:loading.remove wire.target="save">Simpan</span>
                        <span wire:loading wire.target="save"><span class="spinner-border spinner-border-sm"
                                role="status" aria-hidden="true"></span> Please wait...</span>
                    </button>
                    <button type="button" wire:click="_reset" class="btn btn-default">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
