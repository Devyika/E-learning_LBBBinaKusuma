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

<!-- Main content -->
<section class="content">
  <div class="container-fluid">
    <!-- SELECT2 EXAMPLE -->
    <div class="card card-default">
      <form method="POST" action="master-user">
        @csrf
        {!! (isset($user))? method_field('PUT') : ''!!}
      <div class="card-header">
        <h3 class="card-title">Form Input</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse">
            <i class="fas fa-minus"></i>
          </button>
        </div>
      </div>
      <!-- /.card-header -->
      <div class="card-body">
        <div class="row">
          <div class="col">
            <div class="form-group">
              <label>Nama</label>
              <input type="text" value="{{ isset($user)? $user->name : old('name') }}" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="name Lengkap">
              @error('name')
                <span class="error invalid-feedback">{{ $message }} </span>
              @enderror
            </div>

            <div class="form-group">
              <label>Email</label>
              <input type="email" value="{{ isset($user)? $user->email : old('email') }}" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="email">
              @error('email')
                <span class="error invalid-feedback">{{ $message }} </span>
              @enderror
            </div>
              
            <div class="form-group">
              <label>Level</label>
              <select class="form-control select2 @error('level_user') is-invalid @enderror" style="width: 100%;" name="level_user" value="{{ isset($user)? $user->level_user : old('level_user') }}">
                <option selected="selected" value=1>Guru</option>
                <option value=2>Siswa</option>
              </select>
              @error('level_user')
                <span class="error invalid-feedback">{{ $message }} </span>
              @enderror
            </div>

            <div class="form-group">
              <label>Username</label>
              <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" placeholder="Username" value="{{ isset($user)? $user->username : old('username') }}">
              @error('username')
                <span class="error invalid-feedback">{{ $message }} </span>
              @enderror
            </div>

            <div class="form-group">
              <label>Password</label>
              <input type="password" name="password" class="form-control @error('username') is-invalid @enderror" placeholder="Password">
              @error('password')
                <span class="error invalid-feedback">{{ $message }} </span>
              @enderror
            </div>

            <div class="form-group">
              <button type="submit" class="btn btn-primary" style="width: 10%">Submit</button>
            </div>
          </div>
          <!-- /.col -->
          
          <!-- /.col -->
        </div>
      </div>
      <!-- /.card-body -->
    
    </div>
    </form>
    <!-- /.card -->

    <!-- SELECT2 EXAMPLE -->
  </div>
</section>
<!-- /.content -->

  <!-- /.card-body -->
</div>
<!-- /.card -->
@endsection