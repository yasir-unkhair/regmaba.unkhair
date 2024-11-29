<div class="modal fade" wire:ignore.self id="ModalUpdate" tabindex="-1" aria-labelledby="ModalUpdateLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <form wire:submit.prevent="save">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="ModalUpdateLabel">Edit Program Studi</h4>
                    <button type="button" class="close" wire:click="_reset">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" wire:model="id">
                    <div class="form-group">
                        <label for="kode_prodi">Kode Prodi</label>
                        <input type="text" class="form-control" id="kode_prodi" wire:model="kode_prodi"
                            placeholder="Kode Prodi" readonly>
                        @error('kode_prodi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="kode_prodi">Nama Prodi</label>
                        <input type="text" class="form-control" id="nama_prodi" wire:model="nama_prodi"
                            placeholder="Nama Prodi">
                        @error('nama_prodi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="role">Fakultas</label>
                        <select class="form-control" wire:model="fakultas_id">
                            <option value="">-- Pilih Fakultas --</option>
                            @foreach ($fakultas as $row)
                                <option value="{{ $row->id }}" {{ $row->id == $fakultas_id ? 'selected' : '' }}>
                                    {{ $row->nama_fakultas }}</option>
                            @endforeach
                        </select>
                        @error('fakultas_id')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
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
