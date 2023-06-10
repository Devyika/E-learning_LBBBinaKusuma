<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\JurusanTingkatKelas;
use App\Models\KelasMapel;
use App\Models\KelasSiswa;
use App\Models\Mapel;
use App\Models\PengumpulanTugas;
use App\Models\Pertemuan;
use App\Models\Siswa;
use App\Models\Tugas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DashboardSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
{
    DB::statement("SET SQL_MODE=''");
    $username_siswa = Auth::user()->username;
    $userId = Siswa::where('username', $username_siswa)->pluck('id')->first();
    $user = User::join('siswa', 'users.username', '=', 'siswa.username')
        ->select('users.username', 'siswa.*')
        ->where('users.id', Auth::user()->id)
        ->first();
    $mapelSiswa = KelasSiswa::with('siswa')
        ->where('id_siswa', $user)
        ->get();
    $pertemuanSidebar = DB::table('pertemuan as a')
        ->join('kelas_mapel_guru as b', 'b.id', '=', 'a.id_kelasMapelGuru')
        ->join('kelas_siswa as c', 'c.id_jurusanTingkatKelas', '=', 'b.id_jurusanTingkatKelas')
        ->select('a.id', 'a.nama', 'a.id_kelasMapelGuru', 'b.id_jurusanTingkatKelas', 'b.id_mapel', 'c.id_siswa')
        ->where('id_siswa', $userId)
        ->orderBy('nama')
        ->get();
    $pertemuan = DB::table('pertemuan as a')
        ->join('kelas_mapel_guru as b', 'b.id', '=', 'a.id_kelasMapelGuru')
        ->join('kelas_siswa as c', 'c.id_jurusanTingkatKelas', '=', 'b.id_jurusanTingkatKelas')
        ->select('a.id', 'a.nama', 'a.id_kelasMapelGuru', 'b.id_jurusanTingkatKelas', 'b.id_mapel', 'c.id_siswa')
        ->where('id_siswa', $userId)
        ->orderBy('nama')
        ->get();
    $jurusanTingkatKelasId = KelasSiswa::where('id_siswa', $userId)->pluck('id_jurusanTingkatKelas')->all();
    $kelasMapelId = KelasMapel::where('id_jurusanTingkatKelas', $jurusanTingkatKelasId)->pluck('id')->all();
    $matchingPertemuanIds = array();
    $matchingTugasIds = array();
    foreach ($kelasMapelId as $kId) {
        $pertemuanIds = Pertemuan::where('id_kelasMapelGuru', $kId)->pluck('id')->all();
        if (!empty($pertemuanIds)) {
            $matchingPertemuanIds[] = $pertemuanIds[0];
        }
    }
    foreach ($matchingPertemuanIds as $pId) {
        $tugasIds = Tugas::where('id_pertemuan', $pId)->pluck('id')->all();
        if (!empty($tugasIds)) {
            $matchingTugasIds[] = $tugasIds[0];
        }
    }
    $tugasBelumDikumpulkan = array();
    foreach ($matchingPertemuanIds as $pertemuanId) {
        $tugas = Tugas::where('id_pertemuan', $pertemuanId)
            ->whereNotIn('id', function ($query) use ($matchingTugasIds, $userId) {
                $query->select('id_tugas')
                    ->from('pengumpulan_tugas')
                    ->where('id_siswa', $userId)
                    ->whereIn('id_tugas', $matchingTugasIds);
            })
            ->get();
        $tugasBelumDikumpulkan = array_merge($tugasBelumDikumpulkan, $tugas->toArray());
    }
    $tugasSudahDikumpulkan = array();
    foreach ($matchingPertemuanIds as $pertemuanId) {
        $tugas = Tugas::where('id_pertemuan', $pertemuanId)
            ->whereIn('id', function ($query) use ($matchingTugasIds, $userId) {
                $query->select('id_tugas')
                    ->from('pengumpulan_tugas')
                    ->where('id_siswa', $userId)
                    ->whereIn('id_tugas', $matchingTugasIds);
            })
            ->get();
        $tugasSudahDikumpulkan = array_merge($tugasSudahDikumpulkan, $tugas->toArray());
    }
    $kelasSiswa = KelasSiswa::where('id_siswa', $userId)->get();
$nilaiMapel = [];

foreach ($kelasSiswa as $kelas) {
    $mapelKelas = KelasMapel::where('id_jurusanTingkatKelas', $kelas->id_jurusanTingkatKelas)->get();

    foreach ($mapelKelas as $mapel) {
        $mapelNama = $mapel->mapel->nama;

        $matchingPertemuanIds = Pertemuan::where('id_kelasMapelGuru', $mapel->id)->pluck('id')->all();
        $matchingTugasIds = Tugas::whereIn('id_pertemuan', $matchingPertemuanIds)->pluck('id')->all();

        $matchingPengumpulanTugasIds = PengumpulanTugas::whereIn('id_tugas', $matchingTugasIds)
            ->where('id_siswa', $userId)
            ->pluck('nilai', 'id_tugas')
            ->all();

        $countMapel = count($matchingTugasIds);

        if ($countMapel > 0) {
            $matchingPengumpulanTugasIds = array_map(function ($nilai) {
                return $nilai == -1 ? 0 : $nilai;
            }, $matchingPengumpulanTugasIds);

            $average = array_sum($matchingPengumpulanTugasIds) / $countMapel;
            $nilaiHuruf = $this->convertToGrade($average);
        } else {
            $average = 0;
            $nilaiHuruf = '-';
        }

        $nilaiMapel[] = [
            'mapel_nama' => $mapelNama,
            'nilai' => $average,
            'nilai_huruf' => $nilaiHuruf,
            'detail_nilai' => $matchingPengumpulanTugasIds,
            'kelas_mapel_id' => $mapel->id,
        ];
    }
}

// Menambahkan mapel yang tidak memiliki tugas
$mapelTidakAdaTugas = Mapel::whereDoesntHave('kelasMapel', function ($query) use ($kelasSiswa) {
    $query->whereIn('id_jurusanTingkatKelas', $kelasSiswa->pluck('id_jurusanTingkatKelas'));
})->get();

foreach ($mapelTidakAdaTugas as $mapel) {
    $nilaiMapel[] = [
        'mapel_nama' => $mapel->nama,
        'nilai' => 0,
        'nilai_huruf' => 'E',
        'detail_nilai' => [],
        'kelas_mapel_id' => null,
    ];
}

    return view('siswa.dashboard', ['user' => $user, 'mapelSiswa' => $mapelSiswa])
        ->with('pertemuan', $pertemuan)
        ->with('kelasSiswa', $kelasSiswa)
        ->with('tugasBelumDikumpulkan', $tugasBelumDikumpulkan)
        ->with('tugasSudahDikumpulkan', $tugasSudahDikumpulkan)
        ->with('pertemuanSidebar', $pertemuanSidebar)
        ->with('nilaiMapel', $nilaiMapel);
}


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function nilai()
    {
        $username_siswa = Auth::user()->username;
        $userId = Siswa::where('username', $username_siswa)->pluck('id')->first();

        $siswa = Siswa::where('username', $username_siswa)->first();

        $kelasSiswa = KelasSiswa::where('id_siswa', $userId)->first();

        if ($kelasSiswa) {
            $jurusanTingkatKelasId = $kelasSiswa->id_jurusanTingkatKelas;
            $jurusanTingkatKelas = JurusanTingkatKelas::find($jurusanTingkatKelasId);

            $mapelKelas = KelasMapel::where('id_jurusanTingkatKelas', $jurusanTingkatKelasId)->get();

            $nilaiMapel = [];

            foreach ($mapelKelas as $mapel) {
                $mapelNama = $mapel->mapel->nama;

                $matchingPertemuanIds = Pertemuan::where('id_kelasMapelGuru', $mapel->id)->pluck('id')->all();

                $matchingTugasIds = Tugas::whereIn('id_pertemuan', $matchingPertemuanIds)->pluck('id')->all();

                $matchingPengumpulanTugasIds = PengumpulanTugas::whereIn('id_tugas', $matchingTugasIds)
                    ->where('id_siswa', $userId)
                    ->pluck('nilai', 'id_tugas')
                    ->all();

                $countMapel = count($matchingTugasIds);

                if ($countMapel > 0) {
                    // Mengubah nilai -1 menjadi 0
                    $matchingPengumpulanTugasIds = array_map(function ($nilai) {
                        return $nilai == -1 ? 0 : $nilai;
                    }, $matchingPengumpulanTugasIds);

                    $average = array_sum($matchingPengumpulanTugasIds) / $countMapel;
                    $nilaiHuruf = $this->convertToGrade($average);
                } else {
                    $average = 0;
                    $nilaiHuruf = 'E';
                }

                $nilaiMapel[] = [
                    'mapel_nama' => $mapelNama,
                    'nilai' => $average,
                    'nilai_huruf' => $nilaiHuruf,
                    'detail_nilai' => $matchingPengumpulanTugasIds,
                ];
            }

            // Menambahkan mapel yang tidak memiliki tugas
            $mapelTidakAdaTugas = Mapel::whereDoesntHave('kelasMapel', function ($query) use ($jurusanTingkatKelasId) {
                $query->where('id_jurusanTingkatKelas', $jurusanTingkatKelasId);
            })->get();

            foreach ($mapelTidakAdaTugas as $mapel) {
                $nilaiMapel[] = [
                    'mapel_nama' => $mapel->nama,
                    'nilai' => 0,
                    'nilai_huruf' => 'E',
                    'detail_nilai' => [],
                ];
            }

            $pdf = PDF::loadView('siswa.nilai', compact('nilaiMapel', 'siswa', 'jurusanTingkatKelas'));

            $fileName = 'nilai_' . $siswa->name . '_' . $siswa->username . '.pdf';

            return $pdf->stream($fileName);
        }
    }
    
    private function convertToGrade($nilai)
    {
        if ($nilai >= 90) {
            return 'A+';
        } elseif ($nilai >= 85) {
            return 'A';
        } elseif ($nilai >= 80) {
            return 'A-';
        } elseif ($nilai >= 75) {
            return 'B+';
        } elseif ($nilai >= 70) {
            return 'B';
        } elseif ($nilai >= 65) {
            return 'B-';
        } elseif ($nilai >= 60) {
            return 'C+';
        } elseif ($nilai >= 55) {
            return 'C';
        } elseif ($nilai >= 50) {
            return 'C-';
        } elseif ($nilai >= 45) {
            return 'D';
        } else {
            return 'E';
        }
    }
}
