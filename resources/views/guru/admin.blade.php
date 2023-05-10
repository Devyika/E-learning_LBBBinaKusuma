@extends('guru.layout.template')

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
                <div class="card-tools">
                  <div class="input-group input-group-sm" style="width: 300px;">
                    <input type="text" name="table_search" class="form-control float-right" placeholder="Search">

                    <div class="input-group-append">
                      <button type="submit" class="btn btn-default">
                        <i class="fas fa-search"></i>
                      </button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0" style="height: 300px;">
                <table class="table table-head-fixed text-nowrap">
                  <thead>
                    <tr>
                      <th>No</th>
                      <th>Username</th>
                      <th>Nama</th>
                      <th>Email</th>
                      <th>Level User</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if($adm->count() > 0)
                      @foreach($adm as $i => $a)
                        <tr>
                          <td>{{++$i}}</td>
                          <td>{{$a->username}}</td>
                          <td>{{$a->name}}</td>
                          <td>{{$a->email}}</td>
                          <td>
                            @if($a->level_user == 0)
                                <p>Admin</p>
                            @elseif($a->level_user == 1)
                                <p>Guru</p>
                            @elseif($a->level_user == 2)
                                <p>Siswa</p>
                            @endif
                          </td>
                          <td>
                            <a href="{{ url('/admin/'. $a->id.'/edit')}}" class="btn btn-sm btn-warning">edit</a>
                            
                            <form method="POST" action="{{ url('/admin/'.$a->id)}}">
                              @csrf
                              @method('DELETE')
                              <button type="submit" class="btn btn-sm btn-danger">hapus</button>
                            </form>
                          </td>
                        </tr>
                      @endforeach
                    @else
                        <tr><td colspan="6" class="text-center">Data Tidak Ada</td></tr>
                    @endif
                  </tbody>

                </table>
              </div>
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
@endsection