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
                          <th style="width: 30%;">Nama</th>
                          <th style="width: 40%;">Tugas</th>
                          <th style="width: 15%;">Nilai</th>
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
                                  <input type="text" class="form-control" name="nilai{{$d->id}}" value="{{$d->nilai != -1 ? $d->nilai : ''}}" onkeyup="handleDelayedSaveNilai(this, 2000)">
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
  
  <script>
    var saveTimeout;

    function handleDelayedSaveNilai(input, delay) {
      clearTimeout(saveTimeout); // Membersihkan timeout sebelumnya jika ada

      saveTimeout = setTimeout(function() {
        saveNilai(input);
      }, delay);
    }

    function saveNilai(input) {
      var id = $(input).closest("form").find("input[name='id']").val();
      var nilai = $(input).val();
      var url = "{{ url('/guru/tugas-siswa/save-nilai') }}";
  
      // Mengambil token CSRF
      var csrfToken = $('meta[name="csrf-token"]').attr('content');
  
      // Mengirim permintaan AJAX untuk menyimpan nilai
      $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: { id: id, nilai: nilai, _token: csrfToken }, // Menambahkan token CSRF ke dalam data
        success: function(response) {
          if (response.success) {
            console.log("Nilai berhasil disimpan");
          } else {
            console.log("Gagal menyimpan nilai");
          }
        },
        error: function() {
          console.log("Terjadi kesalahan");
        }
      });
    }
  </script>   
@endsection
