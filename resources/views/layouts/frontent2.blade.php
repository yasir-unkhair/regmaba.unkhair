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

        <!-- Favicons -->
        <link href="{{ asset('images/' . $logo) }}" rel="icon">
        <link href="{{ asset('images/' . $logo) }}" rel="apple-touch-icon">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com" rel="preconnect">
        <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
        <link
            href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">

        <!-- Vendor CSS Files -->
        <link href="{{ asset('flexstart') }}/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="{{ asset('flexstart') }}/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
        <link href="{{ asset('flexstart') }}/vendor/aos/aos.css" rel="stylesheet">
        <link href="{{ asset('flexstart') }}/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
        <link href="{{ asset('flexstart') }}/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

        <!-- Main CSS File -->
        <link href="{{ asset('flexstart') }}/css/main.css" rel="stylesheet">
    </head>

    <body class="index-page">

        <header id="header" class="header d-flex align-items-center fixed-top">
            <div class="container-fluid container-xl position-relative d-flex align-items-center">

                <a href="#" class="logo d-flex align-items-center me-auto">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <img src="{{ asset('images/' . $logo) }}" alt="">
                    <h1 class="sitename mt-2">UKT UNKHAIR</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="#hero" class="active">Home<br></a></li>
                        <li><a href="#kategoriukt">Kategori UKT</a></li>
                        <li><a href="#download">Download</a></li>
                        <li><a href="#contact">Kontak</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>
                <a class="btn-getstarted flex-md-shrink-0" href="{{ route('auth.login') }}">Login</a>
            </div>
        </header>

        <main class="main">

            <!-- Hero Section -->
            <section id="hero" class="hero section">

                <div class="container">
                    <div class="row gy-4">
                        <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
                            <h1 data-aos="fade-up">Haii, Selamat Datang</h1>
                            <p data-aos="fade-up" data-aos-delay="100">
                                Di {{ $nama_sub_aplikasi }} {{ $nama_departemen }}
                            </p>
                            <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
                                <a href="{{ route('auth.login') }}" class="btn btn-lg btn-success mr-2">Login <i
                                        class="bi bi-arrow-right"></i></a> &nbsp;&nbsp;
                                <a href="" class="btn btn-lg btn-warning text-light ml-2">Registrasi <i
                                        class="bi bi-arrow-right"></i></a>
                                <a href="https://www.youtube.com/watch?v=Y7f98aduVJ8"
                                    class="glightbox btn-watch-video d-flex align-items-center justify-content-center ms-0 ms-md-4 mt-4 mt-md-0"><i
                                        class="bi bi-play-circle"></i><span>Video Panduan</span></a>
                            </div>
                        </div>
                        <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
                            <img src="{{ asset('flexstart') }}/img/hero-img.png" class="img-fluid animated"
                                alt="">
                        </div>
                    </div>
                </div>

            </section><!-- /Hero Section -->

            {{-- 
            <!-- Recent Posts Section -->
            <section id="recent-posts" class="recent-posts section">

                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>Recent Posts</h2>
                    <p>Informasi Terkini</p>
                </div><!-- End Section Title -->

                <div class="container">

                    <div class="row gy-5">

                        <div class="col-xl-4 col-md-6">
                            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

                                <div class="post-img position-relative overflow-hidden">
                                    <img src="{{ asset('flexstart') }}/img/blog/blog-1.jpg" class="img-fluid"
                                        alt="">
                                    <span class="post-date">December 12</span>
                                </div>

                                <div class="post-content d-flex flex-column">

                                    <h3 class="post-title">Eum ad dolor et. Autem aut fugiat debitis</h3>

                                    <div class="meta d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person"></i> <span class="ps-2">Julia Parker</span>
                                        </div>
                                        <span class="px-3 text-black-50">/</span>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-folder2"></i> <span class="ps-2">Politics</span>
                                        </div>
                                    </div>

                                    <hr>

                                    <a href="blog-details.html" class="readmore stretched-link"><span>Read
                                            More</span><i class="bi bi-arrow-right"></i></a>

                                </div>

                            </div>
                        </div><!-- End post item -->

                        <div class="col-xl-4 col-md-6">
                            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="200">

                                <div class="post-img position-relative overflow-hidden">
                                    <img src="{{ asset('flexstart') }}/img/blog/blog-2.jpg" class="img-fluid"
                                        alt="">
                                    <span class="post-date">July 17</span>
                                </div>

                                <div class="post-content d-flex flex-column">

                                    <h3 class="post-title">Et repellendus molestiae qui est sed omnis</h3>

                                    <div class="meta d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person"></i> <span class="ps-2">Mario Douglas</span>
                                        </div>
                                        <span class="px-3 text-black-50">/</span>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-folder2"></i> <span class="ps-2">Sports</span>
                                        </div>
                                    </div>

                                    <hr>

                                    <a href="blog-details.html" class="readmore stretched-link"><span>Read
                                            More</span><i class="bi bi-arrow-right"></i></a>

                                </div>

                            </div>
                        </div><!-- End post item -->

                        <div class="col-xl-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                            <div class="post-item position-relative h-100">

                                <div class="post-img position-relative overflow-hidden">
                                    <img src="{{ asset('flexstart') }}/img/blog/blog-3.jpg" class="img-fluid"
                                        alt="">
                                    <span class="post-date">September 05</span>
                                </div>

                                <div class="post-content d-flex flex-column">

                                    <h3 class="post-title">Quia assumenda est et veritati tirana ploder</h3>

                                    <div class="meta d-flex align-items-center">
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-person"></i> <span class="ps-2">Lisa Hunter</span>
                                        </div>
                                        <span class="px-3 text-black-50">/</span>
                                        <div class="d-flex align-items-center">
                                            <i class="bi bi-folder2"></i> <span class="ps-2">Economics</span>
                                        </div>
                                    </div>

                                    <hr>

                                    <a href="blog-details.html" class="readmore stretched-link"><span>Read
                                            More</span><i class="bi bi-arrow-right"></i></a>

                                </div>

                            </div>
                        </div><!-- End post item -->

                    </div>

                </div>

            </section><!-- /Recent Posts Section -->


            <!-- Faq Section -->
            <section id="faq" class="faq section">

                <!-- Section Title -->
                <div class="container section-title" data-aos="fade-up">
                    <h2>F.A.Q</h2>
                    <p>Frequently Asked Questions</p>
                </div><!-- End Section Title -->

                <div class="container">

                    <div class="row">

                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="100">

                            <div class="faq-container">

                                <div class="faq-item faq-active">
                                    <h3>Non consectetur a erat nam at lectus urna duis?</h3>
                                    <div class="faq-content">
                                        <p>Feugiat pretium nibh ipsum consequat. Tempus iaculis urna id volutpat lacus
                                            laoreet non curabitur
                                            gravida. Venenatis lectus magna fringilla urna porttitor rhoncus dolor purus
                                            non.</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->

                                <div class="faq-item">
                                    <h3>Feugiat scelerisque varius morbi enim nunc faucibus a pellentesque?</h3>
                                    <div class="faq-content">
                                        <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                            interdum velit laoreet
                                            id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec
                                            pretium. Est pellentesque
                                            elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa
                                            tincidunt dui.</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->

                                <div class="faq-item">
                                    <h3>Dolor sit amet consectetur adipiscing elit pellentesque?</h3>
                                    <div class="faq-content">
                                        <p>Eleifend mi in nulla posuere sollicitudin aliquam ultrices sagittis orci.
                                            Faucibus pulvinar
                                            elementum integer enim. Sem nulla pharetra diam sit amet nisl suscipit.
                                            Rutrum tellus pellentesque
                                            eu tincidunt. Lectus urna duis convallis convallis tellus. Urna molestie at
                                            elementum eu facilisis
                                            sed odio morbi quis</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->

                            </div>

                        </div><!-- End Faq Column-->

                        <div class="col-lg-6" data-aos="fade-up" data-aos-delay="200">

                            <div class="faq-container">

                                <div class="faq-item">
                                    <h3>Ac odio tempor orci dapibus. Aliquam eleifend mi in nulla?</h3>
                                    <div class="faq-content">
                                        <p>Dolor sit amet consectetur adipiscing elit pellentesque habitant morbi. Id
                                            interdum velit laoreet
                                            id donec ultrices. Fringilla phasellus faucibus scelerisque eleifend donec
                                            pretium. Est pellentesque
                                            elit ullamcorper dignissim. Mauris ultrices eros in cursus turpis massa
                                            tincidunt dui.</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->

                                <div class="faq-item">
                                    <h3>Tempus quam pellentesque nec nam aliquam sem et tortor consequat?</h3>
                                    <div class="faq-content">
                                        <p>Molestie a iaculis at erat pellentesque adipiscing commodo. Dignissim
                                            suspendisse in est ante in.
                                            Nunc vel risus commodo viverra maecenas accumsan. Sit amet nisl suscipit
                                            adipiscing bibendum est.
                                            Purus gravida quis blandit turpis cursus in</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->

                                <div class="faq-item">
                                    <h3>Perspiciatis quod quo quos nulla quo illum ullam?</h3>
                                    <div class="faq-content">
                                        <p>Enim ea facilis quaerat voluptas quidem et dolorem. Quis et consequatur non
                                            sed in suscipit sequi.
                                            Distinctio ipsam dolore et.</p>
                                    </div>
                                    <i class="faq-toggle bi bi-chevron-right"></i>
                                </div><!-- End Faq item-->

                            </div>

                        </div><!-- End Faq Column-->

                    </div>

                </div>

            </section><!-- /Faq Section --> --}}

        </main>

        <footer id="footer" class="footer">

            <div class="container text-center mt-4">
                <p>
                    {{ date('Y') }} &copy; Copyright <strong><span>{{ $author }}</span></strong>.
                    {{ $nama_departemen }}
                </p>
                <div class="credits">
                    Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
                </div>
            </div>

        </footer>

        <!-- Scroll Top -->
        <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
                class="bi bi-arrow-up-short"></i></a>

        <!-- Vendor JS Files -->
        <script src="{{ asset('flexstart') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="{{ asset('flexstart') }}/vendor/php-email-form/validate.js"></script>
        <script src="{{ asset('flexstart') }}/vendor/aos/aos.js"></script>
        <script src="{{ asset('flexstart') }}/vendor/glightbox/js/glightbox.min.js"></script>
        <script src="{{ asset('flexstart') }}/vendor/purecounter/purecounter_vanilla.js"></script>
        <script src="{{ asset('flexstart') }}/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
        <script src="{{ asset('flexstart') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
        <script src="{{ asset('flexstart') }}/vendor/swiper/swiper-bundle.min.js"></script>

        <!-- Main JS File -->
        <script src="{{ asset('flexstart') }}/js/main.js"></script>

    </body>

</html>
