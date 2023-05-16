<nav class="main-header navbar navbar-expand navbar-light bg-warning">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link bg-warning" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/dashboard') }}" class="nav-link bg-warning">Dashboard</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/user') }}" class="nav-link bg-warning">User</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/mata-pelajaran') }}" class="nav-link bg-warning">Mata Pelajaran</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item user-panel">
            {{-- <a data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button"> --}}
                <div class="mt-1 d-flex">
                    <div class="profile rounded mr-2">
                        @if (Auth::user()->username == "admin")
                            <img src="https://static.vecteezy.com/system/resources/thumbnails/019/900/322/small/happy-young-cute-illustration-face-profile-png.png" class="elevation-2 img-fluid" alt="User Image" style="object-fit: cover; cursor: pointer;" data-toggle="modal" data-target="#profileModal">
                        @else
                            <img src="{{ asset('storage/'.$user->foto) }}" class="elevation-2 img-fluid" alt="User Image" style="object-fit: cover; cursor: pointer;" data-toggle="modal" data-target="#profileModal">
                        @endif
                    </div>                
                </div>                
        </li>
    </ul>
  </nav>
  <!-- Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="profileModalLabel">{{ Auth::user()->name }}</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="text-center">
            @if (Auth::user()->username == "admin")
              <img src="https://static.vecteezy.com/system/resources/thumbnails/019/900/322/small/happy-young-cute-illustration-face-profile-png.png" class="img-thumbnail img-fluid rounded" alt="User Image">
            @else
              <img src="{{ asset('storage/'.$user->foto) }}" class="img-thumbnail img-fluid rounded" alt="User Image">
            @endif
          </div>
          <p class="text-muted text-center">
            @php
                $userLevels = [
                    0 => 'Admin',
                    1 => 'Guru',
                    2 => 'Siswa',
                ];
            @endphp

            {{ $userLevels[Auth::user()->level_user] ?? 'Unknown' }}
          </p>
          <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>Name</b> <span class="float-right">
                    @if (Auth::user()->username == "admin")
                        admin
                    @else
                        {{ $user->name }}
                    @endif
                </span>
            </li>
            <li class="list-group-item">
                <b>Username</b> <span class="float-right">
                    @if (Auth::user()->username == "admin")
                        admin
                    @else
                        {{ $user->username }}
                    @endif
                </span>
            </li>
            <li class="list-group-item">
                <b>Email</b> <span class="float-right">
                    @if (Auth::user()->username == "admin")
                        admin@admin.com
                    @else
                        {{ $user->email }}
                    @endif
                </span>
            </li>
          </ul>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fas fa-close"></i></button>
            <a class="btn btn-primary btn-sm" href="{{ url('/logout') }}" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </div>
      </div>
    </div>
  </div>