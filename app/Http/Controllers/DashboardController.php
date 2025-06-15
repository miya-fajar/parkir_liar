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

// Ambil list jenis kendaraan unik
$jenisList = Pelanggaran::select('jenis_kendaraan')->distinct()->pluck('jenis_kendaraan')->toArray();

// Siapkan array tanggal (labels)
$labelsDates = [];
for ($i = 0; $i < 30; $i++) {
    $labelsDates[] = Carbon::now()->subDays(29 - $i)->format('Y-m-d');
}

// Inisialisasi data per jenis kendaraan
$dataPerJenis = [];
foreach ($jenisList as $jenis) {
    $dataPerJenis[$jenis] = array_fill(0, 30, 0); // default 0
}

// Query jumlah per jenis per tanggal
$dailyJenisCounts = Pelanggaran::select(
        DB::raw('jenis_kendaraan'),
        DB::raw('DATE(waktu_pelanggaran) as tanggal'),
        DB::raw('COUNT(*) as jumlah')
    )
    ->whereBetween('waktu_pelanggaran', [$startDate, $endDate])
    ->groupBy('jenis_kendaraan', DB::raw('DATE(waktu_pelanggaran)'))
    ->get();

// Isi array sesuai hasil query
foreach ($dailyJenisCounts as $row) {
    $jenis = $row->jenis_kendaraan;
    $tanggal = $row->tanggal;
    $index = array_search($tanggal, $labelsDates);
    if ($index !== false) {
        $dataPerJenis[$jenis][$index] = $row->jumlah;
    }
}


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
    'dataPerJenis' => $dataPerJenis,
            'latestMotor' => $latestMotor,
            'latestMobil' => $latestMobil,
        ]);
    }
}

