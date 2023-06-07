@extends('admin.layout.template')

@section('content')  
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>DASHBOARD</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Admin</a></li>
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
    @if(session('success'))
    @php
    $userLevels = [
        0 => 'Admin',
        1 => 'Guru',
        2 => 'Siswa',
    ];
    @endphp
    <script>
            toastr.success('Selamat Datang {{ $userLevels[Auth::user()->level_user] ?? 'Developer' }}!<br>Halo, {{ $user->name ?? 'admin' }}!');
    </script>
    @endif 
<!-- Default box -->
<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <a href="{{ url('/admin/input-admin') }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Admin</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $countAdmin }} Admin</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-4 col-md-6 mb-4">
        <a href="{{ url('/admin/input-guru') }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Guru</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $countGuru }} Guru</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>    
    <div class="col-xl-4 col-md-6 mb-4">
        <a href="{{ url('/admin/input-siswa') }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Siswa
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold">{{ $countSiswa }} Siswa</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-graduate fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>    
</div>
<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <a href="{{ url('/admin/input-jurusan') }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Jurusan
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $countJurusan }} Jurusan</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-scroll fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>    
    <div class="col-xl-4 col-md-6 mb-4">
        <a href="{{ url('/admin/input-tingkat') }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Tingkat
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $countTingkat }} Tingkat</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa-solid fa-layer-group fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>    
    <div class="col-xl-4 col-md-6 mb-4">
        <a href="{{ url('/admin/input-kelas') }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Kelas
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $countKelas }} Kelas</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chalkboard fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>    
</div>
<div class="row">
    <div class="col-xl-12 col-md-6 mb-4">
        <a href="{{ url('/admin/input-mata_pelajaran') }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Mata Pelajaran
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $countMapel }} Mata Pelajaran</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-swatchbook fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>    
</div>
</div>
  <!-- /.row -->
  <!-- Main row -->
  
  <!-- /.row (main row) -->
</div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
@endsection