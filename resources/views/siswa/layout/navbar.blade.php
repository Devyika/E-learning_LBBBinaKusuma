<nav class="main-header navbar navbar-expand navbar-light bg-warning">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link bg-warning" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        {{-- <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/dashboard') }}" class="nav-link bg-warning">Dashboard</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/user') }}" class="nav-link bg-warning">User</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/mata-pelajaran') }}" class="nav-link bg-warning">Mata Pelajaran</a>
        </li> --}}
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <div class="dropdown">
                <div class="mt-1 d-flex" role="button" id="profileDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="profile rounded-circle mr-2">
                        @if (Auth::user()->username == "admin")
                            <img src="https://static.vecteezy.com/system/resources/thumbnails/019/900/322/small/happy-young-cute-illustration-face-profile-png.png" class="elevation-2 img-fluid img-thumbnail rounded-circle" alt="User Image">
                        @else
                            <img src="{{ asset('storage/'.$user->foto) }}" class="elevation-2 img-fluid img-thumbnail rounded-circle" alt="User Image">
                        @endif
                    </div>
                </div>
                <div class="dropdown-menu dropdown-menu-right fade" style="min-width: 0; border: none; padding: 0;">
                    <a class="dropdown-item btn btn-warning" data-toggle="modal" data-target="#detailModal">
                        <i class="fas fa-info-circle mr-2"></i> Detail
                    </a>
                    @if (Auth::user()->username == "admin")
                    <a class="dropdown-item btn btn-warning" data-toggle="modal" data-target="" style="pointer-events: none; cursor: default; opacity: 0.5;">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>                    
                    @else
                    <a class="dropdown-item btn btn-warning" data-toggle="modal" data-target="#editModal-{{ $user->id }}">
                        <i class="fas fa-edit mr-2"></i> Edit
                    </a>
                    @endif
                    <a class="dropdown-item btn btn-warning" href="{{ url('/logout') }}">
                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                    </a>
                </div>              
            </div>
        </li>
    </ul>
    </nav>
  <!-- Modal -->
  <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="detailModalLabel">Detail @if (Auth::user()->username == "admin")
                    admin
                @else
                    {{ $user->name }}
                @endif</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="image-preview">
                        @if (Auth::user()->username == "admin")
                            <img src="https://static.vecteezy.com/system/resources/thumbnails/019/900/322/small/happy-young-cute-illustration-face-profile-png.png" class="img-thumbnail rounded-circle" alt="User Image">
                        @else
                            <img src="{{ asset('storage/'.$user->foto) }}" class="img-thumbnail rounded-circle" alt="User Image">
                        @endif
                    </div>
                </div>
                <p class="text-muted text-center mb-4">
                    @php
                        $userLevels = [
                            0 => 'Admin',
                            1 => 'Guru',
                            2 => 'Siswa',
                        ];
                    @endphp
                    {{ $userLevels[Auth::user()->level_user] ?? 'Unknown' }}
                </p>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <b>Name</b>
                            <span>
                                @if (Auth::user()->username == "admin")
                                    admin
                                @else
                                    {{ $user->name }}
                                @endif
                            </span>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <b>Username</b>
                            <span>
                                @if (Auth::user()->username == "admin")
                                    admin
                                @else
                                    {{ $user->username }}
                                @endif
                            </span>
                        </div>
                    </li>
                    <li class="list-group-item">
                        <div class="d-flex justify-content-between align-items-center">
                            <b>Email</b>
                            <span>
                                @if (Auth::user()->username == "admin")
                                    admin@admin.com
                                @else
                                    {{ $user->email }}
                                @endif
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-times"></i></button>            </div>
        </div>
    </div>
</div>

@if (Auth::user()->username != "admin")
<div class="modal fade" id="editModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal-{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModal-{{ $user->id }}">Edit Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="d-flex justify-content-center">
                    <div class="image-preview">
                        @if (Auth::user()->username == "admin")
                            <img  id="photo-preview" src="https://static.vecteezy.com/system/resources/thumbnails/019/900/322/small/happy-young-cute-illustration-face-profile-png.png" class="img-thumbnail rounded-circle" alt="User Image">
                        @else
                            <img id="photo-preview-{{ $user->id }}" src="{{ asset('storage/'.$user->foto) }}" class="img-thumbnail rounded-circle" alt="User Image">
                        @endif
                    </div>
                </div>
                @php
                $userLevels = [
                    0 => 'admin',
                    1 => 'guru',
                    2 => 'siswa',
                ];

                $level = $userLevels[Auth::user()->level_user] ?? 'unknown';
                @endphp
                <form  id="editForm-{{ $user->id }}" action="{{ url('/'.$level.'/user/'. $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="name">Nama</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan Nama">
                        @error('name')
                          <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan Email">
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
                        <input type="file" class="form-control @error('foto') is-invalid @enderror" id="photo-{{ $user->id }}" name="foto" accept="image/*" onchange="previewPhotoEdit({{ $user->id }})" style="padding: 0; height: 100%;">
                        @error('foto')
                          <span class="invalid-feedback" role="alert">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa-solid fa-close"></i></button>
                <button type="submit" class="btn btn-primary btn-sm" form="editForm-{{ $user->id }}"><i class="fa-solid fa-save"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>
@endif