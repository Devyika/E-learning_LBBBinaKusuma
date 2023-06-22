@extends('guru.layout.template')

@section('content')
@csrf
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Tugas Siswa</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Menu</a></li>
        <li class="breadcrumb-item active">Tugas</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content">

  <!-- Default box -->
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-header">
            <button class="btn btn-primary btn-sm" onclick="window.history.back()"><i class="fas fa-arrow-left mr-2"></i>Kembali</button>
            @foreach ($kelas2 as $m)
            <h3 class="card-title float-right"><b>Kelas :</b> {{$m->tingkat}} {{$m->jurusan}} {{$m->kelas}}  <b>&nbsp;&nbsp;|&nbsp;&nbsp;  Pelajaran :</b> {{$m->mapel}}</h3>
            @endforeach
          </div>
          <!-- ./card-header -->
          <div class="card-body p-0">
            <table class="table table-hover">
              <tbody>
                @foreach ($pertemuan as $p)
                <tr>
                  <td class="border-0">{{$p->pertemuan_nama}} - {{$p->tugas_nama}}</td>
                </tr>
                
                <tr class="expandable-body">
                  <td>
                    <div class="p-0">
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th style="width: 5%;">No.</th>
                          <th style="width: 20%;">Nama</th>
                          <th style="width: 30%;">Tugas</th>
                          <th style="width: 10%;">Nilai</th>
                          <th style="width: 35%;">Keterangan</th>
                        </tr>
                        </thead>
                        <tbody>
                          @if ($data->count() > 0)
                            @foreach ($data as $i => $d)
                            <tr>
                              <td class="text-center">{{++$i}}</td>
                              <td>{{$d->nama}}</td>
                              <td><a href="{{asset('storage/'.$d->file)}}" target="_blank" rel="noopener noreferrer">{{$d->tugas}}</a></td>
                              <td>
                                <form>
                                  @csrf
                                  <input type="hidden" name="id" value="{{$d->id}}">
                                  <input type="text" class="form-control" name="nilai{{$d->id}}" value="{{$d->nilai != -1 ? $d->nilai : ''}}" onkeydown="handleSaveNilai(event, this)">
                                </form>
                              </td>     
                              <td>
                                <form>
                                  @csrf
                                  <input type="hidden" name="id_keterangan" value="{{$d->id}}">
                                  <input type="text" class="form-control" name="keterangan{{$d->id}}" value="{{$d->keterangan}}" onkeydown="handleSaveKeterangan(event, this)">
                                </form>
                              </td>                     
                            </tr>
                            @endforeach
                          @else
                            <tr><td colspan="6" class="text-center">No matching records found</td></tr>
                          @endif
                        </tbody>
                      </table>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <!-- /.card-body -->
        </div>
        <!-- /.card -->
      </div>
    </div>
    <!-- /.row -->
  </div>

  {{-- --}}
  
  <script>
    var saveTimeout;

    function handleSaveNilai(event, input) {
    if (event.key === 'Enter') { // Tombol Enter ditekan
      event.preventDefault();
      clearTimeout(saveTimeout); // Clear any previous timeouts

      saveTimeout = setTimeout(function() {
        saveNilai(input);
      }, 0);
    }
  }

  function handleSaveKeterangan(event, input) {
    if (event.key === 'Enter') { // Tombol Enter ditekan
      event.preventDefault();
      clearTimeout(saveTimeout); // Clear any previous timeouts

      saveTimeout = setTimeout(function() {
        saveKeterangan(input);
      }, 0);
    }
  }

    function saveNilai(input) {
      var id = $(input).closest("form").find("input[name='id']").val();
      var nilai = $(input).val();
      var url = "{{ url('/guru/tugas-siswa/save-nilai') }}";

      var csrfToken = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: { id: id, nilai: nilai, _token: csrfToken },
        success: function(response) {
  if (response.success) {
    swal({
      title: 'Sukses!',
      text: "Keterangan berhasil disimpan",
      icon: 'success',
      timer: 1000, // Waktu (dalam milidetik) sebelum notifikasi ditutup
      buttons: false // Menyembunyikan tombol OK
    });
  } else {
    swal({
      title: 'Gagal!',
      text: "Gagal menyimpan keterangan",
      icon: 'error',
      timer: 1000, // Waktu (dalam milidetik) sebelum notifikasi ditutup
      buttons: false // Menyembunyikan tombol OK
    });
  }
},
error: function() {
  swal({
    title: 'Error',
    text: 'Terjadi kesalahan',
    icon: 'error',
    timer: 1000, // Waktu (dalam milidetik) sebelum notifikasi ditutup
    buttons: false // Menyembunyikan tombol OK
  });
}

      });
    }

    function saveKeterangan(input) {
      var id = $(input).closest("form").find("input[name='id_keterangan']").val();
      var keterangan = $(input).val();
      var url = "{{ url('/guru/tugas-siswa/save-keterangan') }}";

      var csrfToken = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: { id: id, keterangan: keterangan, _token: csrfToken },
        success: function(response) {
  if (response.success) {
    swal({
      title: 'Sukses!',
      text: "Keterangan berhasil disimpan",
      icon: 'success',
      timer: 1000, // Waktu (dalam milidetik) sebelum notifikasi ditutup
      buttons: false // Menyembunyikan tombol OK
    });
  } else {
    swal({
      title: 'Gagal!',
      text: "Gagal menyimpan keterangan",
      icon: 'error',
      timer: 1000, // Waktu (dalam milidetik) sebelum notifikasi ditutup
      buttons: false // Menyembunyikan tombol OK
    });
  }
},
error: function() {
  swal({
    title: 'Error',
    text: 'Terjadi kesalahan',
    icon: 'error',
    timer: 1000, // Waktu (dalam milidetik) sebelum notifikasi ditutup
    buttons: false // Menyembunyikan tombol OK
  });
}

      });
    }
  </script>   
@endsection
