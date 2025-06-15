<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;

class MotorcycleController extends Controller
{
    public function index()
    {
        $motorViolations = Pelanggaran::where('jenis_kendaraan', 'Motor')
                ->orderBy('waktu_pelanggaran', 'desc')
                ->paginate(10, ['*'], 'motor_page');


        return view('motorcycle', ['motorViolations' => $motorViolations]);
    }
}
