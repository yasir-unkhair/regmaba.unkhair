@extends('layouts.backend')

@section('content')
<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row">
          <div class="col-sm-6">
            <h1 class="m-0">{{ $judul }}</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
              <li class="breadcrumb-item active">{{ $judul }}</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content pl-2 pr-2">
        <div class="container-fluid">
        <!-- Default box -->
            @if ($mode == 'new')
            <form action="{{ route('admin.profil.save') }}" method="post">
                @csrf
            @else
            <form action="{{ route('admin.profil.update', $id) }}" method="post">
                @csrf
                <input type="hidden" name="id" vale="{{ $id }}">
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $judul }} @if($mode == 'edit') - [ <a href="{{ route('frontend.profil', $slug) }}" target="_blank">Lihat halaman {{ $judul_konten }}</a> ] @endif</h3>

                    <div class="card-tools">
                        <a href="{{ route('admin.profil') }}" class="btn btn-sm btn-default"><i class="fas fa-angle-double-left"></i> Kembali</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="judul_konten">Judul Konten</label>
                        <input type="text" class="form-control" id="judul_konten" name="judul_konten" placeholder="Judul Konten" value="{{ old('judul_konten', $judul_konten) }}">
                        @error('judul_konten')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="isi-konten">Isi Konten</label>
                        <div>
                            <textarea id="isi-konten" name="konten">{{ old('konten', $konten) }}</textarea>
                        </div>
                        @error('konten')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="form-check">
                        <input type="checkbox" name="publish" class="form-check-input" id="publish" value="1" {{ old('publish', $publish) ? 'checked' : '' }}>
                        <label class="form-check-label" for="publish">Publish</label>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                </div>
                <!-- /.card-footer-->
            </div>
            </form>
            <!-- /.card -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->

    <!-- jQuery -->
    <script src="{{ asset('adminlte3') }}/plugins/jquery/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.6.2/standard/ckeditor.js"></script>
    
    <script>
    var base_url = "{{ url('') }}";
    var options = {
        filebrowserImageBrowseUrl: base_url+'/laravel-filemanager?type=Images',
        filebrowserImageUploadUrl: base_url+'/laravel-filemanager/upload?type=Images&_token=',
        filebrowserBrowseUrl: base_url+'/laravel-filemanager?type=Files',
        filebrowserUploadUrl: base_url+'/laravel-filemanager/upload?type=Files&_token=',
        height: 500
    };

    $(function () {
        const editor = CKEDITOR.replace('isi-konten', options);
    });
    </script>
</div>

@endsection
