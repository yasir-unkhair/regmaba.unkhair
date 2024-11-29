<div>
    <table class="table table-striped table-bordered">
        <tr>
            <td width="25%" style="vertical-align: middle;">Nomor VA</td>
            <td>
                @if ($trx_id)
                    <div style="letter-spacing:2px; font-weight:bold; font-size:16pt">
                        {{ $va }}
                        <span class="copytext text-primary"
                            style="letter-spacing:0px; font-weight:normal; font-size:12pt">
                            <span id="copy" class="text-primary" style="font-size:12pt"
                                onclick="copy('{{ $va }}')" title="Copy"> <i class="fa fa-copy"></i>
                            </span>
                        </span>
                    </div>
                @else
                    <span class="text-danger">Nomor VA belum dibuat!</span>
                    {{-- <a href="" class="badge bg-primary">Generate VA</a> --}}
                @endif

            </td>
        </tr>
        <tr>
            <td>Nominal</td>
            <td>Rp {{ rupiah($amount) }}</td>
        </tr>
        <tr>
            <td>Tenggat Waktu</td>
            <td>
                {{ tgl_indo($expired) }} WIT
                @if ($trx_id && $lunas == 0)
                    @if (!bool_tgl_pembayaran($expired))
                        <a href="#" class="badge bg-primary"
                            wire:click="generateva('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}', 'update')"
                            wire:loading.attr="disabled" class="label label-primary">
                            <span wire:loading.remove
                                wire.target="generateva('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}', 'update')">
                                Request VA Ulang
                            </span>
                            <span wire:loading
                                wire.target="generateva('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}', 'update')">
                                Please wait...
                            </span>
                        </a>
                    @endif
                @endif
            </td>
        </tr>
        <tr>
            <td>Metode Pembayaran</td>
            <td>{{ $bank }}</td>
        </tr>
        <tr>
            <td>Keterangan</td>
            <td>{!! $detail_pembayaran !!}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>
                @if ($lunas == 0)
                    @if ($lunas && !bool_tgl_pembayaran($expired))
                        <span class="badge bg-red">Kadaluarsa</span>
                    @else
                        <span class="badge bg-red">Belum Lunas</span>
                    @endif
                @else
                    <span class="badge bg-cyan">Lunas</span>
                @endif
            </td>
        </tr>
    </table>

    @if ($lunas == 0 && $trx_id)
        <div class="alert warna-warning" role="alert">
            Klik tombol <b><u>Konfirmasi Pembayaran</u></b> jika anda sudah melakukan pembayaran.
        </div>
    @elseif ($lunas == 1)
        <div class="alert warna-success" role="alert">
            Anda Telah Melunasi Pembayaran
        </div>
    @else
        <a href="{{ route('peserta.pembayaran') }}" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-circle-left"></i> Kembali
        </a>

        <button type="button"
            wire:click="generateva('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}', 'create')"
            wire:loading.attr="disabled" class="btn btn-primary btn-sm">
            <span wire:loading.remove
                wire.target="generateva('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}', 'create')">
                <i class="ti-settings"></i> Generate VA
            </span>
            <span wire:loading
                wire.target="generateva('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}', 'create')">
                Please wait...
            </span>
        </button>
    @endif


    @if ($lunas == 0 && $trx_id)
        <a href="{{ route('peserta.pembayaran') }}" class="btn btn-default btn-sm">
            <i class="fa fa-arrow-circle-left"></i> Kembali
        </a>

        @if (bool_tgl_pembayaran($expired))
            <a href="{{ route('peserta.pembayaran.cetak', $pembayaran_id) }}" target="_blank"
                class="btn btn-warning btn-sm">
                <i class="fa fa-print"></i> Cetak Slip Pembayaran
            </a>
        @endif

        <button type="button" wire:click="cekstatus('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}')"
            wire:loading.attr="disabled" class="btn btn-info btn-sm">
            <span wire:loading.remove wire.target="cekstatus('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}')">
                <i class="fa fa-check"></i>
                Konfirmasi Pembayaran
            </span>
            <span wire:loading wire.target="cekstatus('{{ encode_arr(['pembayaran_id' => $pembayaran_id]) }}')">
                Please wait...
            </span>
        </button>
    @endif
</div>
