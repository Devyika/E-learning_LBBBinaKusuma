@extends('guru.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Dashboard</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Menu</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

<!-- Default box -->
<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-6 col-4">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>6</h3>

          <p>Foods</p>
        </div>
        <div class="icon">
          <i class="fas fa-hamburger"></i>
        </div>
        <a href="{{ url('/food') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-6 col-4">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3>9</h3>

          <p>Drinks</p>
        </div>
        <div class="icon">
          <i class="fas fa-cocktail"></i>
        </div>
        <a href="{{ url('/drink') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
      </div>
    </div>
    <!-- ./col -->
  </div>
  <!-- /.row -->
  <!-- Main row -->
  
  <!-- /.row (main row) -->
</div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
@endsection