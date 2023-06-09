@extends('guru.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Tugas Siswa</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Menu</a></li>
        <li class="breadcrumb-item active">Tugas</li>
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
          @foreach ($kelas2 as $m)
          <h3 class="card-title"><b>Kelas :</b> {{$m->tingkat}} {{$m->jurusan}} {{$m->kelas}}  <b>&nbsp;&nbsp;|&nbsp;&nbsp;  Pelajaran :</b> {{$m->mapel}}</h3>
          @endforeach
        </div>
        <!-- ./card-header -->
        <div class="card-body p-0">
          <table class="table table-hover">
            <tbody>
              @foreach ($pertemuan as $p)
              <tr>
                <td class="border-0">{{$p->pertemuan_nama}} - {{$p->tugas_nama}}</td>
              </tr>
              
              <tr class="expandable-body">
                <td>
                  <div class="p-0">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th style="width: 5%;">No.</th>
                        <th style="width: 30%;">Nama</th>
                        <th style="width: 40%;">Tugas</th>
                        <th style="width: 15%;">Nilai</th>
                        <th style="width: 10%;">Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @if ($data->count() > 0)
                          @foreach ($data as $i => $d)
                          <tr>
                            <td class="text-center">{{++$i}}</td>
                            <td>{{$d->nama}}</td>
                            <td><a href="{{asset('storage/'.$d->file)}}" target="_blank" rel="noopener noreferrer">{{$d->tugas}}</a></td>
                            <td>
                              @if ($d->nilai == -1)
                                Belum dinilai
                              @else
                                {{$d->nilai}}
                              @endif
                            </td>
                            <td class="d-flex justify-content-around align-items-center">
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#nilai-{{$d->id}}">
                                <i class="fa-solid fa-pen-to-square"></i>
                              </button>
                              <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#hapus-{{$d->id}}">
                                <i class="fa-solid fa-trash"></i>
                              </button>                              
                            </td>                            
                          </tr>
                          <!-- Modal -->
                          <div class="modal fade" id="nilai-{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="nilai-label-{{ $d->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-md" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="nilai-label-{{ $d->id }}"><strong>Nilai</strong></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form-nilai-{{ $d->id }}" method="POST" action="{{ url('/guru/tugas-siswa/'. $d->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="form-group">
                                              <strong>Nama</strong><br>
                                              {{ $d->nama }}
                                            </div>
                                            <div class="form-group">
                                              <label for="nilai">Nilai</label>
                                              <input type="text" class="form-control @error('nilai') is-invalid @enderror" id="nilai" name="nilai" value="{{ $d->nilai != -1 ? old('nilai', $d->nilai) : '' }}" placeholder="{{ $d->nilai != -1 ? 'Masukkan Nilai' : 'Belum dinilai' }}">
                                              @error('nilai')
                                                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                                              @enderror
                                            </div>                                            
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary btn-sm" form="form-nilai-{{ $d->id }}"><i class="fa-solid fa-save"></i></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>                              
                            </div>
                        </div>
                        <!-- Modal Hapus -->
                        <div class="modal fade" id="hapus-{{ $d->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal-label-{{ $d->id }}" aria-hidden="true">
                          <div class="modal-dialog modal-sm" role="document">
                              <div class="modal-content">
                                  <div class="modal-header">
                                      <h5 class="modal-title" id="deleteModal-label-{{ $d->id }}"><strong>Hapus Tugas </strong>{{ $d->nama }}</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                          <span aria-hidden="true">&times;</span>
                                      </button>
                                  </div>
                                  <div class="modal-body">
                                      <p>Anda yakin ingin menghapus Tugas ini ?</p>
                                  </div>
                                  <div class="modal-footer">
                                      <form method="POST" action="{{ url('/guru/tugas-siswa/'.$d->id)}}">
                                          @csrf
                                          @method('DELETE')
                                          <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                      </form>
                                  </div>
                              </div>
                          </div>
                        </div>
                          @endforeach
                        @else
                          <tr><td colspan="6" class="text-center">No matching records found</td></tr>
                        @endif
                      </tbody>
                      {{-- <tfoot>
                      <tr>
                        <th>No.</th>
                        <th>Username</th>
                        <th>Name</th>
                        <th>Action</th>
                      </tr>
                      </tfoot> --}}
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