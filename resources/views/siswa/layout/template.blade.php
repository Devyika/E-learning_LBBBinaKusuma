<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>LMS | SMA Negeri 4 Probolinggo | @php
    $userLevels = [
      0 => 'Admin',
      1 => 'Guru',
      2 => 'Siswa',
    ];
    @endphp
    {{ $userLevels[Auth::user()->level_user] ?? 'Developer' }} | {{ Auth::user()->username }}</title>
  <link rel="icon" href="http://siakad.polinema.ac.id/assets/global/img/logo-polinema.png" sizes="32x32" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome-free/css/all.min.css') }}">
  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets/dist/css/adminlte.min.css') }}">
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">    
  <style>
    .image-preview {
        width: 250px;
        height: 250px;
        overflow: hidden;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
    }

    .profile {
        width: 35px;
        height: 35px;
        overflow: hidden;
    }

    .profile img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        object-position: top;
    }

    .card-warning {
      color: #ffffff!important;
    }

    .bg-warning {
      color: #ffffff!important;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }
    .dropdown-menu .dropdown-item:hover {
        background-color: #ffc107;
        color: #fff;
    }
</style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader d-flex justify-content-center align-items-center">
    <div class="spinner-border text-warning" role="status">
      <span class="visually-hidden"></span>
    </div>
  </div>

  <!-- Navbar -->
  @include('siswa.layout.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('siswa.layout.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        @yield('content')
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  @include('siswa.layout.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-light">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.7.570/pdf.min.js"></script>
<script src="{{ asset('/assets/plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- DataTables  & Plugins -->
<script src="{{ asset('/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('/assets/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/assets/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
{{-- <script src="{{ asset('/assets/dist/js/demo.js') }}"></script> --}}
<!-- Page specific script -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
  $(function () {
    $("#example1").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": [
            {
                extend: 'copy',
                exportOptions: {
                    columns: ':not(:last-child)' // Menyertakan semua kolom kecuali kolom terakhir
                }
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':not(:last-child)' // Menyertakan semua kolom kecuali kolom terakhir
                }
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':not(:last-child)' // Menyertakan semua kolom kecuali kolom terakhir
                }
            },
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':not(:last-child)' // Menyertakan semua kolom kecuali kolom terakhir
                }
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':not(:last-child)' // Menyertakan semua kolom kecuali kolom terakhir
                }
            },
            "colvis"
        ]
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

    $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": false,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
  });

        function previewPhotoCreate() {
          const photo = document.getElementById('photo').files[0];
          const photoPreview = document.getElementById('photo-preview');
          const reader = new FileReader();
          
          reader.addEventListener('load', function () {
            photoPreview.src = reader.result;
          }, false);
          
          if (photo) {
            reader.readAsDataURL(photo);
          }
        }

        function previewPhotoEdit(id) {
        const photo = document.getElementById('photo-' + id).files[0];
        const photoPreview = document.getElementById('photo-preview-' + id);
        const reader = new FileReader();

        reader.addEventListener('load', function () {
            photoPreview.src = reader.result;
        }, false);

        if (photo) {
            reader.readAsDataURL(photo);
        }
        }

        function triggerFileInput() {
          document.getElementById('photo').click();
        }
        
        function previewPDF() {
    var file = document.querySelector('#file').files[0];
    var previewContainer = document.querySelector('#preview');

    if (file) {
      var fileReader = new FileReader();

      fileReader.onload = function () {
        var typedarray = new Uint8Array(this.result);

        pdfjsLib.getDocument(typedarray).promise.then(function (pdf) {
          pdf.getPage(1).then(function (page) {
            var scale = 0.5;
            var viewport = page.getViewport({ scale: scale });

            var canvas = document.createElement('canvas');
            var context = canvas.getContext('2d');
            canvas.height = viewport.height;
            canvas.width = viewport.width;

            var renderContext = {
              canvasContext: context,
              viewport: viewport
            };

            page.render(renderContext).promise.then(function () {
              var dataURL = canvas.toDataURL();

              var image = new Image();
              image.src = dataURL;
              image.height = viewport.height * scale; // Set the desired height for the preview image
              image.title = file.name;

              previewContainer.innerHTML = '';
              previewContainer.appendChild(image);
            });
          });
        });
      };

      fileReader.readAsArrayBuffer(file);
    }
  }
</script>
</body>
</html>
