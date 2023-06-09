@extends('siswa.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>DASHBOARD</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('siswa/dashboard') }}">Siswa</a></li>
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
  <div class="row mb-2">
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><strong>Belum</strong></li>
        <li class="breadcrumb-item">Mengumpulkan</li>
      </ol> 
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Deadline</li>
        <li class="breadcrumb-item"><strong>Masih</strong></li>
      </ol>
    </div>
  </div>
  <div class="row">
    @php
    date_default_timezone_set('Asia/Jakarta');
    $currentTime = time();
    $counttbs = 0;
    $countShown = 0;
    @endphp

    @foreach ($tugasBelumDikumpulkan as $tbd)
      @php
      $deadline = strtotime($tbd->deadline);
      $diffSeconds = $deadline - $currentTime;

      $years = floor($diffSeconds / (3600 * 24 * 365));
      $diffSeconds %= 3600 * 24 * 365;
      $months = floor($diffSeconds / (3600 * 24 * 30));
      $diffSeconds %= 3600 * 24 * 30;
      $days = floor($diffSeconds / (3600 * 24));
      $diffSeconds %= 3600 * 24;
      $hours = floor($diffSeconds / 3600);
      $diffSeconds %= 3600;
      $minutes = floor($diffSeconds / 60);
      $seconds = $diffSeconds % 60;

      if ($currentTime <= $deadline) {
        $counttbs++;
      }
      @endphp
    @endforeach

    @foreach ($tugasBelumDikumpulkan as $tbd)
      @php
      $deadline = strtotime($tbd->deadline);
      $diffSeconds = $deadline - $currentTime;

      $years = floor($diffSeconds / (3600 * 24 * 365));
      $diffSeconds %= 3600 * 24 * 365;
      $months = floor($diffSeconds / (3600 * 24 * 30));
      $diffSeconds %= 3600 * 24 * 30;
      $days = floor($diffSeconds / (3600 * 24));
      $diffSeconds %= 3600 * 24;
      $hours = floor($diffSeconds / 3600);
      $diffSeconds %= 3600;
      $minutes = floor($diffSeconds / 60);
      $seconds = $diffSeconds % 60;

      if ($currentTime <= $deadline) {
        $countShown++;
      }
      @endphp
      
      @if ($currentTime <= $deadline)
      <div class="col-xl-{{ $counttbs % 2 == 0 ? '6' : ($countShown == $counttbs ? '12' : '6') }} col-md-6 mb-4">
          <a href="{{ url('siswa/pertemuan/'.$tbd->id_pertemuan) }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1 text-warning">
                      Belum Mengumpulkan
                    </div>
                    <div class="h5 mb-1 font-weight-bold">{{ $tbd->nama }}</div>
                      <div class="small mb-0 font-weight-bold text-info">Sisa Waktu: 
                        @if ($years > 0)
                            {{ $years }} tahun
                          @endif
                          @if ($months > 0)
                            {{ $months }} bulan
                          @endif
                          @if ($days > 0)
                            {{ $days }} hari
                          @endif
                          @if ($hours > 0)
                            {{ $hours }} jam
                          @endif
                          @if ($minutes > 0)
                            {{ $minutes }} menit
                          @endif
                          @if ($seconds > 0)
                            {{ $seconds }} detik
                          @endif
                      </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-book-open fa-2x"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      @endif
    @endforeach 

    @if ($countShown == 0)
    <div class="col-12 text-center">
      <p>Tidak ada tugas</p>
    </div>
    @endif

  </div>

  <div class="row mb-2">
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><strong>Sudah</strong></li>
        <li class="breadcrumb-item">Mengumpulkan</li>
      </ol> 
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Deadline</li>
        <li class="breadcrumb-item"><strong>Masih</strong></li>
      </ol>
    </div>
  </div>
  <div class="row">
    @php
    date_default_timezone_set('Asia/Jakarta');
    $currentTime = time();
    $counttbs = 0;
    $countShown = 0;
    $totalCount = count($tugasSudahDikumpulkan);
    @endphp
  
    @foreach ($tugasSudahDikumpulkan as $tbd)
      @php
      $deadline = strtotime($tbd->deadline);
      $diffSeconds = $deadline - $currentTime;
  
      $years = floor($diffSeconds / (3600 * 24 * 365));
      $diffSeconds %= 3600 * 24 * 365;
      $months = floor($diffSeconds / (3600 * 24 * 30));
      $diffSeconds %= 3600 * 24 * 30;
      $days = floor($diffSeconds / (3600 * 24));
      $diffSeconds %= 3600 * 24;
      $hours = floor($diffSeconds / 3600);
      $diffSeconds %= 3600;
      $minutes = floor($diffSeconds / 60);
      $seconds = $diffSeconds % 60;
  
      if ($currentTime <= $deadline) {
        $counttbs++;
      }
      @endphp
    @endforeach
  
    @foreach ($tugasSudahDikumpulkan as $tbd)
      @php
      $deadline = strtotime($tbd->deadline);
      $diffSeconds = $deadline - $currentTime;
  
      $years = floor($diffSeconds / (3600 * 24 * 365));
      $diffSeconds %= 3600 * 24 * 365;
      $months = floor($diffSeconds / (3600 * 24 * 30));
      $diffSeconds %= 3600 * 24 * 30;
      $days = floor($diffSeconds / (3600 * 24));
      $diffSeconds %= 3600 * 24;
      $hours = floor($diffSeconds / 3600);
      $diffSeconds %= 3600;
      $minutes = floor($diffSeconds / 60);
      $seconds = $diffSeconds % 60;
  
      if ($currentTime <= $deadline) {
        $countShown++;
      }
      @endphp
       
      @if ($currentTime <= $deadline)
      <div class="col-xl-{{ $counttbs % 2 == 0 ? '6' : ($countShown == $counttbs ? '12' : '6') }} col-md-6 mb-4">
          <a href="{{ url('siswa/pertemuan/'.$tbd->id_pertemuan) }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1 text-success">
                      Sudah Mengumpulkan
                    </div>
                    <div class="h5 mb-1 font-weight-bold">{{ $tbd->nama }}</div>
                    @if ($hours > 0 || $minutes > 0 || $seconds > 0)
                      <div class="small mb-0 font-weight-bold text-info">Sisa Waktu: 
                        @if ($years > 0)
                            {{ $years }} tahun
                          @endif
                          @if ($months > 0)
                            {{ $months }} bulan
                          @endif
                          @if ($days > 0)
                            {{ $days }} hari
                          @endif
                          @if ($hours > 0)
                            {{ $hours }} jam
                          @endif
                          @if ($minutes > 0)
                            {{ $minutes }} menit
                          @endif
                          @if ($seconds > 0)
                            {{ $seconds }} detik
                          @endif
                      </div>
                    @endif
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-book-open fa-2x"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      @endif
    @endforeach 
  
    @if ($countShown == 0)
    <div class="col-12 text-center">
      <p>Tidak ada tugas</p>
    </div>
    @endif
  
  </div> 
  <div class="row mb-2">
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-left">
        <li class="breadcrumb-item"><strong>Belum</strong></li>
        <li class="breadcrumb-item">Mengumpulkan</li>
      </ol> 
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item">Deadline</li>
        <li class="breadcrumb-item"><strong>Habis</strong></li>
      </ol>
    </div>
  </div>
  
  <div class="row">
    @php
    date_default_timezone_set('Asia/Jakarta');
    $currentTime = time();
    $counttbs = 0;
    $countShown = 0;
    @endphp
  
    {{-- Tugas Belum Dikumpulkan --}}
    @foreach ($tugasBelumDikumpulkan as $tbd)
      @php
      $deadline = strtotime($tbd->deadline);
      $diffSeconds = $deadline - $currentTime;
  
      if ($currentTime >= $deadline) {
        $counttbs++;
      }
      @endphp
    @endforeach
  
    {{-- Tugas Belum Dikumpulkan --}}
    @foreach ($tugasBelumDikumpulkan as $tbd)
      @php
      $deadline = strtotime($tbd->deadline);
      $diffSeconds = $deadline - $currentTime;
  
      if ($currentTime >= $deadline) {
        $countShown++;
      }
      @endphp
       
      @if ($currentTime >= $deadline)
        <div class="col-xl-{{ $counttbs % 2 == 0 ? '6' : ($countShown == $counttbs ? '12' : '6') }} col-md-6 mb-4">
          <a href="{{ url('siswa/pertemuan/'.$tbd->id_pertemuan) }}" style="text-decoration: none; color: inherit;">
            <div class="card border-left-info shadow h-100 py-2">
              <div class="card-body">
                <div class="row no-gutters align-items-center">
                  <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-uppercase mb-1 text-danger">
                      Belum Mengumpulkan
                    </div>
                    <div class="h5 mb-1 font-weight-bold">{{ $tbd->nama }}</div>
                      <div class="small mb-0 font-weight-bold text-info">
                        Deadline Sudah Habis
                      </div>
                  </div>
                  <div class="col-auto">
                    <i class="fas fa-book-open fa-2x"></i>
                  </div>
                </div>
              </div>
            </div>
          </a>
        </div>
      @endif
    @endforeach 
  
    @if ($countShown == 0)
      <div class="col-12 text-center">
        <p>Tidak ada tugas</p>
      </div>
    @endif
  
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