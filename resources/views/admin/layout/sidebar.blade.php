<aside class="main-sidebar sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-warning">
      <img src="http://siakad.polinema.ac.id/assets/global/img/logo-polinema.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
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
                <a href="{{ url('admin/dashboard') }}" class="nav-link active bg-warning">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    {{-- <i class="right fas fa-angle-left"></i> --}}
                  </p>
                </a>
                {{-- <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/admin/master-user') }}" class="nav-link">
                      <i class="fas fa-users pr-2"></i>
                      <p>User</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/mata-pelajaran') }}" class="nav-link">
                      <i class="fas fa-book-open pr-2"></i>
                      <p>Mata Pelajaran</p>
                    </a>
                  </li>
                </ul> --}}
              </li>
              <li class="nav-header">INPUT</li>
              <li class="nav-item">
                <a href="{{ url('admin/input-admin') }}" class="nav-link">
                  <i class="fas fa-user-shield pr-2"></i>
                  <p>
                    Admin
                    <span class="badge badge-info right">{{ $countAdmin }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/input-guru') }}" class="nav-link">
                  <i class="fas fa-chalkboard-teacher pr-2"></i>
                  <p>
                    Guru
                    <span class="badge badge-info right">{{ $countGuru }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/input-siswa') }}" class="nav-link">
                  <i class="fas fa-user-graduate pl-1 pr-2"></i>
                  <p>
                    Siswa
                    <span class="badge badge-info right">{{ $countSiswa }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/input-jurusan') }}" class="nav-link">
                  <i class="fas fa-scroll pr-2"></i>
                  <p>
                    Jurusan
                    <span class="badge badge-info right">{{ $countJurusan }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/input-tingkat') }}" class="nav-link">
                  <i class="fa-solid fa-layer-group pr-2"></i>
                  <p>
                    Tingkat
                    <span class="badge badge-info right">{{ $countTingkat }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/input-kelas') }}" class="nav-link">
                  <i class="fas fa-chalkboard pr-2"></i>
                  <p>
                    Kelas
                    <span class="badge badge-info right">{{ $countKelas }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/input-mata_pelajaran') }}" class="nav-link">
                  <i class="fa-solid fa-lines-leaning pr-2"></i>
                  <p>
                    Mata Pelajaran
                    <span class="badge badge-info right">{{ $countMapel }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-header">SETTING</li>
              <li class="nav-item">
                <a href="{{ url('admin/setting-kelas') }}" class="nav-link">
                  <i class="fas fa-chalkboard pr-2"></i>
                  <p>
                    Kelas
                    <i class="fa-solid fa-angles-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @foreach($allTingkat as $t)
                  <li class="nav-item">
                    <a href="{{ url('/admin/setting-kelas/'.$t->id) }}" class="nav-link">
                      <i class="fa-solid fa-table pr-2"></i>
                      <p>{{ $t->name }}</p>
                      <i class="fa-solid fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                      @foreach($allJurusan as $j)
                      <li class="nav-item">
                        <a href="{{ url('/admin/setting-kelas/'.$t->id.'/'.$j->id) }}" class="nav-link">
                          <i class="fa-solid fa-table-columns pr-2"></i>
                          <p>{{ $t->name }} {{ $j->name }}</p>
                        </a>
                      </li>
                      @endforeach
                    </ul>
                  </li>
                  @endforeach
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/setting-mata_pelajaran') }}" class="nav-link">
                  <i class="fa-solid fa-lines-leaning pr-2"></i>
                  <p>
                    Mata Pelajaran
                    <i class="fa-solid fa-angles-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @foreach($allTingkat as $t)
                  <li class="nav-item">
                    <a href="{{ url('/admin/setting-mata_pelajaran/'.$t->id) }}" class="nav-link">
                      <i class="fa-solid fa-table pr-2"></i>
                      <p>{{ $t->name }}</p>
                      <i class="fa-solid fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                      @foreach($allJurusan as $j)
                      <li class="nav-item">
                        <a href="{{ url('/admin/setting-mata_pelajaran/'.$t->id.'/'.$j->id) }}" class="nav-link">
                          <i class="fa-solid fa-table-columns pr-2"></i>
                          <p>{{ $t->name }} {{ $j->name }}</p>
                        </a>
                      </li>
                      @endforeach
                    </ul>
                  </li>
                  @endforeach
                </ul>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/setting-siswa') }}" class="nav-link">
                  <i class="fas fa-user-graduate pr-2"></i>
                  <p>
                    Siswa
                    <i class="fa-solid fa-angles-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  @foreach($allTingkat as $t)
                  <li class="nav-item">
                    <a href="{{ url('/admin/setting-siswa/'.$t->id) }}" class="nav-link">
                      <i class="fa-solid fa-table pr-2"></i>
                      <p>{{ $t->name }}</p>
                      <i class="fa-solid fa-angle-left right"></i>
                    </a>
                    <ul class="nav nav-treeview">
                      @foreach($allJurusan as $j)
                      <li class="nav-item">
                        <a href="{{ url('/admin/setting-siswa/'.$t->id.'/'.$j->id) }}" class="nav-link">
                          <i class="fa-solid fa-table-columns pr-2"></i>
                          <p>{{ $t->name }} {{ $j->name }}</p>
                        </a>
                      </li>
                      @endforeach
                    </ul>
                  </li>
                  @endforeach
                </ul>
              </li>
              
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-book-open pr-2"></i>
                  <p>
                    IPS
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Kelas</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Mata Pelajaran</p>
                    </a>
                  </li>
                </ul>
              </li> --}}
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>