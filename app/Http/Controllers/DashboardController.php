<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;

class DashboardController extends Controller
{
        public function index()
    {
        $motorCount = Pelanggaran::where('jenis_kendaraan', 'Motor')->count();
        $mobilCount = Pelanggaran::where('jenis_kendaraan', 'Mobil')->count();
        return view('dashboard', compact('motorCount', 'mobilCount'));
    }
}
