<!DOCTYPE html>
<html lang="en">

    @php
        $pengaturan = pengaturan();
        $nama_sub_aplikasi = $pengaturan['nama-sub-aplikasi'];
        $nama_departemen = $pengaturan['nama-departemen'];
        $author = $pengaturan['author'];
        $logo = $pengaturan['logo'];
        $nama_aplikasi = $pengaturan['nama-aplikasi'];

        $alamat = $pengaturan['alamat'];
        $telepon = $pengaturan['telepon'];
        $email = $pengaturan['email'];
    @endphp

    <head>
        <meta charset="utf-8">
        <meta content="width=device-width, initial-scale=1.0" name="viewport">

        <title>{{ $nama_sub_aplikasi }} - {{ $nama_departemen }}</title>
        <meta name="description" content="{{ $nama_sub_aplikasi }} - {{ $nama_departemen }}" />
        <meta name="keywords" content="">
        <meta name="author" content="{{ $author }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon icon -->

        <link rel="icon" href="{{ asset('images/' . $logo) }}" type="image/x-icon">

        <!-- Google Fonts -->
        <link
            href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,700,700i&display=swap"
            rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('moderna') }}/vendor/animate.css/animate.min.css" rel="stylesheet">
        <link href="{{ asset('moderna') }}/vendor/aos/aos.css" rel="stylesheet">
        <link href="{{ asset('moderna') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('moderna') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="{{ asset('moderna') }}/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
        <link href="{{ asset('moderna') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="{{ asset('moderna') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

        <!-- Template Main CSS File -->
        <link href="{{ asset('moderna') }}/css/style.css" rel="stylesheet">

        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.3/css/dataTables.dataTables.min.css" />

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials-theme-flat.css" />

        <!-- =======================================================
  * Template Name: Moderna
  * Updated: Sep 18 2023 with Bootstrap v5.3.2
  * Template URL: https://bootstrapmade.com/free-bootstrap-template-corporate-moderna/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
    </head>

    <body>

        <!-- ======= Header ======= -->
        <header id="header" class="fixed-top header-transparent">
            <div class="container d-flex justify-content-between">
                <div class="logo float-left">
                    <span class="text-light">
                        <h1>
                            <img src="{{ asset('images/' . $logo) }}" alt="" class="img-fluid">
                            {{ $nama_aplikasi }}
                        </h1>
                    </span>
                </div>

                <nav id="navbar" class="navbar">
                    <ul>
                        <li>
                            <a class="{{ request()->is('/') || request()->is('beranda') ? 'active' : '' }}"
                                href="{{ route('frontend.beranda') }}">Beranda</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('frontend.download') ? 'active' : '' }}"
                                href="{{ route('frontend.download') }}">Download</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('frontend.kategoriukt') ? 'active' : '' }}"
                                href="{{ route('frontend.kategoriukt') }}">Kategori UKT</a>
                        </li>
                        <li>
                            <a class="{{ request()->routeIs('frontend.kontak') ? 'active' : '' }}"
                                href="{{ route('frontend.kontak') }}">Kontak</a>
                        </li>
                    </ul>
                    <i class="bi bi-list mobile-nav-toggle"></i>
                </nav><!-- .navbar -->

            </div>
        </header><!-- End Header -->

        @if (request()->routeIs('frontend.site') || request()->routeIs('frontend.beranda'))
            <!-- ======= Hero Section ======= -->
            <section id="hero-no-slider" class="d-flex justify-cntent-center align-items-center">
                <div class="container position-relative" data-aos="fade-up" data-aos-delay="100">
                    <div class="row justify-content-center">
                        <div class="col-xl-12">
                            <h2>Selamat Datang di {{ $nama_sub_aplikasi }} <br> {{ $nama_departemen }}</h2>
                            <a href="" class="btn-get-started bg-success animate__animated animate__fadeInUp"><i
                                    class="fa fa-user-plus"></i>
                                Registrasi</a>
                            <a href="" class="btn-get-started bg-primary animate__animated animate__fadeInUp"><i
                                    class="fa fa-sign-in"></i>
                                Login</a>
                        </div>
                    </div>
                </div>
            </section><!-- End Hero -->
        @endif

        <main id="main">

            @yield('breadcrumbs')

            @yield('content')

        </main><!-- End #main -->

        <!-- ======= Footer ======= -->
        <!-- ======= Footer ======= -->
        <footer id="footer" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">

            <div class="footer-top">
                <div class="container">
                    <div class="row">

                        <div class="col-lg-4 col-md-8 footer-links">
                            <h4>Menu Utama</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a
                                        href="{{ route('frontend.beranda') }}">Beranda</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a
                                        href="{{ route('frontend.download') }}">Download</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="">Registrasi</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="">Login</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-4 col-md-8 footer-links">
                            <h4>Link Terkait</h4>
                            <ul>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Website Unkhair</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">SIMAK</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">VirtualClass</a></li>
                                <li><i class="bx bx-chevron-right"></i> <a href="#">Permata</a></li>
                            </ul>
                        </div>

                        <div class="col-lg-4 col-md-8 footer-contact">
                            <h4>Kontak Kami</h4>
                            <p>
                                {{ $alamat }}<br>
                                <strong>Phone:</strong> {{ $telepon }}<br>
                                <strong>Email:</strong> {{ $email }}<br>
                            </p>
                            <div class="social-links mt-3">
                                <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
                                <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
                                <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <div class="container">
                <div class="copyright">
                    {{ date('Y') }} &copy; Copyright <strong><span>{{ $author }}</span></strong>.
                    {{ $nama_departemen }}
                </div>
            </div>
        </footer><!-- End Footer -->
        <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        <!-- jQuery -->
        <script src="{{ asset('adminlte3') }}/plugins/jquery/jquery.min.js"></script>

        <!-- Vendor JS Files -->
        <script src="{{ asset('moderna') }}/vendor/purecounter/purecounter_vanilla.js"></script>
        <script src="{{ asset('moderna') }}/vendor/aos/aos.js"></script>
        <script src="{{ asset('moderna') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('moderna') }}/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="{{ asset('moderna') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="{{ asset('moderna') }}/vendor/swiper/swiper-bundle.min.js"></script>
        <script src="{{ asset('moderna') }}/vendor/waypoints/noframework.waypoints.js"></script>

        <!-- Template Main JS File -->
        <script src="{{ asset('moderna') }}/js/main.js"></script>

        {{-- @notifyJs --}}

        <script src="https://cdn.datatables.net/2.0.3/js/dataTables.min.js"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jsSocials/1.5.0/jssocials.js"></script>
        <script>
            $(document).ready(function() {
                $('#display').DataTable();

                $(".sharePopup").jsSocials({
                    showCount: true,
                    showLabel: true,
                    shareIn: "popup",
                    shares: [{
                            share: "twitter",
                            label: "Twitter"
                        },
                        {
                            share: "whatsapp",
                            label: "Whatsapp"
                        },
                        {
                            share: "facebook",
                            label: "Facebook"
                        },
                        {
                            share: "googleplus",
                            label: "Google+"
                        }
                    ]
                });
            });
        </script>

    </body>

</html>
