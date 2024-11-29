<div class="modal fade" wire:ignore.self id="ModalUpdateRole" tabindex="-1" aria-labelledby="ModalUpdateRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="save">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalUpdateRoleLabel">Form Role Pengguna</h4>
                <button type="button" class="close" wire:click="_reset">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" wire:model="id">
                <div class="form-group">
                    <label for="role">Role</label>
                    <input type="text" class="form-control" id="role" wire:model="name" placeholder="Role">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="role">Deskripsi</label>
                    <textarea class="form-control" id="role" wire:model="description" rows="3" placeholder="Deskripsi Role"></textarea>
                    @error('description')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                    <span wire:loading.remove wire.target="save">Simpan</span>
                    <span wire:loading wire.target="save"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...</span>
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