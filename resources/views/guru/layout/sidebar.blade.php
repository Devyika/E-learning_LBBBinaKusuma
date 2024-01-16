<aside class="main-sidebar sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-warning">
      <img src="{{ asset('storage/file/img/default/logo_lbb.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                <a href="{{ url('guru/dashboard') }}" class="nav-link active bg-warning">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    {{-- <i class="right fas fa-angle-left"></i> --}}
                  </p>
                </a>
               </li>
              @if($kelas->count() > 0)
              @foreach($kelas as $i => $k)
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-chalkboard pr-2"></i>
                  <p>
                    {{$k->tingkat}} {{$k->jurusan}}
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                @if($mapel->count() > 0)
                @foreach($mapel as $i => $m)
                @if ($m->kelas == $k->id_kelas)
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/guru/pertemuan/'.$m->id) }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>{{$m->nama}}</p>
                    </a>
                  </li>
                </ul>
                @endif
                @endforeach
                @else
                
                @endif
              </li>
              @endforeach
              @else
                
              @endif
              
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>