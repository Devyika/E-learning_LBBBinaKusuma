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
      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addPertemuanModal">
        <i class="fa-solid fa-plus"></i> Tambah Pertemuan
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
                  Modul &nbsp; | &nbsp; <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModulModal">
                    <i class="fa-solid fa-plus"></i>
                  </button>
                </td>
              </tr>
              <tr class="expandable-body">
                <td>
                  <div class="p-0">
                    <table class="table table-hover">
                      <tbody>
                        @foreach ($modul as $m)
                        @if ($m->id_pertemuan == $p->id)
                        <tr data-widget="expandable-table" aria-expanded="false">
                          <td>
                            &emsp; <a href="{{asset('storage/'.$m->file)}}" target="_blank" rel="noopener noreferrer">{{$m->nama}}</a> &nbsp; &nbsp; | &nbsp; &nbsp; 
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModulModal">
                              Edit
                            </button>
                            &nbsp; 
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addModulModal">
                              Hapus
                            </button>
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
                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#addModulTugas">
                    <i class="fa-solid fa-plus"></i>
                  </button>
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
                            &emsp; {{$t->nama}} &nbsp; &nbsp; | &nbsp; &nbsp; <a href="" class="btn btn-sm btn-primary">Lihat Tugas Siswa</a>
                            &nbsp;
                            <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#addModulModal">
                              Edit
                            </button>
                            &nbsp; 
                            <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#addModulModal">
                              Hapus
                            </button>
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
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="addPertemuan"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addModulModal" tabindex="-1" role="dialog" aria-labelledby="addModulModal-label" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModulModal-label"><strong>Tambah Modul</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @isset($p)
        <form id="addModul2" method="POST" action="{{ url('/guru/pertemuan/modul/'.$id.'/'.$p->id) }}" enctype="multipart/form-data">            
        @endisset
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
                <input type="file" class="form-control @error('file') is-invalid @enderror" id="file" name="file" value="{{ old('file') }}" placeholder="Masukkan File">
                @error('file')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="addModul2"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addModulTugas" tabindex="-1" role="dialog" aria-labelledby="addModulTugas-label" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModulTugas-label"><strong>Tambah Tugas</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        @isset($p)
        <form id="addModul3" method="POST" action="{{ url('/guru/pertemuan/tugas/'.$id.'/'.$p->id) }}" enctype="multipart/form-data">            
        @endisset
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
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="addModul3"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>

{{-- @foreach ($admin as $a) --}}
{{-- <div class="modal fade" id="editAdminModal-{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="editAdminModal-label-{{ $a->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAdminModal-label-{{ $a->id }}"><strong>Edit Admin </strong>{{ $a->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editAdminForm-{{ $a->id }}" method="POST" action="{{ url('/admin/input-admin/'. $a->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-8">
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $a->name) }}" placeholder="Masukkan Nama">
                @error('name')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="editAdminForm-{{ $a->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>                              
  </div>
</div>    --}}
{{-- @endforeach --}}

@endsection