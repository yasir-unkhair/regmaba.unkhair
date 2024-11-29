<div class="modal fade" wire:ignore.self id="ModalUpdateReferensi" tabindex="-1" aria-labelledby="ModalUpdateReferensiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="saveReferensi">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalUpdateReferensiLabel">Form Referensi</h4>
                <button type="button" class="close" wire:click="_reset('ModalUpdateReferensi')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" wire:model="id">
                <input type="hidden" wire:model="mode">
                <div class="form-group">
                    <label for="referensi">Referensi</label>
                    <input type="text" class="form-control" id="referensi" wire:model="referensi" placeholder="Referensi">
                    @error('referensi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveReferensi">
                    <span wire:loading.remove wire.target="saveReferensi">Simpan</span>
                    <span wire:loading wire.target="saveReferensi"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...</span>
                </button>
                <button type="button" wire:click="_reset('ModalUpdateReferensi')" class="btn btn-default">Tutup</button>
            </div>
        </div>
        <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" wire:ignore.self id="ModalUpdateSubReferensi" tabindex="-1" aria-labelledby="ModalUpdateSubReferensiLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="saveSubReferensi">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalUpdateSubReferensiLabel">Form Sub Referensi</h4>
                <button type="button" class="close" wire:click="_reset('ModalUpdateSubReferensi')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" wire:model="id">
                <input type="hidden" wire:model="mode">
                <div class="form-group">
                    <label for="referensi">Referensi</label>
                    <select class="form-control" wire:model="parent_id" id="parent_id">
                        <option value="">-- Pilih Referensi --</option>
                        @foreach ($listReferensi as $row)
                            <option value="{{ $row->id }}" {{ ($row->id == $parent_id) ? 'selected' : '' }}>{{ $row->referensi }}</option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="referensi">Sub Referensi</label>
                    <input type="text" class="form-control" id="referensi" wire:model="referensi" placeholder="Referensi">
                    @error('referensi')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="saveSubReferensi">
                    <span wire:loading.remove wire.target="saveSubReferensi">Simpan</span>
                    <span wire:loading wire.target="saveSubReferensi"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...</span>
                </button>
                <button type="button" wire:click="_reset('ModalUpdateSubReferensi')" class="btn btn-default">Tutup</button>
            </div>
        </div>
        <!-- /.modal-content -->
        </form>
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

