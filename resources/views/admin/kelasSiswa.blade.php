@extends('admin.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>SETTING</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Setting</a></li>
        <li class="breadcrumb-item active">Siswa</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>
@foreach ($jurusanTingkatKelas as $ju)
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">{{ $tingkat->name }} {{ $jurusan->name }} {{ $ju->kelas->nama }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addModal{{ $ju->id }}">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php
                                $filteredKelasSiswa = $allKelasSiswa->where('id_jurusanTingkatKelas', $ju->id);
                                $filteredCount = $filteredKelasSiswa->count();
                                $counter = 0; // Variabel counter untuk menghitung nomor urut
                            @endphp
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No.</th>
                                        <th style="width: 80%;">Nama Siswa</th>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($filteredKelasSiswa as $ks)
                                        <tr>
                                            <td class="text-center">{{ ++$counter }}</td>
                                            <td>{{ $ks->siswa->name }}</td>
                                            <td class="d-flex justify-content-around">
                                                <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{ $ks->id }}">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-{{ $ks->id }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button>
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $ks->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($filteredCount === 0)
                                        <tr>
                                            <td colspan="12" class="text-center">No matching records found</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Siswa</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

</section>
<!-- /.content -->

  <!-- /.card-body -->
</div>
<!-- /.card -->
<!-- Modal -->
@foreach($jurusanTingkatKelas as $ju)
<div class="modal fade" id="addModal{{ $ju->id }}" tabindex="-1" role="dialog" aria-labelledby="addModal-label{{ $ju->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModal-label{{ $ju->id }}"><strong>Setting Siswa</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addForm{{ $ju->id }}" method="POST" action="{{ url('admin/setting-siswa/{t}/{j}') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="id_jurusanTingkatKelas">Kelas</label>
            <select name="id_jurusanTingkatKelas" class="form-control">
              <option value="{{ $ju->id }}">{{ $ju->tingkat->name }} {{ $ju->jurusan->name }} {{ $ju->kelas->nama }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="id_siswa">Nama Siswa</label>
            <select name="id_siswa" class="form-control">
              <option value="" selected disabled>Pilih Siswa</option>
              @foreach($allSiswa as $s)
                  <option value="{{ $s->id }}">{{ $s->name }}</option>
              @endforeach
            </select>
          </div>             
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="addForm{{ $ju->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
 @endforeach

@foreach ($allKelasSiswa as $ks)
<div class="modal fade" id="detailModal{{$ks->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{$ks->id}}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel{{$ks->id}}"><strong>Detail Siswa</strong>{{$ks->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <label><strong>Kelas</strong></label>
        <p>{{$ks->jurusanTingkatKelas->tingkat->name}} {{$ks->jurusanTingkatKelas->jurusan->name}} {{$ks->jurusanTingkatKelas->kelas->nama}}</p>
        <label><strong>Nama Siswa</strong></label>
        <p>{{$ks->siswa->name}}</p>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
@endforeach
          
@foreach ($allKelasSiswa as $ks)
<div class="modal fade" id="editModal-{{ $ks->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal-label-{{ $ks->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal-label-{{ $ks->id }}"><strong>Edit Siswa</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editKelasForm-{{ $ks->id }}" method="POST" action="{{ url('/admin/setting-siswa/'. $ks->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="id_jurusanTingkatKelas">Kelas</label>
            <select name="id_jurusanTingkatKelas" class="form-control">
              @foreach($jurusanTingkatKelas as $ju)
              <option value="{{ $ju->id }}" {{ isset($ks) && $ks->id_jurusanTingkatKelas == $ju->id ? 'selected' : '' }}>{{ $ks->jurusanTingkatKelas->tingkat->name }} {{ $ks->jurusanTingkatKelas->jurusan->name }} {{ $ks->jurusanTingkatKelas->kelas->nama }}</option>              
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="$id_siswa">Nama Siswa</label>
            <select name="$id_siswa" class="form-control">
              <option value="" selected disabled>Pilih Siswa</option>
              @foreach($allSiswa as $s)
              <option value="{{ $s->id }}" {{ isset($ks) && $ks->id_siswa == $s->id ? 'selected' : '' }} {{ old('$id_siswa') == $s->id ? 'selected' : '' }}>{{ $s->name }}</option>              
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="editKelasForm-{{ $ks->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>                              
  </div>
</div>   
@endforeach

@foreach ($allKelasSiswa as $ks)
<div class="modal fade" id="deleteModal-{{ $ks->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal-label-{{ $ks->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteModal-label-{{ $ks->id }}"><strong>Hapus Siswa </strong>{{ $ks->nama }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p>Anda yakin ingin menghapus Siswa ini ?</p>
          </div>
          <div class="modal-footer">
              <form method="POST" action="{{ url('/admin/setting-siswa/'.$ks->id)}}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
              </form>
          </div>
      </div>
  </div>
</div>     
@endforeach                          

@endsection