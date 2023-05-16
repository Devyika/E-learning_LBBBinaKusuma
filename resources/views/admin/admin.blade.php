@extends('admin.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Master User</h1>
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

    <div class="card card-default">
      <div class="card-header">
        <h3 class="card-title">Data Admin</h3>

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
                <button type="button" class="btn btn-success float-right" data-toggle="modal" data-target="#addAdminModal">
                  <i class="fa-solid fa-plus"></i>
                </button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>No.</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>Level User</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    @if ($admin->count() > 0)
                      @foreach ($admin as $i => $a)
                      <tr>
                        <td>{{++$i}}</td>
                        <td>{{$a->username}}</td>
                        <td>{{$a->name}}</td>
                        <td>{{$a->level_user}}</td>
                        <td class="d-flex justify-content-around">
                          <button type="button" class="btn btn-info" data-toggle="modal" data-target="#detailModal{{$a->id}}">
                            <i class="fa-solid fa-circle-info"></i>
                          </button>
                          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editAdminModal-{{ $a->id }}">
                            <i class="fa-solid fa-pen-to-square"></i>
                          </button>
                          <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteAdminModal-{{ $a->id }}">
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
                    <th>Username</th>
                    <th>Name</th>
                    <th>Level User</th>
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
<div class="modal fade" id="addAdminModal" tabindex="-1" role="dialog" aria-labelledby="addAdminModal-label" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addAdminModal-label"><strong>Tambah Admin</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addAdminForm" method="POST" action="{{ url('admin/admin') }}" enctype="multipart/form-data">
          @csrf
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <div class="image-preview img-fluid rounded">
                  <img id="photo-preview" src="https://fakeimg.pl/354x472?text=Photo&font=lobster" alt="Foto Profile">
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control @error('username') is-invalid @enderror" id="username" name="username" value="{{ old('username') }}" placeholder="Masukkan Username">
                @error('username')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" placeholder="Masukkan Nama">
                @error('name')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" placeholder="Masukkan Email">
                @error('email')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="level_user">Level User</label>
                <input type="text" class="form-control @error('level_user') is-invalid @enderror" id="level_user" name="level_user" value="{{ old('level_user') }}" placeholder="Masukkan Level User">
                @error('level_user')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password">
                @error('password')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="foto">Foto Profile</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="photo" name="foto" accept="image/*" onchange="previewPhotoCreate()" style="padding: 0; height: 100%;">
                @error('foto')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary" form="addAdminForm"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>

                       
@foreach ($admin as $a)
<div class="modal fade" id="detailModal{{$a->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{$a->id}}" aria-hidden="true">
  <div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel{{$a->id}}"><strong>Detail Admin </strong>{{$a->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-6">
            <img src="{{asset('storage/'.$a->foto)}}" alt="{{ $a->name }}" class="img-fluid rounded">
          </div>
          <div class="col-md-6">
            <label><strong>Username</strong></label>
            <p>{{$a->username}}</p>
            <label><strong>Name</strong></label>
            <p>{{$a->name}}</p>
            <label><strong>Email</strong></label>
            <p>{{$a->email}}</p> 
          </div>                                
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
      </div>
    </div>
  </div>
</div>
@endforeach
          
@foreach ($admin as $a)
<div class="modal fade" id="editAdminModal-{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="editAdminModal-label-{{ $a->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editAdminModal-label-{{ $a->id }}"><strong>Edit Admin </strong>{{ $a->name }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editAdminForm-{{ $a->id }}" method="POST" action="{{ url('/admin/admin/'. $a->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="row">
            <div class="col-md-4">
              <div class="form-group">
                <div class="image-preview img-fluid rounded">
                  <img id="photo-preview-{{ $a->id }}" src="{{ asset('storage/' . $a->foto) }}" alt="Foto Profile">
                </div>
              </div>
            </div>
            <div class="col-md-8">
              <div class="form-group">
                <label for="name">Nama</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $a->name) }}" placeholder="Masukkan Nama">
                @error('name')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $a->email) }}" placeholder="Masukkan Email">
                @error('email')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" placeholder="Masukkan Password">
                @error('password')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
              <div class="form-group">
                <label for="foto">Foto Profile</label>
                <input type="file" class="form-control @error('foto') is-invalid @enderror" id="photo-{{ $a->id }}" name="foto" accept="image/*" onchange="previewPhotoEdit({{ $a->id }})" style="padding: 0; height: 100%;">
                @error('foto')
                  <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
        <button type="submit" class="btn btn-primary" form="editAdminForm-{{ $a->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>                              
  </div>
</div>   
@endforeach

@foreach ($admin as $a)
<div class="modal fade" id="deleteAdminModal-{{ $a->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteAdminModal-label-{{ $a->id }}" aria-hidden="true">
  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteAdminModal-label-{{ $a->id }}"><strong>Hapus Admin </strong>{{ $a->name }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p>Anda yakin ingin menghapus admin ini?</p>
          </div>
          <div class="modal-footer">
              <form method="POST" action="{{ url('/admin/admin/'.$a->id)}}">
                  @csrf
                  @method('DELETE')
                  <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
                  <button type="submit" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button>
              </form>
          </div>
      </div>
  </div>
</div>     
@endforeach                          

@endsection