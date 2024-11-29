<ul class="nav nav-pills nav-sidebar flex-column nav-flat" data-widget="treeview" role="menu" data-accordion="false">

    <li class="nav-header">MAIN MENU</li>
    @if (auth()->user()->hasRole(['developper', 'admin']) && in_array(session('role'), ['developper', 'admin']))
        <li class="nav-item {{ routeIs('admin.dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p> Dashboard</p>
            </a>
        </li>
        <li
            class="nav-item {{ routeIs(['admin.fakultas', 'admin.prodi.index', 'admin.prodi.biayastudi', 'admin.setup', 'admin.datapeserta.index', 'admin.datapeserta.upload', 'admin.roles', 'admin.pengguna', 'admin.pengguna.import', 'admin.referensi']) ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ routeIs(['admin.fakultas', 'admin.prodi.index', 'admin.prodi.biayastudi', 'admin.setup', 'admin.datapeserta.index', 'admin.datapeserta.upload', 'admin.roles', 'admin.pengguna', 'admin.pengguna.import', 'admin.referensi']) ? 'active' : '' }}">
                <i class="nav-icon fas fa-database"></i>
                <p> Sistem UKT <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.fakultas') }}"
                        class="nav-link {{ routeIs(['admin.fakultas']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true" style="font-size: 11px;"></i>
                        <p>Data Fakultas</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.prodi.index') }}"
                        class="nav-link {{ routeIs(['admin.prodi.index', 'admin.prodi.biayastudi']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true" style="font-size: 11px;"></i>
                        <p>Data Program Studi</p>
                    </a>
                </li>

                @if (session('role') == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('admin.setup') }}"
                            class="nav-link {{ routeIs(['admin.setup']) ? 'active' : '' }}">
                            <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                                style="font-size: 11px;"></i>
                            <p>Setup Penginputan</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.datapeserta.index') }}"
                            class="nav-link {{ routeIs(['admin.datapeserta.index', 'admin.datapeserta.upload']) ? 'active' : '' }}">
                            <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                                style="font-size: 11px;"></i>
                            <p>Data Peserta</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('admin.pengguna') }}"
                        class="nav-link {{ routeIs(['admin.pengguna', 'admin.pengguna.import']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true" style="font-size: 11px;"></i>
                        <p>Data Pengguna</p>
                    </a>
                </li>

                @if (session('role') == 'developper')
                    <li class="nav-item">
                        <a href="{{ route('admin.roles') }}"
                            class="nav-link {{ routeIs(['admin.roles']) ? 'active' : '' }}">
                            <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                                style="font-size: 11px;"></i>
                            <p>Role Pengguna</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.referensi') }}"
                            class="nav-link {{ routeIs(['admin.referensi']) ? 'active' : '' }}">
                            <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                                style="font-size: 11px;"></i>
                            <p>Referensi</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link {{ routeIs(['']) ? 'active' : '' }}">
                            <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                                style="font-size: 11px;"></i>
                            <p>Reset Data Sistem</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>
    @endif

    @if (auth()->user()->hasRole(['admin']) && in_array(session('role'), ['admin']))
        <li
            class="nav-item {{ routeIs(['admin.pesertaukt.index', 'admin.penetapanukt.index', 'admin.penetapanukt.listdokumen', 'admin.penetapanukt.laporan', 'admin.maba.index', 'admin.maba.generatenpm', 'admin.maba.generatenpm-params']) ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ routeIs(['admin.pesertaukt.index', 'admin.penetapanukt.index', 'admin.penetapanukt.listdokumen', 'admin.penetapanukt.laporan', 'admin.maba.index', 'admin.maba.generatenpm', 'admin.maba.generatenpm-params']) ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p> Kelola Peserta UKT <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.pesertaukt.index') }}"
                        class="nav-link {{ routeIs(['admin.pesertaukt.index']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true" style="font-size: 11px;"></i>
                        <p>Peserta UKT</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.penetapanukt.index') }}"
                        class="nav-link {{ routeIs(['admin.penetapanukt.index', 'admin.penetapanukt.listdokumen']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true" style="font-size: 11px;"></i>
                        <p>Penetapan UKT</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.penetapanukt.laporan') }}"
                        class="nav-link {{ routeIs(['admin.penetapanukt.laporan']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true" style="font-size: 11px;"></i>
                        <p>Laporan Peserta UKT</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.maba.index') }}"
                        class="nav-link {{ routeIs(['admin.maba.index']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true" style="font-size: 11px;"></i>
                        <p>Daftar Maba NPM</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.maba.generatenpm') }}"
                        class="nav-link {{ routeIs(['admin.maba.generatenpm', 'admin.maba.generatenpm-params']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true" style="font-size: 11px;"></i>
                        <p>Generate NPM</p>
                    </a>
                </li>
            </ul>
        </li>

        <li
            class="nav-item {{ routeIs(['admin.verifikator.index', 'admin.verifikator.penugasan', 'admin.verifikator.plotting', 'admin.verifikator.daftarpeserta']) ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ routeIs(['admin.verifikator.index', 'admin.verifikator.penugasan', 'admin.verifikator.plotting', 'admin.verifikator.daftarpeserta']) ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-secret"></i>
                <p> Verifikator UKT <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.verifikator.index') }}"
                        class="nav-link {{ routeIs(['admin.verifikator.index']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                            style="font-size: 11px;"></i>
                        <p>Daftar Verifikator</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.verifikator.penugasan') }}"
                        class="nav-link {{ routeIs(['admin.verifikator.penugasan', 'admin.verifikator.plotting', 'admin.verifikator.daftarpeserta']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                            style="font-size: 11px;"></i>
                        <p>Penugasan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="" class="nav-link {{ routeIs(['']) ? 'active' : '' }}">
                        <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                            style="font-size: 11px;"></i>
                        <p>Laporan</p>
                    </a>
                </li>
            </ul>
        </li>
    @endif

    @if (auth()->user()->hasRole(['verifikator']) && in_array(session('role'), ['verifikator']))
        <li class="nav-item {{ routeIs('verifikator.dashboard') ? 'active' : '' }}">
            <a href="{{ route('verifikator.dashboard') }}"
                class="nav-link {{ routeIs('verifikator.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p> Dashboard</p>
            </a>
        </li>
        <li
            class="nav-item {{ routeIs(['verifikator.pesertaukt.index', 'verifikator.pesertaukt.listdokumen']) ? 'active' : '' }}">
            <a href="{{ route('verifikator.pesertaukt.index') }}"
                class="nav-link {{ routeIs(['verifikator.pesertaukt.index', 'verifikator.pesertaukt.listdokumen']) ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Daftar Peserta UKT</p>
            </a>
        </li>

        <li class="nav-item {{ routeIs('verifikator.pesertaukt.laporan') ? 'active' : '' }}">
            <a href="{{ route('verifikator.pesertaukt.laporan') }}"
                class="nav-link {{ routeIs('verifikator.pesertaukt.laporan') ? 'active' : '' }}">
                <i class="nav-icon fas fa-book"></i>
                <p>Laporan</p>
            </a>
        </li>
    @endif

    @if (auth()->user()->hasRole(['peserta']) && in_array(session('role'), ['peserta']))
        @php
            $get_status = auth()->user()->status_peserta();
            $akses_formulir = auth()->user()->akses_formulirukt();
        @endphp

        {{-- @dump($get_status, $akses_formulir) --}}

        <li class="nav-item {{ routeIs('peserta.dashboard') ? 'active' : '' }}">
            <a href="{{ route('peserta.dashboard') }}"
                class="nav-link {{ routeIs('peserta.dashboard') ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p> Dashboard</p>
            </a>
        </li>

        @if (in_array($get_status, [null, 1, 2]) && $akses_formulir)
            <li class="nav-item menu-open">
                <a href="#"
                    class="nav-link {{ routeIs(['peserta.datadiri', 'peserta.kondisikeluarga', 'peserta.pembiayaanstudi']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-book"></i>
                    <p> Formulir UKT <i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('peserta.datadiri') }}"
                            class="nav-link {{ routeIs(['peserta.datadiri']) ? 'active' : '' }}">
                            <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                                style="font-size: 11px;"></i>
                            <p>Data Diri</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('peserta.kondisikeluarga') }}"
                            class="nav-link {{ routeIs(['peserta.kondisikeluarga']) ? 'active' : '' }}">
                            <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                                style="font-size: 11px;"></i>
                            <p>Kondisi Keluarga</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('peserta.pembiayaanstudi') }}"
                            class="nav-link {{ routeIs(['peserta.pembiayaanstudi']) ? 'active' : '' }}">
                            <i class="fas fa-angle-double-right nav-icon" aria-hidden="true"
                                style="font-size: 11px;"></i>
                            <p>Pembiayaan Studi</p>
                        </a>
                    </li>
                </ul>
            </li>

            @if (auth()->user()->formulirukt_selesai_input())
                <li class="nav-item {{ routeIs(['peserta.cetak.formulirukt']) ? 'active' : '' }}">
                    <a href="{{ route('peserta.cetak.formulirukt') }}"
                        class="nav-link {{ routeIs(['peserta.cetak.formulirukt']) ? 'active' : '' }}">
                        <i class="nav-icon fas fa-print"></i>
                        <p> Cetak Formulir UKT</p>
                    </a>
                </li>
            @endif

            <li class="nav-item {{ routeIs(['peserta.berkasdukung']) ? 'active' : '' }}">
                <a href="{{ route('peserta.berkasdukung') }}"
                    class="nav-link {{ routeIs(['peserta.berkasdukung']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-upload"></i>
                    <p> Upload Berkas Dukung</p>
                </a>
            </li>

            <li class="nav-item {{ routeIs(['peserta.finalisasi']) ? 'active' : '' }}">
                <a href="{{ route('peserta.finalisasi') }}"
                    class="nav-link {{ routeIs(['peserta.finalisasi']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-flag"></i>
                    <p> Finalisasi</p>
                </a>
            </li>
        @endif

        @if (in_array($get_status, [3, 4, 5]))
            <li class="nav-item {{ routeIs(['peserta.resume']) ? 'active' : '' }}">
                <a href="{{ route('peserta.resume') }}"
                    class="nav-link {{ routeIs(['peserta.resume']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-address-card"></i>
                    <p> Resume Pengajuan</p>
                </a>
            </li>
        @endif

        <!-- menu status ukt akan muncul jika sudah di vonis -->
        @if ($get_status == 5)
            <li class="nav-item {{ routeIs(['peserta.statusukt']) ? 'active' : '' }}">
                <a href="{{ route('peserta.statusukt') }}"
                    class="nav-link {{ routeIs(['peserta.statusukt']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-id-card"></i>
                    <p> Status UKT</p>
                </a>
            </li>

            <li class="nav-item {{ routeIs(['peserta.pembayaran', 'peserta.pembayaran.detail']) ? 'active' : '' }}">
                <a href="{{ route('peserta.pembayaran') }}"
                    class="nav-link {{ routeIs(['peserta.pembayaran', 'peserta.pembayaran.detail']) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-money"></i>
                    <p> Pembayaran</p>
                </a>
            </li>
        @endif
    @endif

    <livewire:Auth.Logout tampilan="logout1">
</ul>
