@extends('siswa.layout.template')

@section('content')
<div class="container-fluid">
  <div class="row mb-2">
    <div class="col-sm-6">
      <h1>Pertemuan</h1>
    </div>
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Menu</a></li>
        <li class="breadcrumb-item active">Dashboard</li>
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
          @if ($pertemuan->count() == 1)
          @foreach ($pertemuan as $p)
          <h3 class="card-title"><b>Kelas :</b> {{$p->tingkat}} {{$p->jurusan}} {{$p->kelas}}  <b>&nbsp;&nbsp;|&nbsp;&nbsp;  Pelajaran :</b> {{$p->mapel}}</h3>
          @endforeach
          @endif
        </div>
        <!-- ./card-header -->
        <div class="card-body p-0">
          <table class="table table-hover">
            <tbody>
              @foreach ($pertemuan as $p)
              <tr>
                <td class="border-0">{{$p->mapel}}</td>
              </tr>
              <tr data-widget="expandable-table" aria-expanded="true">
                <td>
                  <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                  Modul &nbsp; | &nbsp; 
                </td>
              </tr>
              <tr class="expandable-body">
                <td>
                  <div class="p-0">
                    <table class="table table-hover">
                      <tbody>
                        @foreach ($modul as $mm)
                        @if ($mm->id_pertemuan == $p->id)                        
                        <tr data-widget="expandable-table" aria-expanded="false">
                          <td>
                            &emsp; <a href="{{asset('storage/'.$mm->file)}}" target="_blank" rel="noopener noreferrer">{{$mm->nama}}</a>
                          </td>
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                    </table>
                  </div>
                </td>
              </tr>

              <tr data-widget="expandable-table" aria-expanded="true">
                <td>
                  <i class="expandable-table-caret fas fa-caret-right fa-fw"></i>
                  Tugas &nbsp; | &nbsp; 
                </td>
              </tr>
              <tr class="expandable-body">
                <td>
                  <div class="p-0">
                    <table class="table table-hover">
                      <tbody>
                        @foreach ($tugas as $t)
                        @if ($t->id_pertemuan == $p->id)
                        <tr data-widget="expandable-table" aria-expanded="false">
                          <td>
                            &emsp; {{$t->nama}}
                            &nbsp;
                          </td>
                        </tr>
                        @endif
                        @endforeach
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
  <!-- Main row -->
  
  <!-- /.row (main row) -->
</div>
  <!-- /.card-body -->
</div>
<!-- /.card -->

@endsection