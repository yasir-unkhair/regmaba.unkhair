<div>
    <div class="row m-b-20">
        <div class="col-md-12">
            <center><img src="{{ asset('images/unkhair.png') }}" class="logo-icon" alt=""></center><br>
            <h4 class="text-center">{{ $judul }}</h4>
        </div>
    </div>
    <hr>

    @if ($flash = flashAllert())
        {!! $flash !!}
    @endif

    <ul class="nav nav-tabs" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="#" class="nav-link {{ $currentStep == 1 ? 'active bg-light' : 'disabled' }}">
                <i class="fa fa-user"></i> Identitas
            </a>
        </li>

        <li class="nav-item" role="presentation">
            <a href="#" class="nav-link {{ $currentStep == 2 ? 'active bg-light' : 'disabled' }}">
                <i class="fa fa-shield"></i> Konfirmasi
            </a>
        </li>
    </ul>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade {{ $currentStep == 1 ? 'show active' : '' }}" role="tabpanel"
            aria-labelledby="username-tab">
            <form wire:submit="check" method="post">
                <br>
                <div class="form-group rounded">
                    <label><b>Nomor Ujian (Peserta):</b></label>
                    <input type="text" wire:model="nomor_peserta"
                        class="form-control form-control-lg @error('nomor_peserta') form-control-danger @enderror"
                        placeholder="Masukkan Nomor Ujian (Peserta)">
                    <span class="form-bar"></span>
                    @error('nomor_peserta')
                        <span class="text-danger">{!! $message !!}</span>
                    @enderror
                </div>

                <div class="form-group rounded">
                    <label><b>NISN:</b></label>
                    <input type="text" wire:model="nisn"
                        class="form-control form-control-lg @error('nisn') form-control-danger @enderror"
                        placeholder="Masukkan NISN">
                    <span class="form-bar"></span>
                    @error('nisn')
                        <span class="text-danger">{!! $message !!}</span>
                    @enderror
                </div>
                <div class="row m-t-30 mb-2">
                    <div class="col-md-12">
                        <div class="text-center">
                            <button type="submit"
                                class="btn btn-primary btn-md btn-block waves-effect waves-light text-center"
                                wire:loading.attr="disabled" wire:target="check">
                                <span wire:loading.remove wire.target="check">
                                    Selanjutnya <i class="fa fa-arrow-circle-right"></i>
                                </span>
                                <span wire:loading wire.target="check">
                                    <span class="spinner-border spinner-border-sm" role="status"
                                        aria-hidden="true"></span>
                                    Waiting...
                                </span>
                            </button>
                        </div>
                        <br>
                        <div class="border border-primary rounded p-2 text-center mb-2">
                            <span style="color:#000">Sudah punya akun?</span> <a href="{{ route('auth.login') }}"
                                class="text-primary" style="font-size:12px">Login disini</a> <br>
                        </div>
                        <div class="border border-danger rounded p-2 text-center">
                            <a href="{{ route('frontend.beranda') }}" class="text-danger" style="font-size:12px">Kembali
                                ke Halaman
                                Utama</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="tab-pane fade {{ $currentStep == 2 ? 'show active' : '' }}" role="tabpanel"
            aria-labelledby="role-tab">
            @if ($get)
                <form wire:submit="confirmReg" method="post">
                    <table class="table border border-black" style="font-size:13px;">
                        <tr>
                            <th class="text-right">Nomor Peserta :</th>
                            <td>{{ $get['nomor_peserta'] }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">NISN :</th>
                            <td>{{ $get['nisn'] }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Nama Peserta :</th>
                            <td>{{ $get['nama_peserta'] }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Program Studi :</th>
                            <td>{{ $get['prodi'] }}</td>
                        </tr>
                        <tr>
                            <th class="text-right">Jalur :</th>
                            <td>{{ $get['jalur'] }}</td>
                        </tr>
                    </table>
                    <br>
                    <div class="form-group rounded">
                        <label for=""><b>E-Mail Konfirmasi:</b></label>
                        <input type="text" wire:model="email"
                            class="form-control form-control-lg @error('email') form-control-danger @enderror"
                            placeholder="Masukkan E-Mail Konfirmasi Anda" autofocus>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="alert bg-warning p-2" style="color:#000">
                        <i class="fa fa-exclamation-circle"></i> <b>Penting!</b><br />
                        <small style="font-size:90%">
                            Kami merekomendasikan Anda untuk menggunakan <u class="text-danger">Gmail</u>, dan
                            pastikan email yang diketikkan sudah benar dan
                            <u class="text-danger">masih aktif</u>
                            agar proses pengiriman informasi akun tidak terkendala.
                        </small>
                    </div>

                    <div class="row m-t-30 mb-2">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="button" wire:click="back('1')"
                                        class="btn btn-default btn-md btn-block waves-effect waves-light text-center">
                                        <i class="fa fa-arrow-circle-left"></i> Kembali
                                    </button>
                                </div>
                                <div class="col-md-6">
                                    <div class="text-center">
                                        <button type="submit"
                                            class="btn btn-primary btn-md btn-block waves-effect waves-light text-center"
                                            wire:loading.attr="disabled" wire:target="confirmReg">
                                            <span wire:loading.remove wire.target="confirmReg">
                                                <i class="fa fa-send"></i> Konfirmasi
                                            </span>
                                            <span wire:loading wire.target="confirmReg">
                                                <span class="spinner-border spinner-border-sm" role="status"
                                                    aria-hidden="true"></span>
                                                Waiting...
                                            </span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div class="border border-primary rounded p-2 text-center mb-2">
                                <span style="color:#000">Sudah punya akun?</span> <a href="{{ route('auth.login') }}"
                                    class="text-primary" style="font-size:12px">Login disini</a> <br>
                            </div>
                            <div class="border border-danger rounded p-2 text-center">
                                <a href="{{ route('frontend.beranda') }}" class="text-danger"
                                    style="font-size:12px">Kembali
                                    ke Halaman
                                    Utama</a>
                            </div>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
