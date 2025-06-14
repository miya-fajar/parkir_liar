<?php

namespace App\Http\Controllers;

use App\Models\Pelanggaran;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;  // untuk query raw

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Data untuk Donut Chart (jumlah pelanggaran per jenis_kendaraan)
        $jenisCounts = Pelanggaran::select('jenis_kendaraan', DB::raw('COUNT(*) as total'))
                        ->groupBy('jenis_kendaraan')
                        ->get();
        $labelsJenis = $jenisCounts->pluck('jenis_kendaraan')->toArray();  // contoh: ['Motor', 'Mobil']
        $dataJenis   = $jenisCounts->pluck('total')->toArray();            // contoh: [120, 80]

        // 2. Data untuk grafik 30 hari terakhir (jumlah pelanggaran per hari)
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate   = Carbon::now()->endOfDay();
        // Ambil data jumlah pelanggaran per tanggal dalam rentang 30 hari terakhir
        $dailyCounts = Pelanggaran::whereBetween('waktu_pelanggaran', [$startDate, $endDate])
                        ->groupBy(DB::raw('DATE(waktu_pelanggaran)'))
                        ->orderBy(DB::raw('DATE(waktu_pelanggaran)'))
                        ->get([
                            DB::raw('DATE(waktu_pelanggaran) as tanggal'),
                            DB::raw('COUNT(*) as jumlah')
                        ]);

        // Siapkan array tanggal 30 hari terakhir dengan nilai awal 0
        $countsByDate = [];
        for ($i = 0; $i < 30; $i++) {
            $date = Carbon::now()->subDays(29 - $i)->format('Y-m-d');
            $countsByDate[$date] = 0;
        }
        // Isi array dengan data dari query (jika ada pelanggaran pada tanggal tsb)
        foreach ($dailyCounts as $row) {
            $countsByDate[$row->tanggal] = $row->jumlah;
        }
        // Pisahkan menjadi labels (tanggal) dan data (jumlah pelanggaran)
        $labelsDates = array_keys($countsByDate);    // contoh: ['2025-05-15', '2025-05-16', ...]
        $dataDates   = array_values($countsByDate);  // contoh: [5, 3, 0, 7, ...] (jumlah per hari)


                $latestMotor = Pelanggaran::where('jenis_kendaraan', 'Motor')
                        ->orderBy('waktu_pelanggaran', 'desc')
                        ->first();

        // Query pelanggaran terbaru untuk Mobil
        $latestMobil = Pelanggaran::where('jenis_kendaraan', 'Mobil')
                        ->orderBy('waktu_pelanggaran', 'desc')
                        ->first();
        // Passing data ke view dashboard
        return view('dashboard', [
            'labelsJenis' => $labelsJenis,
            'dataJenis'   => $dataJenis,
            'labelsDates' => $labelsDates,
            'dataDates'   => $dataDates,
                        'latestMotor' => $latestMotor,
            'latestMobil' => $latestMobil,
        ]);
    }
}

