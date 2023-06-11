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
    <div class="row mb-4">
        <div class="col-sm-12">
            <button type="button" class="btn btn-primary btn-sm btn-block float-right" data-dismiss="modal" data-toggle="modal" data-target="#nilai">
                <i class="far fa-folder-open mr-2"></i>Nilai Siswa
            </button>
            <div class="modal fade" id="nilai" tabindex="-1" role="dialog" aria-labelledby="nilaiModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="nilaiModalLabel">Nilai @if (Auth::user()->username == "admin")
                                admin
                            @else
                                {{ $user->name }}
                            @endif</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <Strong>Mata Pelajaran</strong>
                                        </div>
                                        <div class="col-sm-3">
                                            <span>
                                                Rata - Rata
                                            </span>
                                        </div>
                                        <div class="col-sm-3">
                                            <span>
                                                Nilai Huruf
                                            </span>
                                        </div>
                                    </div>
                                </li>
                                @foreach ($dataPerhitunganNilai as $dpn)
                                    <li class="list-group-item">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <Strong>{{ $dpn['nama_mapel'] }}</strong>
                                            </div>
                                            <div class="col-sm-3">
                                                <span>
                                                    {{ $dpn['rata_rata_nilai'] }}
                                                </span>
                                            </div>
                                            <div class="col-sm-3">
                                                <span>
                                                    {{ $dpn['grade_total_nilai'] }}
                                                </span>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ url('/siswa/nilai') }}" target="_blank" class="btn btn-primary btn-sm">
                                <i class="fas fa-download mr-2"></i>Unduh Nilai
                            </a>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
            <li class="breadcrumb-item"><strong>Masih</strong></li>
        </ol>
        </div>
    </div>
    <div class="row">
        @php
        date_default_timezone_set('Asia/Jakarta');
        $currentTime = time();
        $countTugasBelum = 0;
        $TugasCounterBelum = 0;
        $tugasBelumIDs = array();
        @endphp

        @if ($jurusanTingkatKelasId)
            @php
            foreach ($tugasBelumDikumpulkan as $tbd) {
                $deadline = strtotime($tbd['deadline']);
                if ($currentTime <= $deadline) {
                    $countTugasBelum++;
                    $tugasBelumIDs[] = $tbd['id'];
                }
            }
            @endphp

            @foreach ($tugasBelumDikumpulkan as $tbd)
                @if (in_array($tbd['id'], $tugasBelumIDs))
                    @php
                    $TugasCounterBelum++;
                    $deadline = strtotime($tbd['deadline']);
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
                    @endphp

                    <div class="col-xl-{{ ($countTugasBelum % 2 == 0 || $TugasCounterBelum != $countTugasBelum )? '6' : '12' }} col-md-6 mb-4">
                        <a href="{{ url('siswa/pertemuan/'.$tbd['id_pertemuan']) }}" style="text-decoration: none; color: inherit;">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-warning">
                                                Belum Mengumpulkan
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold">{{ $tbd['nama'] }}</div>
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

            @if ($countTugasBelum == 0)
                <div class="col-12 text-center">
                    <p>Tidak ada tugas</p>
                </div>
            @endif
        @else
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
        $countTugasSudah = 0;
        $TugasCounterSudah = 0;
        $tugasSudahIDs = array();
        @endphp

        @if ($jurusanTingkatKelasId)
            @php
            foreach ($tugasSudahDikumpulkan as $tbd) {
                $deadline = strtotime($tbd['deadline']);
                if ($currentTime <= $deadline) {
                    $countTugasSudah++;
                    $tugasSudahIDs[] = $tbd['id'];
                }
            }
            @endphp

            @foreach ($tugasSudahDikumpulkan as $tbd)
                @if (in_array($tbd['id'], $tugasSudahIDs))
                    @php
                    $TugasCounterSudah++;
                    $deadline = strtotime($tbd['deadline']);
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
                    @endphp

                    <div class="col-xl-{{ ($countTugasSudah % 2 == 0 || $TugasCounterSudah != $countTugasSudah )? '6' : '12' }} col-md-6 mb-4">
                        <a href="{{ url('siswa/pertemuan/'.$tbd['id_pertemuan']) }}" style="text-decoration: none; color: inherit;">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-success">
                                                Sudah Mengumpulkan
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold">{{ $tbd['nama'] }}</div>
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

            @if ($countTugasSudah == 0)
                <div class="col-12 text-center">
                    <p>Tidak ada tugas</p>
                </div>
            @endif
        @else
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
        $countTugasTelat = 0;
        $TugasCounterTelat = 0;
        $tugasTelatIDs = array();
        @endphp

        @if ($jurusanTingkatKelasId)
            @php
            foreach ($tugasBelumDikumpulkan as $tbd) {
                $deadline = strtotime($tbd['deadline']);
                if ($currentTime >= $deadline) {
                    $countTugasTelat++;
                    $tugasTelatIDs[] = $tbd['id'];
                }
            }
            @endphp

            {{-- Tugas Belum Dikumpulkan dengan Deadline Habis --}}
            @foreach ($tugasBelumDikumpulkan as $tbd)
                @if (in_array($tbd['id'], $tugasTelatIDs))
                    @php
                    $TugasCounterTelat++;
                    $deadline = strtotime($tbd['deadline']);
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
                    @endphp

                    <div class="col-xl-{{ ($countTugasTelat % 2 == 0 || $TugasCounterTelat != $countTugasTelat )? '6' : '12' }} col-md-6 mb-4">
                        <a href="{{ url('siswa/pertemuan/'.$tbd['id_pertemuan']) }}" style="text-decoration: none; color: inherit;">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-uppercase mb-1 text-danger">
                                                Belum Mengumpulkan
                                            </div>
                                            <div class="h5 mb-1 font-weight-bold">{{ $tbd['nama'] }}</div>
                                            <div class="small mb-0 font-weight-bold text-info">Deadline Sudah Habis</div>
                                            <div class="small mb-0 font-weight-bold text-info">
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

            @if ($countTugasTelat == 0)
                <div class="col-12 text-center">
                    <p>Tidak ada tugas</p>
                </div>
            @endif
        @else
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