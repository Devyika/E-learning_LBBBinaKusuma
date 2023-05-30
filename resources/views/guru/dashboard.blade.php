@extends('guru.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>DASHBOARD</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('guru/dashboard') }}">Guru</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <script>
    $(document).ready(function () {
        @php
            $userLevels = [
            0 => 'Admin',
            1 => 'Guru',
            2 => 'Siswa',
            ];
        @endphp
        toastr.success('Selamat Datang {{ $userLevels[Auth::user()->level_user] ?? 'Developer' }}!<br>Halo, {{ $user->name }}!');
    });
  </script>
<!-- Default box -->
<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <!-- /.row -->
  <!-- Main row -->
  
  <!-- /.row (main row) -->
</div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
@endsection