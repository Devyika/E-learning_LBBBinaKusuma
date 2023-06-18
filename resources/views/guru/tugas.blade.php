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
          @foreach ($kelas2 as $m)
          <h3 class="card-title"><b>Kelas :</b> {{$m->tingkat}} {{$m->jurusan}} {{$m->kelas}}  <b>&nbsp;&nbsp;|&nbsp;&nbsp;  Pelajaran :</b> {{$m->mapel}}</h3>
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
                              <input type="text" class="form-control" name="nilai{{$d->id}}" value="{{$d->nilai != -1 ? $d->nilai : ''}}">
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
        <div class="card-footer">
          <button type="button" class="btn btn-primary" onclick="saveNilai()">Simpan Nilai</button>
        </div>
      </div>
      <!-- /.card -->
    </div>
  </div>
  <!-- /.row -->
</div>
<!-- /.card-body -->
</div>
<!-- /.card -->

<script>
  function saveNilai() {
    var formData = new FormData();

    @foreach ($data as $d)
      formData.append("nilai{{$d->id}}", document.getElementsByName("nilai{{$d->id}}")[0].value);
    @endforeach

    var currentUrl = "{{ url()->current() }}";
    var csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
      url: currentUrl,
      type: "POST",
      data: formData,
      headers: {
        'X-CSRF-TOKEN': csrfToken
      },
      processData: false, // Prevent jQuery from processing the data
      contentType: false, // Prevent jQuery from setting the content type
      success: function(response) {
        // Handle the response from the server
        console.log(response);
      },
      error: function(xhr, status, error) {
        // Handle the error
        console.log(error);
      }
    });
  }
</script>





@endsection
