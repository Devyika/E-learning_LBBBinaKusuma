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
        <li class="breadcrumb-item active">Tingkat</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Tingkat</h3>

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
                <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addTingkatModal">
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th style="width: 5%;">No.</th>
                    <th style="width: 80%;">Nama Tingkat</th>
                    <th style="width: 15%;">Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @if ($tingkat->count() > 0)
                      @foreach ($tingkat as $i => $t)
                      <tr>
                        <td class="text-center">{{++$i}}</td>
                        <td>{{$t->name}}</td>
                        <td class="d-flex justify-content-around">
                          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{$t->id}}">
                            <i class="fa-solid fa-circle-info"></i>
                          </button>
                          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editTingkatModal-{{ $t->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteTingkatModal-{{ $t->id }}">
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
                    <th>Nama Tingkat</th>
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
<div class="modal fade" id="addTingkatModal" tabindex="-1" role="dialog" aria-labelledby="addTingkatModal-label" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTingkatModal-label"><strong>Tambah Tingkat</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addTingkatForm" method="POST" action="{{ url('admin/input-tingkat') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="name">Nama Tingkat</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama">
            @error('name')
              <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
          </div>              
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="addTingkatForm"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
                       
@foreach ($tingkat as $t)
<div class="modal fade" id="detailModal{{$t->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{$t->id}}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel{{$t->id}}"><strong>Detail Tingkat </strong>{{$t->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <label><strong>Nama Tingkat</strong></label>
        <p>{{$t->name}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
      </div>
    </div>
  </div>
</div>
@endforeach
          
@foreach ($tingkat as $t)
<div class="modal fade" id="editTingkatModal-{{ $t->id }}" tabindex="-1" role="dialog" aria-labelledby="editTingkatModal-label-{{ $t->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editTingkatModal-label-{{ $t->id }}"><strong>Edit Tingkat </strong>{{ $t->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editTingkatForm-{{ $t->id }}" method="POST" action="{{ url('/admin/input-tingkat/'. $t->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="name">Nama Tingkat</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $t->name) }}" placeholder="Masukkan Nama">
            @error('name')
              <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary btn-sm" form="editTingkatForm-{{ $t->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>                              
  </div>
</div>   
@endforeach

@foreach ($tingkat as $t)
<div class="modal fade" id="deleteTingkatModal-{{ $t->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteTingkatModal-label-{{ $t->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteTingkatModal-label-{{ $t->id }}"><strong>Hapus Tingkat </strong>{{ $t->name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p>Anda yakin ingin menghapus Tingkat ini?</p>
          </div>
          <div class="modal-footer">
              <form method="POST" action="{{ url('/admin/input-tingkat/'.$t->id)}}">
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