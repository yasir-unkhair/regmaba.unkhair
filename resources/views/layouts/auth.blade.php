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
        <title>Login Sistem - {{ $nama_sub_aplikasi }}</title>
        <!-- HTML5 Shim and Respond.js IE10 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 10]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
      <![endif]-->
        <!-- Meta -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="{{ $nama_aplikasi }}" />
        <meta name="keywords" content="{{ $nama_aplikasi }}" />
        <meta name="author" content="{{ $author }}" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Favicon icon -->

        <link rel="icon" href="{{ asset('images') }}/{{ $logo }}" type="image/x-icon">
        <!-- Google font-->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
        <!-- Required Fremwork -->
        <link rel="stylesheet" type="text/css" href="{{ asset('mega-able-lite') }}/css/bootstrap/css/bootstrap.min.css">
        <!-- waves.css -->
        <link rel="stylesheet" href="{{ asset('mega-able-lite') }}/pages/waves/css/waves.min.css" type="text/css"
            media="all">
        <!-- themify-icons line icon -->
        <link rel="stylesheet" type="text/css"
            href="{{ asset('mega-able-lite') }}/icon/themify-icons/themify-icons.css">
        <!-- ico font -->
        <link rel="stylesheet" type="text/css" href="{{ asset('mega-able-lite') }}/icon/icofont/css/icofont.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" type="text/css"
            href="{{ asset('mega-able-lite') }}/icon/font-awesome/css/font-awesome.min.css">
        <!-- Style.css -->
        <link rel="stylesheet" type="text/css" href="{{ asset('mega-able-lite') }}/css/style.css">

        <link href=" https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.min.css " rel="stylesheet">

        @stack('style')

        <style>
            img {
                max-width: 100%;
            }

            .logo-icon {
                width: 20%;
            }

            @media only screen and (max-width: 600px) {
                .logo-icon {
                    width: 20%;
                }
            }
        </style>
    </head>

    <body themebg-pattern="theme1">
        <!-- Pre-loader start -->
        <div class="theme-loader">
            <div class="loader-track">
                <div class="preloader-wrapper">
                    <div class="spinner-layer spinner-blue">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                    <div class="spinner-layer spinner-red">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-yellow">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>

                    <div class="spinner-layer spinner-green">
                        <div class="circle-clipper left">
                            <div class="circle"></div>
                        </div>
                        <div class="gap-patch">
                            <div class="circle"></div>
                        </div>
                        <div class="circle-clipper right">
                            <div class="circle"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Pre-loader end -->

        <section class="login-block">
            <!-- Container-fluid starts -->
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- Authentication card start -->
                        <h1 class="text-center" style="color:#FFF"><b>{{ $nama_aplikasi }}</b></h1>
                        <div class="auth-box card">
                            <div class="card-block">
                                @yield('content')
                            </div>
                        </div>
                        <!-- end of form -->
                    </div>
                    <!-- end of col-sm-12 -->
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container-fluid -->
        </section>
        <!-- Warning Section Starts -->
        <!-- Older IE warning message -->
        <!-- Warning Section Ends -->
        <!-- Required Jquery -->
        <script type="text/javascript" src="{{ asset('mega-able-lite') }}/js/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="{{ asset('mega-able-lite') }}/js/jquery-ui/jquery-ui.min.js "></script>
        <script type="text/javascript" src="{{ asset('mega-able-lite') }}/js/popper.js/popper.min.js"></script>
        <script type="text/javascript" src="{{ asset('mega-able-lite') }}/js/bootstrap/js/bootstrap.min.js "></script>
        <!-- waves js -->
        <script src="{{ asset('mega-able-lite') }}/pages/waves/js/waves.min.js"></script>
        <!-- jquery slimscroll js -->
        <script type="text/javascript" src="{{ asset('mega-able-lite') }}/js/jquery-slimscroll/jquery.slimscroll.js "></script>
        <!-- modernizr js -->
        <script type="text/javascript" src="{{ asset('mega-able-lite') }}/js/SmoothScroll.js"></script>
        <script src="{{ asset('mega-able-lite') }}/js/jquery.mCustomScrollbar.concat.min.js "></script>

        <!-- i18next.min.js -->
        <script type="text/javascript" src="{{ asset('mega-able-lite') }}/js/common-pages.js"></script>

        <script src=" https://cdn.jsdelivr.net/npm/sweetalert2@11.14.4/dist/sweetalert2.all.min.js "></script>

        @stack('script')

        <!-- Sweet Alert Plugin Js -->
        @include('sweetalert::alert')

        <script>
            function upperCaseFirst(str) {
                return str.charAt(0).toUpperCase() + str.substring(1);
            }

            window.addEventListener('livewire:init', event => {
                Livewire.on('alert', (event) => {
                    Swal.fire({
                        icon: event.type,
                        title: upperCaseFirst(event.type),
                        text: event.message
                    });
                });
            });
        </script>

    </body>

</html>
