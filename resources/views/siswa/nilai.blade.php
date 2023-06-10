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
    <div class="company-name">SMA Negeri 4 Ponorogo</div>
    <div class="company-address">LMS - Nilai Hasil Pengumpulan Tugas</div>
  </div>
  <div class="content">
    <p><span class="label">Nama</span> {{ $siswa->name }}</p>
    <p><span class="label">Username</span> {{ $siswa->username }}</p>
    <p><span class="label">Kelas</span> {{ $jurusanTingkatKelas->jurusan->name }} {{ $jurusanTingkatKelas->tingkat->name }} {{ $jurusanTingkatKelas->kelas->nama }}</p>
  </div>
  <table>
        <thead>
            <tr>
                <th style="width: 20%;">Mata Pelajaran</th>
                @php
                    $maxColumns = 0;
                    foreach ($nilaiMapel as $nilai) {
                        $numColumns = count($nilai['detail_nilai']);
                        if ($numColumns > $maxColumns) {
                            $maxColumns = $numColumns;
                        }
                    }
                @endphp
                @for ($i = 1; $i <= $maxColumns; $i++)
                    <th>Tugas {{ $i }}</th>
                @endfor
                <th colspan="{{ $maxColumns > 0 ? $maxColumns : 1 }}" style="width: 10%;">Rata - Rata</th>
                <th style="width: 10%">Nilai Huruf</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($nilaiMapel as $nilai)
            <tr>
                <td>{{ $nilai['mapel_nama'] }}</td>
                @php
                    $numColumns = count($nilai['detail_nilai']);
                    $missingColumns = $maxColumns - $numColumns;
                @endphp
                @foreach ($nilai['detail_nilai'] as $tugasId => $detail)
                    <td>{{ $detail }}</td>
                @endforeach
                @for ($i = 0; $i < $missingColumns; $i++)
                    <td>-</td>
                @endfor
                <td colspan="{{ $maxColumns > 0 ? $maxColumns : 1 }}">{{ $nilai['nilai'] }}</td>
                <td>{{ $nilai['nilai_huruf'] }}</td>
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
    <table style="width: 25%;">
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
    <p>© 2023 Nama Perusahaan. All rights reserved.</p>
  </div>
</body>
</html>
