@extends('siswa.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Pertemuan</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Mata Pelajaran</a></li>
        <li class="breadcrumb-item active">Pertemuan</li>
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
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          @if ($pertemuan->count() == 1)
          @foreach ($pertemuan as $p)
          <h3 class="card-title"><b>Kelas :</b> {{$p->tingkat}} {{$p->jurusan}} {{$p->kelas}}  <b>&nbsp;&nbsp;|&nbsp;&nbsp;  Pelajaran :</b> {{$p->mapel}}</h3>
          @endforeach
          @endif
        </div>
        <!-- ./card-header -->
        <div class="card-body p-0">
          <table class="table table-hover">
            <tbody>
              @foreach ($pertemuan as $p)
              <tr>
                <td class="border-0">{{$p->nama}}</td>
              </tr>
              <tr data-widget="expandable-table" aria-expanded="true">
                <td>
                  <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                  Modul &nbsp; | &nbsp; 
                </td>
              </tr>
              <tr class="expandable-body">
                <td>
                  <div class="p-0">
                    <table class="table table-hover">
                      <tbody>
                        @foreach ($modul as $mm)
                        @if ($mm->id_pertemuan == $p->id)                        
                        <tr data-widget="expandable-table" aria-expanded="false">
                          <td>
                            <a href="{{ asset('storage/' . $mm->file) }}" target="_blank" rel="noopener noreferrer">
                              <div class="row">
                                <div class="col-sm-3">
                                  {{ $mm->nama }}
                                </div>
                                <div class="col-sm-9">
                                  {{ str_replace('file/modul/', '', $mm->file) }}<i class="far fa-file float-right"></i>
                                </div>
                              </div>
                            </a>
                          </td>
                        </tr>                        
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>

              <tr data-widget="expandable-table" aria-expanded="true">
                <td>
                  <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                  Tugas &nbsp; | &nbsp; 
                </td>
              </tr>
              <tr class="expandable-body">
                <td>
                  <table class="table table-hover">
                    <tbody>
                      @foreach ($tugas as $t)
                          @if ($t->id_pertemuan == $p->id)
                              @php
                                  date_default_timezone_set('Asia/Jakarta');
                                  $deadline = strtotime($t->deadline);
                                  $currentTime = time();
                                  $diffSeconds = $deadline - $currentTime;
                  
                                  $years = floor($diffSeconds / (365 * 24 * 60 * 60));
                                  $diffSeconds -= $years * (365 * 24 * 60 * 60);
                                  $months = floor($diffSeconds / (30 * 24 * 60 * 60));
                                  $diffSeconds -= $months * (30 * 24 * 60 * 60);
                                  $days = floor($diffSeconds / (24 * 60 * 60));
                                  $diffSeconds -= $days * (24 * 60 * 60);
                                  $hours = floor($diffSeconds / (60 * 60));
                                  $diffSeconds -= $hours * (60 * 60);
                                  $minutes = floor($diffSeconds / 60);
                                  $seconds = $diffSeconds % 60;
                  
                                  $textColorClass = ($currentTime > $deadline) ? 'text-danger' : 'text-success';
                              @endphp
                              <tr data-widget="expandable-table" aria-expanded="false">
                                  <td>
                                    <a href="{{ url('/siswa/pengumpulan-tugas/'.$t->id) }}" onclick="{{ ($currentTime > $deadline) ? 'event.preventDefault(); toastr.error(\'Deadline telah berlalu\');' : '' }}" data-toggle="{{ ($currentTime <= $deadline) ? 'modal' : '' }}" data-target="{{ ($currentTime <= $deadline) ? '#modal'.$t->id : '' }}" style="text-decoration: none; color: inherit;">
                                          <div class="card">
                                              <div class="card-header text-primary">
                                                  <div class="row">
                                                    <div class="col-sm-3">
                                                      Pengumpulan Tugas
                                                    </div>
                                                    <div class="col-sm-9">
                                                      {{ $t->nama }} <i class="far fa-file float-right"></i>
                                                    </div>
                                                  </div>
                                              </div>
                                              <div class="card-body">
                                                  <div class="row">
                                                      <div class="col-sm-3">
                                                          <p class="card-text">Nilai</p>
                                                      </div>
                                                      <div class="col-sm-9">
                                                          @php $found = false; @endphp
                                                          @foreach($allPengumpulanTugas as $pt)
                                                              @if($pt->id_siswa == $userId && $pt->id_tugas == $t->id)
                                                                  @php
                                                                      $found = true;
                                                                  @endphp
                                                                  <span class="{{ $pt->nilai != -1 ? 'text-success' : 'text-warning' }}">
                                                                      {{ $pt->nilai != -1 ? $pt->nilai : 'Belum Dinilai' }}
                                                                      @if ($pt->nilai == -1)
                                                                          <i class="far fa-pause-circle float-right"></i>
                                                                      @elseif ($pt->nilai != -1)
                                                                          <i class="far fa-check-circle float-right"></i>
                                                                      @endif
                                                                  </span>
                                                                  @break
                                                              @endif
                                                          @endforeach
                                                          @if(!$found)
                                                              <span class="text-danger">0 <i class="far fa-times-circle float-right"></i></span>
                                                          @endif
                                                      </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="card-text">Keterangan Penilaian</p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                        @php $found = false; @endphp
                                                        @foreach($allPengumpulanTugas as $pt)
                                                            @if($pt->id_siswa == $userId && $pt->id_tugas == $t->id)
                                                                @php
                                                                    $found = true;
                                                                @endphp
                                                                <span class="text-muted">
                                                                  {{ $pt->keterangan === null ? $pt->keterangan : '-' }}
                                                                    @if ($pt->keterangan == null)
                                                                        <i class="far fa-pause-circle float-right"></i>
                                                                    @elseif ($pt->keterangan != null)
                                                                        <i class="far fa-check-circle float-right"></i>
                                                                    @endif
                                                                </span>
                                                                @break
                                                            @endif
                                                        @endforeach
                                                        @if(!$found)
                                                            <span class="text-danger">0 <i class="far fa-times-circle float-right"></i></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                  <div class="row">
                                                      <div class="col-sm-3">
                                                          <p class="card-text">Deadline</p>
                                                      </div>
                                                      <div class="col-sm-9">
                                                        <span class="{{ $textColorClass }}">
                                                          @if ($currentTime > $deadline)
                                                              Deadline telah berlalu <i class="far fa-times-circle float-right"></i>
                                                          @else
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
                                                              {{ $seconds }} detik <i class="far fa-clock float-right"></i>
                                                          @endif
                                                        </span>                                                                                                            
                                                      </div>
                                                  </div>
                                                  <div class="row">
                                                    <div class="col-sm-3">
                                                        <p class="card-text">Deskripsi</p>
                                                    </div>
                                                    <div class="col-sm-9">
                                                      <span class="text-muted">
                                                            {{ $t->deskripsi }} <i class="far fa-check-circle float-right"></i>
                                                      </span>                                                                                                            
                                                    </div>
                                                </div>
                                              </div>
                                              @php $found = false; @endphp
                                              @foreach($allPengumpulanTugas as $pt)
                                                  @if($pt->id_siswa == $userId && $pt->id_tugas == $t->id)
                                                      @php
                                                          $found = true;
                                                      @endphp
                                                      <a href="{{ asset('storage/'.$pt->file) }}" target="_blank" class="bg-success" style="text-decoration: none; color: inherit;">
                                                          <div class="card-footer">
                                                            <div class="row">
                                                              <div class="col-sm-3">
                                                                Tugas Yang Dikumpulkan
                                                              </div>
                                                              <div class="col-sm-9">
                                                                {{ str_replace('file/tugas/', '', $pt->file) }}<i class="far fa-file-pdf float-right"></i>
                                                              </div>
                                                            </div>
                                                          </div>
                                                      </a>
                                                      @break
                                                  @endif
                                              @endforeach
                                              @if(!$found)
                                                  <div class="card-footer bg-danger">
                                                      <span>Belum Mengumpulkan<i class="far fa-times-circle float-right"></i></span>
                                                  </div>
                                              @endif
                                          </div>
                                      </a>
                                  </td>
                              </tr>
                          @endif
                      @endforeach
                    </tbody>
                  
                  </table> 
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.row -->
  <!-- Main row -->
  
  <!-- /.row (main row) -->
</div>
  <!-- /.card-body -->
</div>
<!-- /.card -->
{{-- modal --}}
@foreach ($tugas as $t)
<div class="modal fade" id="modal{{$t->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-label{{$t->id}}" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="modal-label{{$t->id}}"><strong>Pengumpulan Tugas</strong></h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <div class="text-center" id="preview">
              </div>
              <form id="modalForm{{$t->id}}" method="POST" action="{{ url('siswa/pengumpulan-tugas/'.$t->id) }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-group">
                    <label><strong>Nama Tugas</strong></label>
                    <p>{{$t->nama}}</p>
                </div>
                  <div class="form-group">
                      <label for="file">File Tugas</label>
                      <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" accept="application/pdf" onchange="previewPDF()" style="padding: 0; height: 100%;">
                      @error('file')
                      <span class="invalid-feedback" role="alert">{{ $message }}</span>
                      @enderror
                  </div>
              </form>
          </div>
          <div class="modal-footer">
              <button type="submit" class="btn btn-primary btn-sm" form="modalForm{{$t->id}}"><i class="fa-solid fa-save"></i></button>
          </div>
      </div>
  </div>
</div>
@endforeach
@endsection