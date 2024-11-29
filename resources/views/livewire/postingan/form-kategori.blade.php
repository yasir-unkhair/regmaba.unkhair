<div class="modal fade" wire:ignore.self id="modal-formAdd" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="saveAdd">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" class="form-control" id="kategori" wire:model="kategori" placeholder="Kategori">
                    @error('kategori')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" wire:model="deskripsi" placeholder="Deskripsi" rows="3"></textarea>
                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <div class="modal-footer justify-align-content-between">
                <div wire:loading wire:target="saveAdd">  
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...
                </div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveAdd">Simpan</button>
                <button type="button" class="btn btn-default right" data-dismiss="modal">Batal</button>
            </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" wire:ignore.self id="modal-formEdit" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="saveEdit">
            <div class="modal-header">
                <h4 class="modal-title">Edit Kategori</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <div class="modal-body">
                <input type="hidden" wire:model="id">
                <div class="form-group">
                    <label for="kategori">Kategori</label>
                    <input type="text" class="form-control" id="kategori" wire:model="kategori" placeholder="Kategori">
                    @error('kategori')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea class="form-control" id="deskripsi" wire:model="deskripsi" placeholder="Deskripsi" rows="3">{{ $deskripsi }}</textarea>
                    @error('deskripsi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            
            <div class="modal-footer justify-align-content-between">
                <div wire:loading wire:target="saveEdit">  
                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...
                </div>
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveEdit">Simpan</button>
                <button type="button" class="btn btn-default right" data-dismiss="modal">Batal</button>
            </div>
            </form>
        </div>
    <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->