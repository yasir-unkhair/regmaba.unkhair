<div class="modal fade" wire:ignore.self id="ModalUpdateSetup" tabindex="-1" aria-labelledby="ModalUpdateSetupLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="savetahun">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalUpdateSetupLabel">Tambah Tahun</h4>
                    <button type="button" class="close" wire:click="_reset">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" wire:model="id">
                    <div class="form-group">
                        <label for="name">Tahun Penerimaan</label>
                        <input type="text" class="form-control" id="tahun" wire:model="tahun_add"
                            placeholder="Tahun">
                        @error('tahun_add')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mb-0">
                        <div class="icheck-primary mb-0">
                            <input type="checkbox" wire:model="tampil" {{ $tampil ? 'checked' : '' }} value="1">
                            <label for="remember">
                                Tampil
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
