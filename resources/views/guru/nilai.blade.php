<!DOCTYPE html>
<html>
<head>
    @foreach ($mapel2 as $m)
        <title>LMS - Nilai Pengumpulan Tugas {{ $m->nama }}</title>
    @endforeach
  <style>
    @page {
      size: A4;
      margin: 0;
    }
    body {
      font-family: Arial, sans-serif;
      margin: 20px;
    }
    .header {
      text-align: center;
    }
    .logo {
      width: 100px;
      height: 100px;
    }
    .company-name {
      font-size: 24px;
      font-weight: bold;
      margin-top: 10px;
    }
    .company-address {
      font-size: 14px;
      margin-top: 5px;
    }
    .content {
      margin-top: 20px;
    }
    .title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 10px;
    }
    .subtitle {
      font-size: 16px;
      margin-bottom: 10px;
    }
    .footer {
      text-align: center;
      position: fixed;
      bottom: 30px;
      left: 0;
      right: 0;
      font-size: 12px;
    }

    table {
      border-collapse: collapse;
      width: 100%;
    }
    th, td {
      border: 1px solid black;
      padding: 8px;
      text-align: left;
    }

    .label {
      display: inline-block;
      width: 100px;
      font-weight: bold;
    }

    .page-break {
      page-break-before: always;
    }
  </style>
</head>
<body>
    <?php
    setlocale(LC_TIME, 'id_ID');
    $tanggal = strftime('%d %B %Y');
    ?>

    @foreach($mapel2 as $m)
  <div class="header">
    <img src="{{ asset('storage/file/img/default/logo.png') }}" alt="Company Logo" class="logo">
    <div class="company-name">SMA Negeri 4 Ponorogo</div>
    <div class="company-address">LMS - Nilai Pengumpulan Tugas {{ $m->nama }}</div>
  </div>
  <div class="content">
    <p><span class="label">Nama Guru</span> {{ $user->name }}</p>
    <p><span class="label">Kelas</span> {{$m->tingkat}} {{$m->jurusan}} {{$m->kelas}}</p>
  </div>
  @endforeach
  <table>
        <thead>
            <tr>
                <th style="width: 20%;">Nama Siswa</th>
                @foreach ($pengumpulanWithSiswa[0]['detail_nilai'] as $d)
                    <td>{{ $d['nama_tugas'] }}</td>
                @endforeach
                <th style="width: 10%">Rata - Rata</th>
                <th style="width: 10%">Nilai Huruf</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengumpulanWithSiswa as $p)
            <tr>
                <td>{{ $p['name_siswa'] }}</td>
                @foreach ($pengumpulanWithSiswa[0]['detail_nilai'] as $d)
                    <td>{{ $d['nilai'] }}</td>
                @endforeach
                <td>{{ $p['rata_rata_nilai'] }}</td>
                <td>{{ $p['grade_total_nilai'] }}</td>
            </tr>
            @endforeach
        </tbody>
  </table>
  <div class="ttd" style="text-align: right;">
    <p style="font-weight: 400;">Probolinggo, {{ $tanggal }}</p>
    <p style="margin-bottom: 65px; font-weight: 400;">ttd.</p>
    <p style="font-weight: 400;">Kepala Sekolah: Moch. Nad</p>
</div>

  <div class="page-break"></div> <!-- Menambahkan pemisah halaman -->
  <div class="content">
    <p>Keterangan:</p>
    <ul>
      <li>Nilai rata-rata dihitung berdasarkan total nilai tugas yang telah dikerjakan dibagi dengan jumlah tugas.</li>
      <li>Nilai huruf dihitung berdasarkan rentang nilai tertentu, sebagai berikut:</li>
    </ul>
    <table style="width: 50%; margin-left: auto; margin-right: auto;">
      <thead>
          <tr>
              <th>Nilai</th>
              <th>Nilai Huruf</th>
          </tr>
      </thead>
      <tbody>
          <tr>
              <td>90 - 100</td>
              <td>A+</td>
          </tr>
          <tr>
              <td>85 - 89</td>
              <td>A</td>
          </tr>
          <tr>
              <td>80 - 84</td>
              <td>A-</td>
          </tr>
          <tr>
              <td>75 - 79</td>
              <td>B+</td>
          </tr>
          <tr>
              <td>70 - 74</td>
              <td>B</td>
          </tr>
          <tr>
              <td>65 - 69</td>
              <td>B-</td>
          </tr>
          <tr>
              <td>60 - 64</td>
              <td>C+</td>
          </tr>
          <tr>
              <td>55 - 59</td>
              <td>C</td>
          </tr>
          <tr>
              <td>50 - 54</td>
              <td>C-</td>
          </tr>
          <tr>
              <td>45 - 49</td>
              <td>D</td>
          </tr>
          <tr>
              <td>0 - 44</td>
              <td>E</td>
          </tr>
      </tbody>
  </table>
  
  </div>
  <div class="footer">
    @foreach ($mapel2 as $m)
        <title>© LMS - Nilai Pengumpulan Tugas {{ $m->nama }}</title>
    @endforeach
  </div>
</body>
</html>
