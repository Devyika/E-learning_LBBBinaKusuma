@extends('guru.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Pertemuan</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Menu</a></li>
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
      <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addPertemuanModal">
        <i class="fa-solid fa-plus mr-2"></i> Tambah Pertemuan
      </button><br><br>
      <div class="card">
        <div class="card-header">
          @if ($mapel2->count() == 1)
          @foreach ($mapel2 as $m)
          <h3 class="card-title"><b>Kelas :</b> {{$m->tingkat}} {{$m->jurusan}} {{$m->kelas}}  <b>&nbsp;&nbsp;|&nbsp;&nbsp;  Pelajaran :</b> {{$m->nama}}</h3>
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
                  Modul
                  <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addModulModal{{$p->id}}">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                  {{-- addmodul modal --}}
                  <div class="modal fade" id="addModulModal{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="addModulModal-label" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="addModulModal-label"><strong>Tambah Modul</strong> {{ $p->nama }}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="addModul{{$p->id}}" method="POST" action="{{ route('add.modul', ['pertemuan' => $id, 'id' => $p->id]) }}" enctype="multipart/form-data">            
                            @csrf
                                <div class="form-group">
                                  <label for="nama">Nama</label>
                                  <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama">
                                  @error('nama')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                  @enderror
                                </div>
                                <div class="form-group">
                                  <label for="file">File</label>
                                  <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file"value="{{ old('file') }}" placeholder="Masukkan File" style="padding: 0; height: 100%;">
                                    @error('file')
                                      <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                    @enderror
                                </div>
                          </form>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary btn-sm" form="addModul{{$p->id}}"><i class="fa-solid fa-save"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- tutup addmodul modal --}}
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
                            &emsp; <a href="{{asset('storage/'.$mm->file)}}" target="_blank" rel="noopener noreferrer">{{$mm->nama}}</a>
                            <button type="button" class="btn btn-danger btn-sm float-right" data-toggle="modal" data-target="#deleteModalModul{{$mm->id}}">
                              <i class="fa-solid fa-trash"></i>
                            </button>
                          </td>
                        </tr>
                        {{-- modal deletemodul --}}
                        <div class="modal fade" id="deleteModalModul{{$mm->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModulModal-label" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModulModal-label"><strong>Hapus Modul </strong>{{ $mm->nama }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <p>Anda yakin ingin menghapus modul ini?</p>
                                  </div>
                                  <div class="modal-footer">
                                      <form method="POST" action="{{ url('/guru/pertemuan/deleteModul/'.$mm->id)}}">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                        </div>
                        {{-- tutup modal deletemodul --}}
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
                  Tugas
                  <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addModulTugas{{$p->id}}">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                  {{-- addtugas modal --}}
                  <div class="modal fade" id="addModulTugas{{$p->id}}" tabindex="-1" role="dialog" aria-labelledby="addModulTugas-label" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="addModulTugas-label"><strong>Tambah Tugas</strong> {{$p->nama}}</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <form id="addTugas{{$p->id}}" method="POST" action="{{ url('/guru/pertemuan/tugas/'.$id.'/'.$p->id) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama">
                                @error('nama')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="deadline">Deadline</label>
                                <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ old('deadline') }}" placeholder="Masukkan Deadline">
                                @error('deadline')
                                    <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                @enderror
                            </div>
                        </form>                        
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary btn-sm" form="addTugas{{$p->id}}"><i class="fa-solid fa-save"></i></button>
                        </div>
                      </div>
                    </div>
                  </div>
                  {{-- tutup addtugas modal --}}
                </td>
              </tr>
              <tr class="expandable-body">
                <td>
                  <div class="p-0">
                    <table class="table table-hover">
                      <tbody>
                        @foreach ($tugas as $t)
                        @if ($t->id_pertemuan == $p->id)
                        <tr data-widget="expandable-table" aria-expanded="false">
                          <td>
                            <div class="row">
                              <div class="col-sm-8 d-flex align-items-center">
                                  <span>{{$t->nama}}</span>
                              </div>
                              <div class="col-sm-4 d-flex justify-content-center align-items-center">
                                <a href="{{ url('/guru/tugas-siswa/'.$t->id.'/'.$id.'/'.$t->id_pertemuan)}}" class="btn btn-sm btn-primary btn-block">Lihat Tugas Siswa</a>
                              </div>                            
                              <div class="col-sm-8">
                                  <?php
                                      date_default_timezone_set('Asia/Jakarta');
                                      $currentTime = date('Y-m-d H:i:s');
                                      $deadline = $t->deadline;
                                      $textColorClass = ($currentTime < $deadline) ? 'text-success' : 'text-danger';
                                  ?>
                                  <span class="text-muted">Deadline: </span>
                                  <br>
                                  @if ($currentTime < $deadline)
                                      <span class="{{ $textColorClass }}">{{ $deadline }}</span>
                                  @else
                                      <span class="{{ $textColorClass }}">{{ $deadline }}</span>
                                  @endif
                              </div>
                              <div class="col-sm-4 d-flex justify-content-around align-items-center">
                                <button type="button" class="btn btn-primary btn-sm w-100 mr-1" data-toggle="modal" data-target="#editTugasModal{{$t->id}}">
                                  <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button type="button" class="btn btn-danger btn-sm w-100 ml-1" data-toggle="modal" data-target="#deleteTugasModal{{$t->id}}">
                                    <i class="fa-solid fa-trash"></i>
                                </button>                               
                            </div>                                                                                 
                          </div>
                                                                                                                                                 

                        {{-- modal deletetugas --}}
                        <div class="modal fade" id="deleteTugasModal{{$t->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteModulModal-label" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModulModal-label"><strong>Hapus Tugas </strong> {{ $t->nama }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <p>Anda yakin ingin menghapus tugas ini?</p>
                                  </div>
                                  <div class="modal-footer">
                                      <form method="POST" action="{{ url('/guru/pertemuan/deleteTugas/'.$t->id)}}">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                        </div>
                        {{-- tutup modal deletetugas --}}
                        <div class="modal fade" id="editTugasModal{{$t->id}}" tabindex="-1" role="dialog" aria-labelledby="editTugasModal-label{{$t->id}}" aria-hidden="true">
                          <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="editTugasModal-label{{$t->id}}"><strong>Edit Tugas </strong>{{ $t->nama }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <form id="editTugasForm{{$t->id}}" method="POST" action="{{ url('/guru/pertemuan/tugas/'.$id.'/'.$t->id) }}" enctype="multipart/form-data">
                                          @csrf
                                          @method('PUT')
                                          <div class="form-group">
                                              <label for="nama">Nama</label>
                                              <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ $t->nama }}" placeholder="Masukkan Nama">
                                              @error('nama')
                                                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                              @enderror
                                          </div>
                                          <div class="form-group">
                                            <label for="deadline">Deadline</label>
                                            <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" id="deadline" name="deadline" value="{{ $t->deadline ? \Carbon\Carbon::parse($t->deadline)->format('Y-m-d\TH:i') : '' }}" placeholder="Masukkan Deadline">
                                            @error('deadline')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                            @enderror
                                        </div>                                        
                                      </form>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary btn-sm" form="editTugasForm{{$t->id}}"><i class="fa-solid fa-save"></i></button>
                                  </div>
                              </div>
                          </div>
                      </div>                      

                          </td>
                        </tr>
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

<div class="modal fade" id="addPertemuanModal" tabindex="-1" role="dialog" aria-labelledby="addPertemuanModal-label" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addPertemuanModal-label"><strong>Tambah Pertemuan</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addPertemuan" method="POST" action="{{ url('/guru/pertemuan/'.$id) }}" enctype="multipart/form-data">
          @csrf
              <div class="form-group">
                <label for="nama">Nama</label>
                <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama">
                @error('nama')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="addPertemuan"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>

@endsection