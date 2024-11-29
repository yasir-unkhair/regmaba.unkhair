@extends('layouts.frontend')

@section('breadcrumbs')
<!-- ======= Blog Section ======= -->
<section class="breadcrumbs">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center">
      <h2>Daftar Dosen</h2>
      <ol>
        <li><a href="{{ route('frontend.beranda') }}">Beranda</a></li>
        <li>Daftar Dosen</li>
      </ol>
    </div>
  </div>
</section><!-- End Blog Section -->
@endsection

@section('content')
<!-- ======= Contact Section ======= -->
<section class="contact" data-aos="fade-up" data-aos-easing="ease-in-out" data-aos-duration="500">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="row g-3 mb-3">
            <div class="col">
                <label for="" class="form-label fs-5">Fakultas</label>
                <select class="form-select form-select-lg" aria-label="Default select example">
                    <option selected>-- Semua --</option>
                </select>
            </div>
            <div class="col">
                <label for="" class="form-label fs-5">Program Studi</label>
                <select class="form-select form-select-lg" aria-label="Default select example">
                    <option selected>-- Semua --</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="{{ $datatable2['id_table'] }}" style="font-size: 14px;">
            <thead>
              <tr>
                <th width="10px">No</th>
                <th>NIDN</th>
                <th>Nama Dosen</th>
                <th>JK</th>
                <th>TTL</th>
                <th>Departemen</th>
                <th width="100px" style="text-align:center;">Aksi</th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section><!-- End Contact Section -->

<!-- jQuery -->
<script src="{{ asset('adminlte3') }}/plugins/jquery/jquery.min.js"></script>
<!-- datatble js -->
<script type="text/javascript" src="https://cdn.datatables.net/2.0.1/js/dataTables.min.js"></script>
<script type="text/javascript">
$(function () {
    var table = $("#{{$datatable2['id_table']}}").DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ $datatable2['url'] }}"
        },
        columns: [
            @foreach ($datatable2['columns'] as $row)
                {data: "{{$row['data']}}", name: "{{$row['name']}}", orderable: {{$row['orderable']}}, searchable: {{$row['searchable']}}},
            @endforeach
        ]
    });
});
</script>
@endsection