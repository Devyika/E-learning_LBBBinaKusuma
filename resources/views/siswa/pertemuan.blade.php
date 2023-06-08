@extends('siswa.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Pertemuan</h1>
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
                            &emsp; <a href="{{asset('storage/'.$mm->file)}}" target="_blank" rel="noopener noreferrer">{{$mm->nama}} <i class="far fa-file float-right"></i></a>
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
                  <div class="p-0">
                    <table class="table table-hover">
                      <tbody>
                        @foreach ($tugas as $t)
                        @if ($t->id_pertemuan == $p->id)
                        @php
                          date_default_timezone_set('Asia/Jakarta');
                          $deadline = strtotime($t->deadline);
                          $currentTime = time();
                          $diffSeconds = $deadline - $currentTime;

                          $hours = floor($diffSeconds / 3600);
                          $minutes = floor(($diffSeconds % 3600) / 60);
                          $seconds = $diffSeconds % 60;

                          $textColorClass = ($currentTime > $deadline) ? 'text-danger' : 'text-success';
                        @endphp
                        <tr data-widget="expandable-table" aria-expanded="false">
                          <td>
                            <a href="{{ url('/siswa/pengumpulan-tugas/'.$t->id) }}" onclick="{{ ($diffSeconds <= 0) ? 'event.preventDefault(); toastr.error(\'Deadline telah berlalu\');' : '' }}" data-toggle="modal" data-target="{{ ($diffSeconds > 0) ? '#modal'.$t->id : '' }}">
                              {{ $t->nama }} <i class="far fa-file float-right"></i>
                            </a>                                                             
                          </td>
                          <td>
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
                          </td>                          
                          <td>
                            @if ($t->deadline)
                              <span class="{{ $textColorClass }}">
                                @if ($diffSeconds > 0)
                                  @if ($hours > 0)
                                    {{ $hours }} jam,
                                  @endif
                                  @if ($minutes > 0)
                                    {{ $minutes }} menit,
                                  @endif
                                  {{ $seconds }} detik <i class="far fa-clock float-right"></i>
                                @else
                                  Deadline telah berlalu <i class="far fa-times-circle float-right"></i>
                                @endif
                              </span>
                            @else
                              Tidak ada deadline
                            @endif
                          </td>                                                                
                          <td>
                            @php $found = false; @endphp
                            @foreach($allPengumpulanTugas as $pt)
                              @if($pt->id_siswa == $userId && $pt->id_tugas == $t->id)
                                @php
                                  $found = true;
                                @endphp
                                <a href="{{ asset('storage/'.$pt->file) }}" target="_blank" class="text-success">Sudah Mengumpulkan<i class="far fa-file-pdf float-right"></i></a>
                                @break
                              @endif
                            @endforeach
                            @if(!$found)
                              <span class="text-danger">Belum Mengumpulkan<i class="far fa-times-circle float-right"></i></span>
                            @endif
                          </td>                          
                          
                        {{-- modal --}}
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
                  </div>                     
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
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

@endsection