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
        $kelasMapelId = KelasMapel::where('id_jurusanTingkatKelas', $jurusanTingkatKelasId)->pluck('id')->all();
        $matchingPertemuanIds = [];
        $matchingTugasIds = [];
        
        foreach ($kelasMapelId as $kId) {
            $pertemuanIds = Pertemuan::where('id_kelasMapelGuru', $kId)->pluck('id')->all();
            if (!empty($pertemuanIds)) {
                $matchingPertemuanIds = array_merge($matchingPertemuanIds, $pertemuanIds);
            }
        }
        
        foreach ($matchingPertemuanIds as $pId) {
            $tugasIds = Tugas::where('id_pertemuan', $pId)->pluck('id')->all();
            if (!empty($tugasIds)) {
                $matchingTugasIds = array_merge($matchingTugasIds, $tugasIds);
            }
        }

        $dataMapel = [];

        foreach ($kelasMapelId as $kmId) {
            $kelasMapel = KelasMapel::where('id', $kmId)->first();
            $mapel = Mapel::where('id', $kelasMapel->id_mapel)->first();

            $dataPertemuan = Pertemuan::where('id_kelasMapelGuru', $kmId)->pluck('id')->all();

            $tugas = Tugas::whereIn('id_pertemuan', $dataPertemuan)
                ->whereIn('id', $matchingTugasIds)
                ->select('id', 'nama')
                ->get()
                ->toArray();

            $tugasIds = collect($tugas)->pluck('id')->all();

            $pengumpulanTugas = PengumpulanTugas::whereIn('id_tugas', $tugasIds)
                ->pluck('nilai', 'id_tugas')
                ->all();

            // Add the 'nilai' field to the respective tugas in the $tugas array
            foreach ($tugas as &$tugasItem) {
                $idTugas = $tugasItem['id'];
                $tugasItem['nilai'] = isset($pengumpulanTugas[$idTugas]) ? $pengumpulanTugas[$idTugas] : 0;
            }

            $dataMapel[] = [
                'id_mapel' => $mapel->id,
                'nama_mapel' => $mapel->nama,
                'pertemuan_id' => $dataPertemuan,
                'tugas' => $tugas
            ];
        }

        $dataPerhitunganNilai = [];

        foreach ($dataMapel as $mapelItem) {
            $idMapel = $mapelItem['id_mapel'];
            $namaMapel = $mapelItem['nama_mapel'];
            $tugasItems = $mapelItem['tugas'];
        
            $totalNilai = 0;
            $jumlahTugas = 0;
        
            foreach ($tugasItems as $tugas) {
                $nilai = isset($tugas['nilai']) ? $tugas['nilai'] : 0;
                $totalNilai += $nilai;
                $jumlahTugas++;
            }
        
            $dataMapels = [];
        
            foreach ($tugasItems as $tugas) {
                $nilai = isset($tugas['nilai']) ? $tugas['nilai'] : 0;
                $dataMapels[] = $nilai;
            }
        
            $rataRataNilai = $jumlahTugas > 0 ? $totalNilai / $jumlahTugas : 0;
            $gradeTotalNilai = $this->convertToGrade($rataRataNilai);
        
            $dataPerhitunganNilai[$idMapel] = [
                'id_mapel' => $idMapel,
                'nama_mapel' => $namaMapel,
                'detail_nilai' => $dataMapels,
                'total_nilai' => $totalNilai,
                'rata_rata_nilai' => $rataRataNilai,
                'grade_total_nilai' => $gradeTotalNilai
            ];
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
        $tugasSudahDikumpulkan = [];
        foreach ($matchingPertemuanIds as $pertemuanId) {
            $tugas = Tugas::where('id_pertemuan', $pertemuanId)
                ->whereIn('id', function ($query) use ($matchingTugasIds, $userId) {
                    $query->select('id_tugas')
                        ->from('pengumpulan_tugas')
                        ->where('id_siswa', $userId)
                        ->whereIn('id_tugas', $matchingTugasIds);
                })
                ->get();

            foreach ($tugas as $tugasItem) {
                $pengumpulanTugas = PengumpulanTugas::where('id_siswa', $userId)
                    ->where('id_tugas', $tugasItem->id)
                    ->first();

                if ($pengumpulanTugas) {
                    $tugasItem->nilai = $pengumpulanTugas->nilai;
                    $tugasItem->id_siswa = $pengumpulanTugas->id_siswa;
                }

                $tugasSudahDikumpulkan[] = $tugasItem;
            }
        }

        return view('siswa.dashboard', ['user' => $user, 'mapelSiswa' => $mapelSiswa])
            ->with('pertemuan', $pertemuan)
            ->with('jurusanTingkatKelasId', $jurusanTingkatKelasId)
            ->with('tugasBelumDikumpulkan', $tugasBelumDikumpulkan)
            ->with('tugasSudahDikumpulkan', $tugasSudahDikumpulkan)
            ->with('pertemuanSidebar', $pertemuanSidebar)
            ->with('dataPerhitunganNilai', $dataPerhitunganNilai);
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
            $jurusanTingkatKelasId = KelasSiswa::where('id_siswa', $userId)->pluck('id_jurusanTingkatKelas')->all();
            $kelasMapelId = KelasMapel::where('id_jurusanTingkatKelas', $jurusanTingkatKelasId)->pluck('id')->all();
            $kelasMapelId = KelasMapel::where('id_jurusanTingkatKelas', $jurusanTingkatKelasId)->pluck('id')->all();
            $matchingPertemuanIds = [];
            $matchingTugasIds = [];
            
            foreach ($kelasMapelId as $kId) {
                $pertemuanIds = Pertemuan::where('id_kelasMapelGuru', $kId)->pluck('id')->all();
                if (!empty($pertemuanIds)) {
                    $matchingPertemuanIds = array_merge($matchingPertemuanIds, $pertemuanIds);
                }
            }
            
            foreach ($matchingPertemuanIds as $pId) {
                $tugasIds = Tugas::where('id_pertemuan', $pId)->pluck('id')->all();
                if (!empty($tugasIds)) {
                    $matchingTugasIds = array_merge($matchingTugasIds, $tugasIds);
                }
            }

            $dataMapel = [];

            foreach ($kelasMapelId as $kmId) {
                $kelasMapel = KelasMapel::where('id', $kmId)->first();
                $mapel = Mapel::where('id', $kelasMapel->id_mapel)->first();

                $dataPertemuan = Pertemuan::where('id_kelasMapelGuru', $kmId)->pluck('id')->all();

                $tugas = Tugas::whereIn('id_pertemuan', $dataPertemuan)
                    ->whereIn('id', $matchingTugasIds)
                    ->select('id', 'nama')
                    ->get()
                    ->toArray();

                $tugasIds = collect($tugas)->pluck('id')->all();

                $pengumpulanTugas = PengumpulanTugas::whereIn('id_tugas', $tugasIds)
                    ->pluck('nilai', 'id_tugas')
                    ->all();

                // Add the 'nilai' field to the respective tugas in the $tugas array
                foreach ($tugas as &$tugasItem) {
                    $idTugas = $tugasItem['id'];
                    $tugasItem['nilai'] = isset($pengumpulanTugas[$idTugas]) ? $pengumpulanTugas[$idTugas] : 0;
                }

                $dataMapel[] = [
                    'id_mapel' => $mapel->id,
                    'nama_mapel' => $mapel->nama,
                    'pertemuan_id' => $dataPertemuan,
                    'tugas' => $tugas
                ];
            }

            $dataPerhitunganNilai = [];

            foreach ($dataMapel as $mapelItem) {
                $idMapel = $mapelItem['id_mapel'];
                $namaMapel = $mapelItem['nama_mapel'];
                $tugasItems = $mapelItem['tugas'];
            
                $totalNilai = 0;
                $jumlahTugas = 0;
            
                foreach ($tugasItems as $tugas) {
                    $nilai = isset($tugas['nilai']) ? $tugas['nilai'] : 0;
                    $totalNilai += $nilai;
                    $jumlahTugas++;
                }
            
                $dataMapels = [];
            
                foreach ($tugasItems as $tugas) {
                    $nilai = isset($tugas['nilai']) ? $tugas['nilai'] : 0;
                    $dataMapels[] = $nilai;
                }
            
                $rataRataNilai = $jumlahTugas > 0 ? $totalNilai / $jumlahTugas : 0;
                $gradeTotalNilai = $this->convertToGrade($rataRataNilai);
            
                $dataPerhitunganNilai[$idMapel] = [
                    'id_mapel' => $idMapel,
                    'nama_mapel' => $namaMapel,
                    'detail_nilai' => $dataMapels,
                    'total_nilai' => $totalNilai,
                    'rata_rata_nilai' => $rataRataNilai,
                    'grade_total_nilai' => $gradeTotalNilai
                ];
            }

            $jurusanTingkatKelas = JurusanTingkatKelas::whereIn('id', $jurusanTingkatKelasId)->first();

            $pdf = PDF::loadView('siswa.nilai', compact('dataPerhitunganNilai', 'siswa', 'jurusanTingkatKelas'));

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
