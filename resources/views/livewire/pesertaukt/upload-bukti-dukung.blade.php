<div>
    <div class="modal fade" wire:ignore.self id="ModalForm" aria-hidden="false" aria-labelledby="adduserModalLabel"
        role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="save" class="form-material">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Upload Dokumen</h5>
                        <button type="button" class="close" wire:click="_reset">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pb-0">
                        <dl>
                            <dt>Berkas Bukti Dukung:</dt>
                            <dd>{!! $detail !!}</dd>
                        </dl>
                        <br>
                        {{-- @dump($detail) --}}
                        <input type="hidden" wire:model="urutan">
                        <input type="hidden" wire:model="dokumen">
                        <input type="hidden" wire:model="dokumen_old">
                        <div class="form-group">
                            <label for="exampleInputFile">File Upload:</label>
                            <div class="input-group" wire:ignore>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" wire:model="file_upload"
                                        id="exampleInputFile">
                                    <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                                </div>
                            </div>
                            @error('file_upload')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="_reset"><i
                                class="fa fa-times"></i> Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled"
                            wire:target="save">
                            <span wire:loading.remove wire.target="save"><i class="fa fa-upload"></i> Upload</span>
                            <span wire:loading wire.target="save"><span class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span> Please wait...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
