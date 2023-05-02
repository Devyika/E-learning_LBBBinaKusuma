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

          <!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
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
              <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap">
            </div>
              
            <div class="form-group">
              <label>Deskripsi Mata Pelajaran</label>
              <input type="text" name="deskripsi" class="form-control" placeholder="Deskripsi">
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
    
    </div>
</section>
@endsection