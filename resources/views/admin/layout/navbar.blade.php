<nav class="main-header navbar navbar-expand navbar-light bg-primary">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link bg-primary" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/dashboard') }}" class="nav-link bg-primary">Dashboard</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/user') }}" class="nav-link bg-primary">User</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ url('/dashboard') }}" class="nav-link bg-primary">Mata Pelajaran</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item user-panel">
            <a data-widget="control-sidebar" data-controlsidebar-slide="true" href="#" role="button">
            <div class="mt-1 d-flex">
                <div class="image">
                <img src="{{ asset('assets/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ url('/logout') }}" role="button">
                <i class="fas fa-sign-out-alt"></i>
            </a>
        </li>
    </ul>
  </nav>