<!DOCTYPE html>
<html lang="en">
<head>
  <title>Website Pembelajaran Online LMS</title>
  <!-- Load Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
</head>
<body>
  <!-- Navigation Bar -->
  <nav class="navbar navbar-expand-lg navbar-light bg-light px-5">
    <div class="collapse navbar-collapse d-flex justify-content-between" id="navbarNav">
    <a class="navbar-brand" href="#">Brand</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <ul class="navbar-nav">
        <li class="nav-item active">
          <a class="nav-link" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>
      </ul>
    </div>
  </nav>  

  <!-- Banner -->
  <div class="jumbotron">
    <h1 class="display-4">Mulailah Belajar Online Sekarang!</h1>
    <p class="lead">Dengan website LMS, kamu bisa belajar kapan saja dan di mana saja.</p>
    <hr class="my-4">
    <p>Kami memiliki banyak kelas-kelas menarik yang bisa kamu ikuti.</p>
    <a class="btn btn-primary btn-lg" href="{{ url('/login') }}" role="button">Mulai Belajar</a>
  </div>

  <!-- Kelas Populer -->
  <div class="container">
    <h2>Jurusan</h2>
    <div class="row mb-3">
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <img class="card-img-top" src="https://via.placeholder.com/350x200" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Kelas Bisnis</h5>
            <p class="card-text">Pelajari bagaimana memulai bisnis dan mengelola keuangan.</p>
            <a href="#" class="btn btn-primary">Lihat Kelas</a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card mb-4 shadow-sm">
          <img class="card-img-top" src="https://via.placeholder.com/350x200" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Kelas Teknologi</h5>
            <p class="card-text">Pelajari pemrograman dan pengembangan aplikasi.</p>
            <a href="#" class="btn btn-primary">Lihat Kelas</a>
          </div>
        </div>
      </div>
    </div>
  </body>
  <div class="container">
    <h2>Kelas</h2>
    <div class="row mb-3">
      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <img class="card-img-top" src="https://via.placeholder.com/350x200" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Kelas Bisnis</h5>
            <p class="card-text">Pelajari bagaimana memulai bisnis dan mengelola keuangan.</p>
            <a href="#" class="btn btn-primary">Lihat Kelas</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <img class="card-img-top" src="https://via.placeholder.com/350x200" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Kelas Teknologi</h5>
            <p class="card-text">Pelajari pemrograman dan pengembangan aplikasi.</p>
            <a href="#" class="btn btn-primary">Lihat Kelas</a>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card mb-4 shadow-sm">
          <img class="card-img-top" src="https://via.placeholder.com/350x200" alt="Card image cap">
          <div class="card-body">
            <h5 class="card-title">Kelas Teknologi</h5>
            <p class="card-text">Pelajari pemrograman dan pengembangan aplikasi.</p>
            <a href="#" class="btn btn-primary">Lihat Kelas</a>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>