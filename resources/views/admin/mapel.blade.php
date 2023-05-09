@extends('admin.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Mata Pelajaran</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Menu</a></li>
        <li class="breadcrumb-item active">Mata Pelajaran</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
      <form method="POST" action="mata-pelajaran">
        @csrf
        {!! (isset($mapel))? method_field('PUT') : ''!!}
      <div class="card-header">
        <h3 class="card-title">Form Input</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>Nama Mata Pelajaran</label>
              <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" placeholder="Nama Mata Pelajaran" value="{{ isset($mapel)? $mapel->nama : old('nama') }}">
              @error('nama')
                <span class="error invalid-feedback">{{ $message }} </span>
              @enderror
            </div>

            <div class="form-group">
              <label>Jurusan</label>
              <select class="form-control select2 @error('jurusan') is-invalid @enderror" style="width: 100%;" name="jurusan" value="{{ isset($mapel)? $mapel->jurusan : old('jurusan') }}">
                <option selected value="IPA">IPA</option>
                <option value="IPS">IPS</option>
                <option value="UMUM">UMUM</option>
              </select>
              @error('jurusan')
                <span class="error invalid-feedback">{{ $message }} </span>
              @enderror
            </div>
              
            <div class="form-group">
              <label>Deskripsi Mata Pelajaran</label>
              <input type="text" name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" placeholder="Deskripsi" value="{{ isset($mapel)? $mapel->deskripsi : old('deskripsi') }}">
              @error('deskripsi')
                <span class="error invalid-feedback">{{ $message }} </span>
              @enderror
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary" style="width: 10%">Submit</button>
            </div>
          </div>
          <!-- /.col -->
          
          <!-- /.col -->
        </div>
      </div>
      <!-- /.card-body -->
    </form>
    </div>
</section>
@endsection