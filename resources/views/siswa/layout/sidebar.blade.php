<aside class="main-sidebar sidebar-light-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/') }}" class="brand-link bg-warning">
      <img src="http://siakad.polinema.ac.id/assets/global/img/logo-polinema.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">LMS | Admin {{$user->id}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
              @foreach ($mapelSiswa as $m)
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-book-open pr-2"></i>
                  <p>{{$m->id_siswa}}
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/siswa/pertemuan/'.$m->id) }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p></p>
                    </a>
                  </li>
                </ul>
                @endforeach
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>