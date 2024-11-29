@extends('layouts.frontend')

@section('breadcrumbs')
    <!-- ======= Blog Section ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Informasi</h2>
          <ol>
            <li><a href="{{ route('frontend.beranda') }}">Beranda</a></li>
            <li>Informasi</li>
          </ol>
        </div>
      </div>
    </section><!-- End Blog Section -->
@endsection

@section('content')
    <!-- ======= Blog Section ======= -->
    <section class="blog" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
      <div class="container">

        <div class="row">
          <div class="col-lg-8 entries">

            <article class="entry entry-single">
                <div class="entry-img">
                    <img src="{{ asset($get->banner->url_berkas) }}" alt="Logo" class="img-fluid">
                </div>

              <h2 class="entry-title">
                <a href="{{ route('frontend.informasi', $get->slug) }}">{{ $get->judul }}</a>
              </h2>

              <div class="entry-meta">
                <ul>
                  <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="#">{{ $get->user->name ?? '' }}</a></li>
                  <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><time datetime="{{ date('d M Y H:i', strtotime($get->created_at)) }}">{{ date('d M Y H:i', strtotime($get->created_at)) }}</time></a></li>
                </ul>
              </div>

              <div class="entry-content" style="text-align: justify;">
                <p>{!! $get->konten !!}</p>
              </div>

              <div class="entry-footer clearfix"></div>
              <div class="blog-icons">
                    <div class="blog-share_block">
                        <div class="pull-left">
                            <h5>Bagikan Ke:</h5>
                        </div>
                        <div class="sharePopup"></div>
                    </div>
                </div>
            </article><!-- End blog entry -->

        </div><!-- End blog entries list -->

          <div class="col-lg-4">
            <div class="sidebar">

              <h3 class="sidebar-title">Kategori</h3>
              <div class="sidebar-item categories">
                <ul>
                  @foreach ($kategori as $row)
                    <li>
                        <a href="{{ route('frontend.kategori', $row->slug) }}">{{ $row->kategori }} <span>({{ $row->postingan_count }})</span></a>
                    </li>
                  @endforeach
                </ul>

              </div><!-- End sidebar categories-->

              <h3 class="sidebar-title">Informasi Lainnya</h3>
              <div class="sidebar-item recent-posts">
                @foreach ($postingan as $row)
                  <div class="post-item clearfix">
                    <img src="{{ asset($row->banner->url_berkas ?? '') }}" alt="Logo">
                    <h4><a href="{{ route('frontend.informasi', $row->slug) }}">{{ Str::limit(strip_tags($row->judul), 50, '...') }}</a></h4>
                    <time datetime="{{ date('d M Y H:i', strtotime($row->created_at)) }}">{{ date('d M Y H:i', strtotime($row->created_at)) }}</time>
                  </div> 
                @endforeach
              </div><!-- End sidebar recent posts-->

            </div><!-- End sidebar -->
          </div><!-- End blog sidebar -->
        </div><!-- End row -->
      </div><!-- End container -->
    </section><!-- End Blog Section -->
@endsection