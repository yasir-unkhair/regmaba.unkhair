<div>
    <div class="modal fade" wire:ignore.self id="ModalForm" aria-hidden="false" aria-labelledby="adduserModalLabel"
        role="dialog" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form wire:submit.prevent="save" class="form-material">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Form Penetapan UKT</h5>
                        <button type="button" class="close" wire:click="_reset">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <dl>
                            <dt><i class="fa fa-user"></i> Verifikator :</dt>
                            <dd>
                                {{ $verifikator }}
                                <span class="float-right text-muted">
                                    <i class="fa fa-clock"></i> &nbsp;
                                    <i>{{ tgl_indo($tgl_verifikasi) }}</i>
                                </span>
                            </dd>
                            <hr>
                            <dt><i class="fa fa-tag"></i> Rekomendasi :</dt>
                            <dd>{{ strtoupper($rekomendasi) }}</dd>
                            <hr>
                            <dt><i class="fa fa-sticky-note"></i> Catatan :</dt>
                            <dd>{{ $catatan }}</dd>
                        </dl>
                        <hr>
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label" style="font-size:13px"><b>Penetapan UKT
                                    <span class="text-danger">*</span>
                                    :</b></label>
                            <select wire:model="kategori_ukt" class="form-control" style="font-size:13px">
                                <option value="">-- Kategori UKT --</option>
                                <option value="wawancara" {{ $kategori_ukt == 'wawancara' ? 'selected' : '' }}>
                                    Wawancara
                                </option>
                                <option value="kip-k" {{ $kategori_ukt == 'kip-k' ? 'selected' : '' }}>KIP-K</option>
                                @foreach ($listdata_ukt as $row)
                                    <option value="{{ $row->id }}"
                                        {{ $kategori_ukt == 'k' . $row->kategori ? 'selected' : '' }}>
                                        {{ 'UKT-' . $row->kategori . ' (Rp. ' . rupiah($row->nominal) . ')' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('kategori_ukt')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        @if ($get && strtolower($get->jalur) == 'mandiri')
                            <div class="form-group mt-2">
                                <label for="recipient-name" class="col-form-label" style="font-size:13px"><b>Penetapan
                                        IPI <i class="text-danger">(Jalur
                                            Mandiri)</i> :</b></label>
                                <select wire:model="kategori_ipi" class="form-control" style="font-size:13px">
                                    <option value="">-- Kategori IPI --</option>
                                    @foreach ($listdata_ipi as $row)
                                        <option value="{{ $row->id }}"
                                            {{ $kategori_ipi == $row->id ? 'selected' : '' }}>
                                            {{ 'UKT-' . $row->kategori . ' (Rp. ' . rupiah($row->nominal) . ')' }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('kategori_ipi')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" wire:click="_reset"><i
                                class="fa fa-times"></i> Tutup</button>
                        <button type="submit" class="btn btn-primary btn-sm" wire:loading.attr="disabled"
                            wire:target="save">
                            <span wire:loading.remove wire.target="save"><i class="fa fa-save"></i> Simpan</span>
                            <span wire:loading wire.target="save"><span class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span> Please wait...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
