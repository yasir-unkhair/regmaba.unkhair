<div>
    <div class="table-responsive">
        <table class="table table-condensed table-bordered" style="width: 100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th class="text-left">Kategori IPI</th>
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
                        <td>IPI-{{ $row->kategori }}</td>
                        <td class="text-right">{{ rupiah($row->nominal) }}</td>
                        <td>
                            <center>
                                <button type="button" wire:click="edit('{{ $row->id }}')"
                                    class="btn btn-warning btn-sm">
                                    <i class="fa fa-pencil"></i>
                                </button>
                                <button type="button" wire:click="hapus('{{ $row->id }}')"
                                    wire:confirm="Yakin IPI-{{ $row->kategori }} akan dihapus?"
                                    class="btn btn-danger btn-sm">
                                    <i class="fa fa-trash"></i>
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

    <button type="button" wire:click="add" class="btn btn-primary btn-sm mt-1">
        <i class="fa fa-plus-circle"></i> Tambah IPI
    </button>

    <div class="modal fade" wire:ignore.self id="ModalIPI" tabindex="-1" aria-labelledby="ModalIPILabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form wire:submit.prevent="save">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" id="ModalIPILabel">{{ $lable }}</h4>
                        <button type="button" class="close" wire:click="_reset">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" wire:model="id">
                        <input type="hidden" wire:model="mode">
                        <div class="form-group">
                            <label for="kode_prodi">Kategori</label>
                            <select wire:model="kategori_ipi" class="form-control">
                                <option value="">-- Pilih --</option>
                                @for ($i = 1; $i <= 3; $i++)
                                    <option value="{{ $i }}" {{ $kategori_ipi == $i ? 'selected' : '' }}>
                                        IPI-{{ $i }}</option>
                                @endfor
                            </select>
                            @error('kategori_ipi')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kode_prodi">Nominal (Rp)</label>
                            <input type="text" wire:model="nominal_ipi" id="nominal_ipi" class="form-control">
                            @error('nominal_ipi')
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
