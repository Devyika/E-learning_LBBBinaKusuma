<aside class="main-sidebar sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link bg-warning">
      <img src="http://siakad.polinema.ac.id/assets/global/img/logo-polinema.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LMS | Admin</span>
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
              <li class="nav-header">USER</li>
              <li class="nav-item">
                <a href="{{ url('admin/user-admin') }}" class="nav-link">
                  <i class="fas fa-user-shield pr-2"></i>
                  <p>
                    Admin
                    <span class="badge badge-info right">{{ $countAdmin }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/user-guru') }}" class="nav-link">
                  <i class="fas fa-chalkboard-teacher pr-2"></i>
                  <p>
                    Guru
                    <span class="badge badge-info right">{{ $countGuru }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/user-siswa') }}" class="nav-link">
                  <i class="fas fa-user-graduate pl-1 pr-2"></i>
                  <p>
                    Siswa
                    <span class="badge badge-info right">{{ $countSiswa }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-header">SEKOLAH</li>
              <li class="nav-item">
                <a href="{{ url('admin/sekolah-jurusan') }}" class="nav-link">
                  <i class="fas fa-scroll pr-2"></i>
                  <p>
                    Jurusan
                    <span class="badge badge-info right">{{ $countJurusan }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/sekolah-kelas') }}" class="nav-link">
                  <i class="fas fa-chalkboard pr-2"></i>
                  <p>
                    Kelas
                    <span class="badge badge-info right">{{ $countKelas }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/sekolah-mata_pelajaran') }}" class="nav-link">
                  <i class="fas fa-swatchbook pr-2"></i>
                  <p>
                    Mata Pelajaran
                    <span class="badge badge-info right">{{ $countAdmin }}</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/sekolah-pertemuan') }}" class="nav-link">
                  <i class="fas fa-comment-alt pr-2"></i>
                  <p>
                    Pertemuan
                    <span class="badge badge-info right">{{ $countAdmin }}</span>
                  </p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="fas fa-book-open pr-2"></i>
                  <p>
                    IPA
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
              </li>
              <li class="nav-item">
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