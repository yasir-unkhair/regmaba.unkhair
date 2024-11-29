<div>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-left">Kategori UKT</th>
                    <th class="text-right">Nominal (Rp)</th>
                    <th>
                        <center>Aksi</center>
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse ($listdata as $row)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>UKT-{{ $row->kategori }}</td>
                        <td class="text-right">{{ rupiah($row->nominal) }}</td>
                        <td>
                            <center>
                                <button type="button" wire:click="edit('{{ $row->id }}')"
                                    class="btn btn-warning btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </button>
                            </center>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">Data kosong!</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>


    <div class="modal fade" wire:ignore.self id="ModalUKT" tabindex="-1" aria-labelledby="ModalUKTLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="save">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="ModalUKTLabel">Edit Biaya UKT</h4>
                        <button type="button" class="close" wire:click="_reset">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" wire:model="id">
                        <div class="form-group">
                            <label for="kode_prodi">Kategori</label>
                            <select wire:model="kategori_ukt" class="form-control">
                                <option value="">-- Pilih --</option>
                                @for ($i = 1; $i <= 8; $i++)
                                    <option value="{{ $i }}" {{ $kategori_ukt == $i ? 'selected' : '' }}>
                                        UKT-{{ $i }}</option>
                                @endfor
                            </select>
                            @error('kategori_ukt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kode_prodi">Nominal (Rp)</label>
                            <input type="text" wire:model="nominal_ukt" id="nominal_ukt" class="form-control">
                            @error('nominal_ukt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="save">
                            <span wire:loading.remove wire.target="save">Simpan</span>
                            <span wire:loading wire.target="save">
                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                Please wait...
                            </span>
                        </button>
                        <button type="button" wire:click="_reset" class="btn btn-default">Tutup</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </form>
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
