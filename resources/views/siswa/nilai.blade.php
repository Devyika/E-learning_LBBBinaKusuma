<!DOCTYPE html>
<html>
<head>
    <title>LMS - Nilai Hasil Pengumpulan Tugas</title>
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

  <div class="header">
    <img src="{{ asset('storage/file/img/default/logo.png') }}" alt="Company Logo" class="logo">
    <div class="company-name">SMA Negeri 4 Probolinggo</div>
    <div class="company-address">LMS - Rekap Nilai Hasil Pengumpulan Tugas {{ $siswa->name }}</div>
  </div>
  <div class="content">
    <p><span class="label">Nama Siswa</span>: {{ $siswa->name }}</p>
    <p><span class="label">Username</span>: {{ $siswa->username }}</p>
    <p><span class="label">Kelas</span>: {{ $jurusanTingkatKelas->jurusan->name }} {{ $jurusanTingkatKelas->tingkat->name }} {{ $jurusanTingkatKelas->kelas->nama }}</p>
  </div>
  <table>
        <thead>
            <tr>
              <th rowspan="2" style="width: 20%; text-align: center;">Mata Pelajaran</th>
              @php
                  $maxColumns = 0;
                  foreach ($dataPerhitunganNilai as $nilai) {
                      $numColumns = count($nilai['detail_nilai']);
                      if ($numColumns > $maxColumns) {
                          $maxColumns = $numColumns;
                      }
                  }
              @endphp
              <th colspan="{{ $maxColumns > 0 ? $maxColumns : 1 }}" style="text-align: center;">Tugas</th>
              <th rowspan="2" style="width: 10%; text-align: center;">Rata - Rata</th>
              <th rowspan="2" style="width: 10%; text-align: center;">Nilai Huruf</th>
          </tr>
          <tr>
              @for ($i = 1; $i <= $maxColumns; $i++)
                  <th style="text-align: center;">{{ $i }}</th>
              @endfor
          </tr>        
        </thead>
        <tbody>
            @foreach ($dataPerhitunganNilai as $nilai)
            <tr>
                <td>{{ $nilai['nama_mapel'] }}</td>
                @php
                    $numColumns = count($nilai['detail_nilai']);
                    $missingColumns = $maxColumns - $numColumns;
                @endphp
                @foreach ($nilai['detail_nilai'] as $tugasId => $detail)
                    <td style="text-align: center;">{{ $detail }}</td>
                @endforeach
                @for ($i = 0; $i < $missingColumns; $i++)
                    <td>-</td>
                @endfor
                <td style="width: 10%; text-align: center;">{{ number_format($nilai['rata_rata_nilai'], 2) }}</td>
                <td style="width: 10%; text-align: center;">{{ $nilai['grade_total_nilai'] }}</td>
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
    <p>© LMS - Nilai Hasil Pengumpulan Tugas</p>
  </div>
</body>
</html>
