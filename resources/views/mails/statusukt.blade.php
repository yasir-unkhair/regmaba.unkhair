<!DOCTYPE html>
<html lang="en">
    @php
        $pengaturan = pengaturan();
        $nama_aplikasi = $pengaturan['nama-aplikasi'];
        $nama_sub_aplikasi = $pengaturan['nama-sub-aplikasi'];
        $nama_departemen = $pengaturan['nama-departemen'];
        $author = $pengaturan['author'];
        $logo = $pengaturan['logo'];
        $alamat = $pengaturan['alamat'];
        $telepon = $pengaturan['telepon'];
        $email = $pengaturan['email'];
    @endphp

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>{{ $nama_sub_aplikasi }} - {{ $nama_departemen }}</title>
        <!-- Styles -->
        <style>
            /* Base */
            body,
            body *:not(html):not(style):not(br):not(tr):not(code) {
                font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
                box-sizing: border-box;
            }

            body {
                background-color: #f8fafc;
                color: #74787e;
                height: 100%;
                hyphens: auto;
                line-height: 1.4;
                margin: 0;
                -moz-hyphens: auto;
                -ms-word-break: break-all;
                width: 100% !important;
                -webkit-hyphens: auto;
                -webkit-text-size-adjust: none;
                word-break: break-all;
                word-break: break-word;
            }

            p,
            ul,
            ol,
            blockquote {
                line-height: 1.4;
                text-align: left;
            }

            a {
                color: #3869d4;
            }

            a img {
                border: none;
            }

            /* Typography */
            h1 {
                color: #3d4852;
                font-size: 19px;
                font-weight: bold;
                margin-top: 0;
                text-align: left;
            }

            h2 {
                color: #3d4852;
                font-size: 16px;
                font-weight: bold;
                margin-top: 0;
                text-align: left;
            }

            h3 {
                color: #3d4852;
                font-size: 14px;
                font-weight: bold;
                margin-top: 0;
                text-align: left;
            }

            p {
                color: #3d4852;
                font-size: 16px;
                line-height: 1.5em;
                margin-top: 0;
                text-align: left;
            }

            p.sub {
                font-size: 12px;
            }

            img {
                max-width: 100%;
            }

            /* Layout */
            .wrapper {
                background-color: #f8fafc;
                margin: 0;
                padding: 0;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }

            .content {
                margin: 0;
                padding: 0;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }

            /* Header */
            .header {
                padding: 25px 0;
                text-align: center;
            }

            .header a {
                color: #3d4852;
                font-size: 23px;
                font-weight: bold;
                text-decoration: none;
                text-shadow: 0 1px 0 white;
            }

            /* Body */
            .body {
                background-color: #ffffff;
                border-bottom: 1px solid #edeff2;
                border-top: 1px solid #edeff2;
                margin: 0;
                padding: 0;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }

            .inner-body {
                background-color: #ffffff;
                margin: 0 auto;
                padding: 0;
                width: 570px;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 570px;
            }

            /* Subcopy */
            .subcopy {
                border-top: 1px solid #edeff2;
                margin-top: 25px;
                padding-top: 25px;
            }

            .subcopy p {
                font-size: 12px;
            }

            /* Footer */
            .footer {
                margin: 0 auto;
                padding: 0;
                text-align: center;
                width: 570px;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 570px;
            }

            .footer p {
                color: #aeaeae;
                font-size: 12px;
                text-align: center;
            }

            /* Tables */
            .table table {
                margin: 30px auto;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }

            .table th {
                border-bottom: 1px solid #edeff2;
                padding-bottom: 8px;
                margin: 0;
            }

            .table td {
                color: #74787e;
                font-size: 15px;
                line-height: 18px;
                padding: 10px 0;
                margin: 0;
            }

            .content-cell {
                padding: 35px;
            }

            /* Buttons */
            .action {
                margin: 30px auto;
                padding: 0;
                text-align: center;
                width: 100%;
                -premailer-cellpadding: 0;
                -premailer-cellspacing: 0;
                -premailer-width: 100%;
            }

            .button {
                border-radius: 3px;
                box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
                color: #fff !important;
                display: inline-block;
                text-decoration: none;
                -webkit-text-size-adjust: none;
            }

            .button-blue,
            .button-primary {
                background-color: #3490dc;
                border-top: 10px solid #3490dc;
                border-right: 18px solid #3490dc;
                border-bottom: 10px solid #3490dc;
                border-left: 18px solid #3490dc;
            }

            .logo-icon {
                width: 10%;
            }

            .account-content {
                padding: 0 10px 5px 10px;
            }

            .account-content th {
                width: 27%;
                font-size: 14px;
                font-weight: bold;
                text-align: left;
                vertical-align: top;
                white-space: nowrap;
            }

            .account-content td {
                color: #3d4852;
                font-size: 14px;
            }

            @media only screen and (max-width: 600px) {
                .inner-body {
                    width: 100% !important;
                }

                .footer {
                    width: 100% !important;
                }

                .logo-icon {
                    width: 23%;
                }

                .account-content th {
                    width: 40%;
                    white-space: normal;
                }
            }

            @media only screen and (max-width: 500px) {
                .button {
                    width: 100% !important;
                }
            }
        </style>
    </head>

    <body>
        {{-- @dd($peserta) --}}
        <table class='wrapper' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
            <tr>
                <td align='center'>
                    <table class='content' width='100%' cellpadding='0' cellspacing='0' role='presentation'>
                        <tr>
                            <td class='header'>
                                <a href="#">
                                    <img src="{{ $message->embed(public_path('images/unkhair.png')) }}"
                                        class="logo-icon" alt="logo"><br>
                                    {{ $nama_sub_aplikasi }} - {{ $nama_departemen }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td class='body' width='100%' cellpadding='0' cellspacing='0'>
                                <table class='inner-body' align='center' width='570' cellpadding='0' cellspacing='0'
                                    role='presentation'>
                                    <!-- Body content -->
                                    <tr>
                                        <td class='content-cell'>
                                            <h2>Hasil Penetapan UKT Anda:</h2>
                                            <table width='100%' class='account-content'>
                                                <tr>
                                                    <th>Nama Peserta</th>
                                                    <td>{{ $peserta->nama_peserta }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Program Studi</th>
                                                    <td>
                                                        {{ $peserta->prodi->jenjang_prodi }} -
                                                        {{ $peserta->prodi->nama_prodi }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Jalur</th>
                                                    <td>{{ $peserta->jalur }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Tahun</th>
                                                    <td>{{ $peserta->setup->tahun }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Kategori UKT</th>
                                                    <td style='white-space:nowrap'>
                                                        <b>{{ strtoupper($peserta->verifikasiberkas->vonis_ukt) ?? '' }}</b>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p>
                                                Anda dapat mengecek Status UKT serta Nominal melalui portal UKT UNKHAIR
                                            </p>
                                            <!-- Button Login -->
                                            <table class='action' align='center' width='100%' cellpadding='0'
                                                cellspacing='0' role='presentation'>
                                                <tr>
                                                    <td align='center'>
                                                        <table width='100%' b='' order='0' cellpadding='0'
                                                            cellspacing='0' role='presentation'>
                                                            <tr>
                                                                <td align="center">
                                                                    <a href='{{ route('auth.login') }}'
                                                                        class='button button-primary'
                                                                        target='_blank'>Login Aplikasi</a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p>
                                                Terima kasih, <br>{{ $nama_sub_aplikasi }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <table class='footer' align='center' width='570' cellpadding='0' cellspacing='0'
                                    role='presentation'>
                                    <tr>
                                        <td class='content-cell' align='center'>
                                            <p>
                                                &copy; {{ date('Y') }}
                                                {{ $nama_sub_aplikasi }} - {{ $nama_departemen }}.
                                            </p>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>

</html>
