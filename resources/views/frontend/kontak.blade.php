@extends('layouts.frontend')

@section('breadcrumbs')
<!-- ======= Blog Section ======= -->
<section class="breadcrumbs">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h2>Kontak</h2>
            <ol>
                <li><a href="{{ route('frontend.beranda') }}">Beranda</a></li>
                <li>Kontak</li>
            </ol>
        </div>
    </div>
</section><!-- End Blog Section -->
@endsection

@section('content')
<!-- ======= Map Section ======= -->
<section class="map mt-2">
    <div class="container-fluid p-0">
        <iframe
            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1994.7318817607181!2d127.33422999883143!3d0.7638484631699577!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x329cb4f340000001%3A0x688b5edfd183b897!2sRektorat%20Universitas%20Khairun!5e0!3m2!1sid!2sid!4v1686527761464!5m2!1sid!2sid"
            frameborder="0" style="border:0;" allowfullscreen=""></iframe>
    </div>
</section><!-- End Map Section -->

@php
    $pengaturan = pengaturan();
@endphp

<section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-md-12">
                        <div class="info-box">
                            <i class="bx bx-map"></i>
                            <h3>Our Address</h3>
                            <p>{{ $pengaturan['alamat'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="bx bx-envelope"></i>
                            <h3>Email Us</h3>
                            <p>{{ $pengaturan['email'] }}</p>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="info-box">
                            <i class="bx bx-phone-call"></i>
                            <h3>Call Us</h3>
                            <p>{{ $pengaturan['telepon'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End Contact Section -->
@endsection