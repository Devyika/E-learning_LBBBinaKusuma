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
  @foreach($kelas as $k)
  @php
    $mapelKelas = $mapel->where('kelas', $k->id_kelas); // Filter mapel berdasarkan kelas
    $countMapelKelas = count($mapelKelas);
  @endphp
  <div class="row mb-2">
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><strong>Tingkat</strong> {{ $k->tingkat }}</li>
        <li class="breadcrumb-item"><strong>Jurusan</strong> {{ $k->jurusan }}</li>
        <li class="breadcrumb-item"><strong>Kelas</strong> {{ $k->kelas }}</li>
    </ol>          
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><strong>{{ $countMapelKelas }}</strong></li>
        <li class="breadcrumb-item">Mata Pelajaran</li>
      </ol>
    </div>
  </div>
  <div class="row">
      @foreach($mapelKelas as $mk)
      <div class="col-xl-{{ $countMapelKelas % 3 == 0 ? ($loop->iteration % 3 == 0 ? '12' : '6') : ($countMapelKelas % 2 == 0 ? '6' : '12') }} col-md-6 mb-4">
        <a href="{{ url('guru/pertemuan/'.$mk->id) }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                {{ $k->tingkat }} {{ $k->jurusan }} {{ $k->kelas }}
                            </div>
                            <div class="h5 mb-0 font-weight-bold">{{ $mk->nama }}</div>
                        </div>
                        <div class="col-auto">
                          <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </a>
      </div>       
      @endforeach
  </div>
  @endforeach
</div>

  <!-- /.row -->
  <!-- Main row -->
  
  <!-- /.row (main row) -->
</div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
@endsection