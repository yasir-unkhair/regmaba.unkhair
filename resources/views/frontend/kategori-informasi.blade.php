@extends('layouts.frontend')

@section('breadcrumbs')
    <!-- ======= Blog Section ======= -->
    <section class="breadcrumbs">
      <div class="container">
        <div class="d-flex justify-content-between align-items-center">
          <h2>Kategori - <span class="text-primary"><i>{{ $get->kategori }}</i></span></h2>
          <ol>
            <li><a href="{{ route('frontend.beranda') }}">Beranda</a></li>
            <li>Kategori</li>
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
                @foreach ($get->postingan()->where('publish', 1)->orderBy('created_at', 'DESC')->limit(10)->get() as $row)
                    <article class="entry entry-single">
                        <div class="entry-img">
                            <img src="{{ asset($row->banner->url_berkas ?? '') }}" alt="" style="width:1024px; height: 768px;" class="img-fluid">
                        </div>

                        <h2 class="entry-title">
                            <a href="{{ route('frontend.informasi', $row->slug) }}">{{ $row->judul }}</a>
                        </h2>

                        <div class="entry-meta">
                            <ul>
                            <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a href="#">{{ $row->user->name ?? '' }}</a></li>
                            <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="#"><time datetime="{{ date('d M Y H:i', strtotime($row->created_at)) }}">{{ date('d M Y H:i', strtotime($row->created_at)) }}</time></a></li>
                            <li class="d-flex align-items-center"><i class="bi bi-tags"></i> <a href="{{ route('frontend.kategori', $get->slug) }}">{{ $get->kategori ?? '' }}</a></li>
                            </ul>
                        </div>

                        <div class="entry-content">
                            <p>{{ Str::limit(strip_tags($row->konten), 250, '...') }}</p>
                            <div class="read-more">
                            <a href="{{ route('frontend.informasi', $row->slug) }}">Read More</a>
                            </div>
                        </div>
                    </article><!-- End blog entry -->    
                @endforeach
                
                @if ($get->postingan_count == 0)
                    <center><h4 class="text-danger">Informasi Tidak Ada!</h4></center>
                @endif
                {{-- <div class="blog-pagination">
                    <ul class="justify-content-center">
                        <li><a href="#">1</a></li>
                        <li class="active"><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                    </ul>
                </div> --}}
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