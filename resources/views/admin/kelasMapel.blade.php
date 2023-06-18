@extends('admin.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>SETTING</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Setting</a></li>
        <li class="breadcrumb-item active">Kelas</li>
      </ol>
    </div>
  </div>
</div><!-- /.container-fluid -->
</section>
@foreach ($jurusanTingkatKelas as $ju)
    <div class="card card-default">
        <div class="card-header">
            <h3 class="card-title">{{ $tingkat->name }} {{ $jurusan->name }} {{ $ju->kelas->nama }}</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                </button>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <button type="button" class="btn btn-success btn-sm float-right" data-toggle="modal" data-target="#addModal{{ $ju->id }}">
                                <i class="fa-solid fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            @php
                                $filteredKelasMapel = $allKelasMapel->where('id_jurusanTingkatKelas', $ju->id);
                                $filteredCount = $filteredKelasMapel->count();
                                $counter = 0; // Variabel counter untuk menghitung nomor urut
                            @endphp
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th style="width: 5%;">No.</th>
                                        <th style="width: 30%;">Nama Mata Pelajaran</th>
                                        <th style="width: 50%;">Nama Guru</th>
                                        <th style="width: 15%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($filteredKelasMapel as $km)
                                        <tr>
                                            <td class="text-center">{{ ++$counter }}</td>
                                            <td>{{ $km->mapel->nama }}</td>
                                            <td>{{ $km->guru->name }}</td>
                                            <td class="d-flex justify-content-around">
                                                {{-- <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#detailModal{{ $km->id }}">
                                                    <i class="fa-solid fa-circle-info"></i>
                                                </button>
                                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editModal-{{ $km->id }}">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </button> --}}
                                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal-{{ $km->id }}">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    @if ($filteredCount === 0)
                                        <tr>
                                            <td colspan="12" class="text-center">No matching records found</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama Mata Pelajaran</th>
                                        <th>Nama Guru</th>
                                        <th>Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach

</section>
<!-- /.content -->

  <!-- /.card-body -->
</div>
<!-- /.card -->
<!-- Modal -->
@foreach($jurusanTingkatKelas as $ju)
<div class="modal fade" id="addModal{{ $ju->id }}" tabindex="-1" role="dialog" aria-labelledby="addModal-label{{ $ju->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addModal-label{{ $ju->id }}"><strong>Setting Mata Pelajaran</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="addForm{{ $ju->id }}" method="POST" action="{{ url('admin/setting-mata_pelajaran/{t}/{j}') }}" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label for="id_jurusanTingkatKelas">Kelas</label>
            <select name="id_jurusanTingkatKelas" class="form-control">
              <option value="{{ $ju->id }}">{{ $ju->tingkat->name }} {{ $ju->jurusan->name }} {{ $ju->kelas->nama }}</option>
            </select>
          </div>
          <div class="form-group">
            <label for="id_mapel">Mata Pelajaran</label>
            <table id="mataPelajaranTable" class="table">
              <thead>
                <tr>
                  <th>Pilih</th>
                  <th>Mata Pelajaran</th>
                  <th>Nama Guru</th>
                </tr>
              </thead>
              <tbody>
                @foreach($allMapel as $m)
                  @php
                    $mapelExists = $ju->kelasMapel->contains('id_mapel', $m->id);
                  @endphp
                  @if (!$mapelExists)
                    <tr>
                      <td>
                        <input type="checkbox" name="mata_pelajaran[]" value="{{ $m->id }}">
                      </td>
                      <td>{{ $m->nama }}</td>
                      <td>
                        <select name="guru_id[]" class="form-control">
                          <option value="" selected disabled>Pilih Guru</option>
                          @foreach($allGuru as $g)
                            <option value="{{ $g->id }}">{{ $g->name }}</option>
                          @endforeach
                        </select>
                      </td>
                    </tr>
                  @endif
                @endforeach
              </tbody>
            </table>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="addForm{{ $ju->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>
  </div>
</div>
 @endforeach

@foreach ($allKelasMapel as $km)
<div class="modal fade" id="detailModal{{$km->id}}" tabindex="-1" role="dialog" aria-labelledby="detailModalLabel{{$km->id}}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalLabel{{$km->id}}"><strong>Detail Kelas </strong>{{$km->name}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        <label><strong>Kelas</strong></label>
        <p>{{$km->jurusanTingkatKelas->tingkat->name}} {{$km->jurusanTingkatKelas->jurusan->name}} {{$km->jurusanTingkatKelas->kelas->nama}}</p>
        <label><strong>Nama Mata Pelajaran</strong></label>
        <p>{{$km->mapel->nama}}</p>
        <label><strong>Nama Guru</strong></label>
        <p>{{$km->guru->name}}</p>
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
@endforeach
          
@foreach ($allKelasMapel as $km)
<div class="modal fade" id="editModal-{{ $km->id }}" tabindex="-1" role="dialog" aria-labelledby="editModal-label-{{ $km->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editModal-label-{{ $km->id }}"><strong>Edit Mata Pelajaran</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="editKelasForm-{{ $km->id }}" method="POST" action="{{ url('/admin/setting-mata_pelajaran/'. $km->id) }}" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="id_jurusanTingkatKelas">Kelas</label>
            <select name="id_jurusanTingkatKelas" class="form-control">
              @foreach($jurusanTingkatKelas as $ju)
              <option value="{{ $ju->id }}" {{ isset($km) && $km->id_jurusanTingkatKelas == $ju->id ? 'selected' : '' }}>{{ $km->jurusanTingkatKelas->tingkat->name }} {{ $km->jurusanTingkatKelas->jurusan->name }} {{ $km->jurusanTingkatKelas->kelas->nama }}</option>              
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="id_mapel">Mata Pelajaran</label>
            <select name="id_mapel" class="form-control">
              <option value="" selected disabled>Pilih Mata Pelajaran</option>
              @foreach($allMapel as $m)
              <option value="{{ $m->id }}" {{ isset($km) && $km->id_mapel == $m->id ? 'selected' : '' }} {{ old('id_jurusan') == $m->id ? 'selected' : '' }}>{{ $m->nama }}</option>              
              @endforeach
            </select>
          </div>
          <div class="form-group">
            <label for="id_guru">Nama Guru</label>
            <select name="id_guru" class="form-control">
              <option value="" selected disabled>Pilih Mata Pelajaran</option>
              @foreach($allGuru as $g)
              <option value="{{ $g->id }}" {{ isset($km) && $km->id_guru == $g->id ? 'selected' : '' }} {{ old('id_guru') == $g->id ? 'selected' : '' }}>{{ $g->name }}</option>              
              @endforeach
            </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm" form="editKelasForm-{{ $km->id }}"><i class="fa-solid fa-save"></i></button>
      </div>
    </div>                              
  </div>
</div>   
@endforeach

@foreach ($allKelasMapel as $km)

<div class="modal fade deleteBTN" id="deleteModal-{{ $km->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModal-label-{{ $km->id }}" aria-hidden="true">
  <div class="modal-dialog modal-sm" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title" id="deleteModal-label-{{ $km->id }}"><strong>Hapus Kelas </strong>{{ $km->nama }}</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
              </button>
          </div>
          <div class="modal-body">
              <p>Anda yakin ingin menghapus Kelas ini?</p>
          </div>
          <div class="modal-footer">
              <form id="delete-form-{{ $km->id }}" method="POST" action="{{ url('/admin/setting-mata_pelajaran/'.$km->id)}}">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger btn-sm delete-btn" data-id="{{ $km->id }}"><i class="fa-solid fa-trash"></i></button>
              </form>
          </div>
      </div>
  </div>
</div>
@endforeach                          
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
      $('.delete-btn').click(function(e) {
          e.preventDefault(); // Prevent form submission

          var form = $(this).closest('form'); // Get the closest form element
          var url = form.attr('action'); // Get the form action URL
          var dataId = $(this).data('id'); // Get the data-id attribute value

          $.ajax({
              url: url,
              type: 'POST',
              dataType: 'json',
              data: form.serialize(),
              success: function(response) {
                  if (response.message) {
                      // Show notification
                      showNotification('', response.message);
                      $('.deleteBTN').modal('hide');
                  }else {
                      // Reload the page
                      window.location.reload();
                  }
              },
              error: function(xhr, status, error) {
                  // Handle error if needed
              }
          });
      });

      // Function to show notification
      function showNotification(type, message) {
          // Modify this part to display the notification in your desired way
          // For example, using a library like Toastr, SweetAlert, or custom implementation
          alert(type + '' + message);
      }
  });
</script>
@endsection