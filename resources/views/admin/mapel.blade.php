@extends('admin.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>INPUT</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Input</a></li>
        <li class="breadcrumb-item active">Mata Pelajaran</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Mapel</h3>

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
                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addMapelModal">
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 80%;">Nama Mapel</th>
                    <th style="width: 15%;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @if ($mapel->count() > 0)
                      @foreach ($mapel as $i => $m)
                      <tr>
                        <td class="text-center">{{++$i}}</td>
                        <td>{{$m->nama}}</td>
                        <td class="d-flex justify-content-around">
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{$m->id}}">
                            <i class="fa-solid fa-circle-info"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editMapelModal-{{ $m->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteMapelModal-{{ $m->id }}">
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
                    <th>Nama Mapel</th>
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
<div class="modal fade" id="addMapelModal" tabindex="-1" role="dialog" aria-labelledby="addMapelModal-label" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addMapelModal-label"><strong>Tambah Mapel</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addMapelForm" method="POST" action="{{ url('admin/input-mata_pelajaran') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="nama">Nama Mapel</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" placeholder="Masukkan Nama">
            @error('nama')
              <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
          </div>              
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="addMapelForm"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
                       
@foreach ($mapel as $m)
<div class="modal fade" id="detailModal{{$m->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{$m->id}}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel{{$m->id}}"><strong>Detail Mapel </strong>{{$m->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label><strong>Nama Mapel</strong></label>
        <p>{{$m->nama}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
      </div>
    </div>
  </div>
</div>
@endforeach
          
@foreach ($mapel as $m)
<div class="modal fade" id="editMapelModal-{{ $m->id }}" tabindex="-1" role="dialog" aria-labelledby="editMapelModal-label-{{ $m->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editMapelModal-label-{{ $m->id }}"><strong>Edit Mapel </strong>{{ $m->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editMapelForm-{{ $m->id }}" method="POST" action="{{ url('/admin/input-mata_pelajaran/'. $m->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="nama">Nama Mapel</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $m->nama) }}" placeholder="Masukkan Nama">
            @error('nama')
              <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="editMapelForm-{{ $m->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>                              
  </div>
</div>   
@endforeach

@foreach ($mapel as $m)
<div class="modal fade" id="deleteMapelModal-{{ $m->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteMapelModal-label-{{ $m->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteMapelModal-label-{{ $m->id }}"><strong>Hapus Mapel </strong>{{ $m->nama }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p>Anda yakin ingin menghapus Mapel ini?</p>
          </div>
          <div class="modal-footer">
              <form method="POST" action="{{ url('/admin/input-mata_pelajaran/'.$m->id)}}">
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