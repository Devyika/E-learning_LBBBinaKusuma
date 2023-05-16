<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link bg-primary">
      <img src="http://siakad.polinema.ac.id/assets/global/img/logo-polinema.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Proyek_1</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              <li class="nav-item menu-open">
                <a href="#" class="nav-link active">
                  <i class="nav-icon fas fa-tachometer-alt"></i>
                  <p>
                    Dashboard
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/guru/profile') }}" class="nav-link">
                      <i class="fas fa-users pr-2"></i>
                      <p>Profil</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/guru/#') }}" class="nav-link">
                      <i class="fas fa-book-open pr-2"></i>
                      <p>---</p>
                    </a>
                  </li>
                </ul>
              </li>
              <li class="nav-header">Kelas</li>
              <li class="nav-item">
                <a href="{{ url('/admin') }}" class="nav-link">
                  <i class="fas fa-user-shield pr-2"></i>
                  <p>
                    Admin
                    <span class="badge badge-info right">1</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/guru') }}" class="nav-link">
                  <i class="fas fa-chalkboard-teacher pr-2"></i>
                  <p>
                    Guru
                    <span class="badge badge-info right">1</span>
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/siswa') }}" class="nav-link">
                  <i class="fas fa-user-graduate pl-1 pr-2"></i>
                  <p>
                    Siswa
                    <span class="badge badge-info right">1</span>
                  </p>
                </a>
              </li>
              <li class="nav-header">JURUSAN</li>
              <li class="nav-item">
                <a href="" class="nav-link">
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
                      <p>PKn</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Agama</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Matematika</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Bhs. Indonesia</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Kimia</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Fisika</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Biologi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Bhs. Inggris</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Bhs. Jawa</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ipa/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Penjaskes</p>
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
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>PKn</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Agama</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Matematika</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Bhs. indonesia</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Ekonomi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Sosiologi</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Sejarah</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Bhs. Inggris</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Bhs. Jawa</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{ url('/ips/') }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>Penjaskes</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>