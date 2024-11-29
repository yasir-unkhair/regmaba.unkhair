@extends('layouts.frontend')

@section('content')
    <section class="service-details pt-0">
        <div class="container pt-0">
            <div class="section-title">
                <h2>Informasi Terkini</h2>
            </div>

            <div class="row">
                @foreach ($postingan as $row)
                    <div class="col-md-6 d-flex align-items-stretch" data-aos="fade-up">
                        <div class="card">
                            <div class="card-img">
                                <img src="{{ asset($row->banner->url_berkas ?? '') }}" alt="Logo">
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><a
                                        href="{{ route('frontend.informasi', $row->slug) }}">{{ strtoupper($row->judul) }}</a>
                                </h5>
                                <div style="color: #aaaaaa; font-size: 12px;">
                                    <span><i class="bi bi-person"></i> {{ $row->user->name ?? '' }}</span>
                                    &nbsp;&nbsp;&nbsp;
                                    <span><i class="bi bi-clock ml-3"></i><time datetime="2020-01-01">
                                            {{ date('d M Y H:i', strtotime($row->created_at)) }}</time></span>
                                </div>
                                <p class="card-text">
                                <p>{{ Str::limit(strip_tags_content($row->konten), 220, '...') }}</p>
                                <div class="read-more"><a href=""><i class="bi bi-arrow-right"></i> Read More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </section><!-- End Service Details Section -->

    <!-- ======= Video ======= -->
    <section class="features">
        <div class="container">
            <div class="section-title">
                <h2>Video Panduan</h2>
                <p>Panduan mendaftar dan melengkapi berkas UKT</p>
            </div>
            <div class="row" data-aos="fade-up">
                <div class="container pb-video-container">
                    <div class="col-lg-12">
                        <center>
                            <iframe width="560" height="315"
                                src="https://www.youtube.com/embed/307qpUN8ysA?si=gFu75xZqvPcJNajf"
                                title="YouTube video player" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Video -->
@endsection
