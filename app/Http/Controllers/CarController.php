<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;

class CarController extends Controller
{
    public function index()
    {
        $carViolations   = Pelanggaran::where('jenis_kendaraan', 'mobil')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'car_page');
        return view('car', ['carViolations' => $carViolations]);
    }
}
