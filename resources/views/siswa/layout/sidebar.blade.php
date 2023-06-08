<aside class="main-sidebar sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-warning">
      <img src="{{ asset('storage/file/img/default/logo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LMS | 
        @php
        $userLevels = [
          0 => 'Admin',
          1 => 'Guru',
          2 => 'Siswa',
        ];
        @endphp
        {{ $userLevels[Auth::user()->level_user] ?? 'Developer' }}
      </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
               <li class="nav-item menu-open">
                <a href="{{ url('siswa/dashboard') }}" class="nav-link active bg-warning">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    {{-- <i class="right fas fa-angle-left"></i> --}}
                  </p>
                </a>
               </li>
              @php
              $kelas = $allKelasSiswa->where('id_siswa', $user->id)->pluck('id_jurusanTingkatKelas')->first();
              $mapel = $allKelasMapel->where('id_jurusanTingkatKelas', '=', $kelas);
              @endphp
              @foreach ($mapel as $m)
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-book pr-2"></i>
                  <p>{{ $m->mapel->nama }}
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @foreach ($pertemuanSidebar as $p)
                  @if ($p->id_mapel == $m->mapel->id)
                  <li class="nav-item">
                    <a href="{{ url('/siswa/pertemuan/'.$p->id) }}" class="nav-link">
                      <i class="fas fa-book-open pr-2"></i>
                      <p>{{$p->nama}}</p>
                    </a>
                  </li>
                  @endif
                  @endforeach
                </ul>
              </li>
              @endforeach
            </ul>        
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>