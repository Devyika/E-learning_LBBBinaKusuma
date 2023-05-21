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
        <li class="breadcrumb-item active">Kelas</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Kelas {{ $tingkat->name }}-{{ $jurusan->name }}</h3>

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
                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addModal">
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 20%;">Nama Jurusan</th>
                    <th style="width: 30%;">Nama Tingkat</th>
                    <th style="width: 30%;">Nama Kelas</th>
                    <th style="width: 15%;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @if ($jurusanTingkatKelas->count() > 0)
                      @foreach ($jurusanTingkatKelas as $i => $ju)
                      <tr>
                        <td class="text-center">{{++$i}}</td>
                        <td>{{$ju->jurusan->name}}</td>
                        <td>{{$ju->tingkat->name}}</td>
                        <td>{{$ju->kelas->nama}}</td>
                        <td class="d-flex justify-content-around">
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{$ju->id}}">
                            <i class="fa-solid fa-circle-info"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-{{ $ju->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $ju->id }}">
                            <i class="fa-solid fa-trash"></i>
                          </button>
                        </td>
                      </tr>
                      @endforeach
                    @else
                      <tr><td colspan="6" class="text-center">No matching records found</td></tr>
                    @endif
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>No.</th>
                    <th>Nama Jurusan</th>
                    <th>Nama Tingkat</th>
                    <th>Nama Kelas</th>
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
  </div>
</section>
<!-- /.content -->

  <!-- /.card-body -->
</div>
<!-- /.card -->
<!-- Modal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModal-label" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModal-label"><strong>Setting Kelas</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addKelasForm" method="POST" action="{{ url('admin/setting-kelas/{t}/{j}') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="name">Jurusan</label>
            <select name="id_jurusan" class="form-control">
              <option value="{{ $jurusan->id }}">{{ $jurusan->name }}</option>
            </select>
          </div>   
          <div class="form-group">
            <label for="name">Tingkat</label>
            <select name="id_tingkat" class="form-control">
              <option value="{{ $tingkat->id }}">{{ $tingkat->name }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="name">Kelas</label>
            <select name="id_kelas" class="form-control">
              <option value="" selected disabled>Pilih Kelas</option>
              @foreach($allKelas as $k)
                  <option value="{{ $k->id }}">{{ $k->nama }}</option>
              @endforeach
            </select>
          </div>             
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="addKelasForm"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
                       
@foreach ($jurusanTingkatKelas as $ju)
<div class="modal fade" id="detailModal{{$ju->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{$ju->id}}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel{{$ju->id}}"><strong>Detail Kelas </strong>{{$ju->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <label><strong>Nama Jurusan</strong></label>
        <p>{{$ju->jurusan->name}}</p>
        <label><strong>Nama Tingkat</strong></label>
        <p>{{$ju->tingkat->name}}</p>
        <label><strong>Nama Kelas</strong></label>
        <p>{{$ju->kelas->nama}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
      </div>
    </div>
  </div>
</div>
@endforeach
          
@foreach ($jurusanTingkatKelas as $ju)
<div class="modal fade" id="editModal-{{ $ju->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal-label-{{ $ju->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal-label-{{ $ju->id }}"><strong>Edit Kelas </strong>{{ $ju->kelas->nama }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editKelasForm-{{ $ju->id }}" method="POST" action="{{ url('/admin/setting-kelas/'. $ju->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="name">Jurusan</label>
            <select name="id_jurusan" class="form-control">
              <option value="" selected disabled>Pilih Jurusan</option>
              @foreach($allJurusan as $j)
                <option value="{{$j->id}}" {{ isset($ju)? (($ju->id_jurusan == $j->id) ? "selected" : "") : ''}} {{ old('id_jurusan') == $j->id ? "selected" : "" }}>{{$j->name}}</option>
              @endforeach
            </select>
          </div>   
          <div class="form-group">
            <label for="name">Tingkat</label>
            <select name="id_tingkat" class="form-control">
              <option value="" selected disabled>Pilih Tingkat</option>
              @foreach($allTingkat as $t)
                <option value="{{$t->id}}" {{ isset($ju)? (($ju->id_tingkat == $t->id) ? "selected" : "") : ''}} {{ old('id_tingkat') == $t->id ? "selected" : "" }}>{{$t->name}}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="name">Kelas</label>
            <select name="id_kelas" class="form-control">
              <option value="" selected disabled>Pilih Kelas</option>
              @foreach($allKelas as $k)
              <option value="{{$k->id}}" {{ isset($ju)? (($ju->id_kelas == $k->id) ? "selected" : "") : ''}} {{ old('id_kelas') == $k->id ? "selected" : "" }}>{{$k->nama}}</option>
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="editKelasForm-{{ $ju->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>                              
  </div>
</div>   
@endforeach

@foreach ($jurusanTingkatKelas as $ju)
<div class="modal fade" id="deleteModal-{{ $ju->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal-label-{{ $ju->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteModal-label-{{ $ju->id }}"><strong>Hapus Kelas </strong>{{ $ju->nama }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p>Anda yakin ingin menghapus Kelas ini?</p>
          </div>
          <div class="modal-footer">
              <form method="POST" action="{{ url('/admin/setting-kelas/'.$ju->id)}}">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
                  <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
              </form>
          </div>
      </div>
  </div>
</div>     
@endforeach                          

@endsection