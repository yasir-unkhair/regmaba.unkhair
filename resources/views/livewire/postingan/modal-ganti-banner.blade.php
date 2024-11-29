<div class="modal fade" wire:ignore.self id="ModalGantiBanner" tabindex="-1" aria-labelledby="ModalGantiBannerLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="act_gantibanner">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalGantiBannerLabel">Ganti Sampul Informasi</h4>
                <button type="button" class="close" wire:click="_reset">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" wire:model="id">
                <input type="hidden" wire:model="berkas_id">
                <input type="hidden" wire:model="url_berkas">
                <div class="form-group">
                    <label for="judul">Sampul Informasi <small class="text-muted">[ Tipe: jpg, jpeg, dan max 1MB ]</small></label>
                    <div class="custom-file">
                        <input type="file" wire:model="gambar_sampul" name="gambar_sampul">
                    </div>
                    
                    @error('gambar_sampul')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                    @if ($gambar_sampul && in_array($gambar_sampul->getMimeType(), ['image/jpeg']))
                        Preview: <br>
                        <img src="{{ $gambar_sampul->temporaryUrl() }}" style="width:330px; height: 180px;" class="img-thumbnail">
                    @endif
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="act_gantibanner">
                    <span wire:loading.remove wire.target="act_gantibanner">Simpan</span>
                    <span wire:loading wire.target="act_gantibanner"><span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Please wait...</span>
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