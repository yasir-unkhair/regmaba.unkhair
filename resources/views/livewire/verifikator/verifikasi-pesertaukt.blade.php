<div>
    <form wire:submit="save">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title"><b>Catatan Verifikator</b></h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <strong><i class="fas fa-book mr-1"></i> Status/Rekomendasi <sup class="text-danger">*</sup></strong>

                <p class="text-muted">
                    @if ($rekomendasi)
                        <p class="text-muted">
                            {{ strtoupper($rekomendasi) }}
                        </p>
                    @else
                        <select wire:model="rekomendasi" class="form-control" id="rekomendasi">
                            <option value="">-- Pilih Status UKT --</option>
                            @foreach (listRekomendasi('rekomendasi', $rekomendasi) as $row)
                                <option value="{{ $row }}" {{ $row == $rekomendasi ? 'selected' : '' }}>
                                    {{ $row == 'wawancara' ? 'Wawancara' : strtoupper($row) }}
                                </option>
                            @endforeach
                        </select>
                        @error('rekomendasi')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    @endif
                </p>

                <hr>

                <strong><i class="fas fa-edit mr-1"></i> Catatan <sup class="text-danger">*</sup></strong>

                <p class="text-muted">
                    @if ($rekomendasi)
                        <p class="text-muted">
                            {{ $catatan }}
                        </p>
                    @else
                        <textarea wire:model="catatan"
                            class="form-control @error('catatan') form-control-danger @enderror border border-black p-2" rows="3"
                            placeholder="Apa catatan yang anda berikan?" {{ $rekomendasi ? 'readonly' : '' }}>{{ $catatan }}</textarea>
                        @error('catatan')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    @endif
                </p>

                @if (!$rekomendasi)
                    <button type="submit" class="btn btn-block btn-primary" wire:loading.attr="disabled"
                        wire:target="save">
                        <span wire:loading.remove wire.target="save">
                            <i class="fa fa-save"></i> Simpan
                        </span>
                        <span wire:loading wire.target="save">Please wait...</span>
                    </button>
                @endif

                <a href="{{ route('verifikator.pesertaukt.index') }}" class="btn btn-secondary btn-block">
                    <b>
                        <i class="fa fa-arrow-circle-left"></i> Kembali
                    </b>
                </a>
            </div>
            <!-- /.card-body -->
        </div>
    </form>
</div>
