<div class="modal fade" wire:ignore.self id="ModalUpdate" tabindex="-1" aria-labelledby="ModalUpdateLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="save">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="ModalUpdateLabel">Form Download</h4>
                <button type="button" class="close" wire:click="_reset">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" wire:model="id">
                <input type="hidden" wire:model="berkas_id">
                <input type="hidden" wire:model="mode">
                <div class="form-group">
                    <label for="judul">Judul File</label>
                    <input type="text" class="form-control" id="judul" wire:model="judul_file" placeholder="Judul File">
                    @error('judul_file')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="file_download">File <small class="text-muted">[ Tipe: pdf, doc, docx, dan max 5MB ]</small> @if ($url_berkas) <small class="text-muted ml-3"><a href="{{ $url_berkas }}" targer="_blank"><i class="fa fa-eye"></i> Lihat File</a></small> @endif</label>
                    <div class="custom-file" wire:ignore>
                        <input type="file" wire:model="file_download" name="file_download">
                    </div>
                    
                    @error('file_download')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                
                <div class="form-group mb-0">
                    <div class="icheck-primary mb-0">
                        <input type="checkbox" id="publish" wire:model="publish" {{ ($publish) ? 'checked' : '' }} value="1">
                        <label for="publish">
                            Publish
                        </label>
                    </div>
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