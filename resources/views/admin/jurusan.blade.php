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
        <li class="breadcrumb-item active">Jurusan</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Program</h3>

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
                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addJurusanModal">
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 80%;">Nama Program</th>
                    <th style="width: 15%;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @if ($jurusan->count() > 0)
                      @foreach ($jurusan as $i => $j)
                      <tr>
                        <td class="text-center">{{++$i}}</td>
                        <td>{{$j->name}}</td>
                        <td class="d-flex justify-content-around">
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{$j->id}}">
                            <i class="fa-solid fa-circle-info"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editJurusanModal-{{ $j->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteJurusanModal-{{ $j->id }}">
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
                    <th>Nama Program</th>
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
<div class="modal fade" id="addJurusanModal" tabindex="-1" role="dialog" aria-labelledby="addJurusanModal-label" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addJurusanModal-label"><strong>Tambah Data</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addJurusanForm" method="POST" action="{{ url('admin/input-jurusan') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="name">Nama Program</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama" required>
            @error('name')
              <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
          </div>        
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="addJurusanForm"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
                       
@foreach ($jurusan as $j)
<div class="modal fade" id="detailModal{{$j->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{$j->id}}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel{{$j->id}}"><strong>Detail Program </strong>{{$j->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label><strong>Nama Program</strong></label>
        <p>{{$j->name}}</p>
      </div>
      <div class="modal-footer">  
      </div>
    </div>
  </div>
</div>
@endforeach
          
@foreach ($jurusan as $j)
<div class="modal fade" id="editJurusanModal-{{ $j->id }}" tabindex="-1" role="dialog" aria-labelledby="editJurusanModal-label-{{ $j->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editJurusanModal-label-{{ $j->id }}"><strong>Edit Program </strong>{{ $j->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editJurusanForm-{{ $j->id }}" method="POST" action="{{ url('/admin/input-jurusan/'. $j->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="name">Nama Program</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $j->name) }}" placeholder="Masukkan Nama" required>
            @error('name')
              <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="editJurusanForm-{{ $j->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>                              
  </div>
</div>   
@endforeach

@foreach ($jurusan as $j)
<div class="modal fade" id="deleteJurusanModal-{{ $j->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteJurusanModal-label-{{ $j->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteJurusanModal-label-{{ $j->id }}"><strong>Hapus Program </strong>{{ $j->name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p>Anda yakin ingin menghapus Data program ini?</p>
          </div>
          <div class="modal-footer">
              <form method="POST" action="{{ url('/admin/input-jurusan/'.$j->id)}}">
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