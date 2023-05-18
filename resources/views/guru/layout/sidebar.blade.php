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
              <li class="nav-header">KELAS</li>
              @if($kelas->count() > 0)
              @foreach($kelas as $i => $k)
              <li class="nav-item">
                <a href="" class="nav-link">
                  <i class="fas fa-book-open pr-2"></i>
                  <p>
                    {{$k->nama}}
                    <i class="fas fa-angle-left right"></i>
                  </p>
                </a>
                @if($mapel->count() > 0)
                @foreach($mapel as $i => $m)
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{ url('/guru/pertemuan/'.$m->id) }}" class="nav-link">
                      <i class="fas fa-book pr-2"></i>
                      <p>{{$m->nama}}</p>
                    </a>
                  </li>
                </ul>
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