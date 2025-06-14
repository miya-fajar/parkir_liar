<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pelanggaran;
use Illuminate\Http\JsonResponse;

class PelanggaranController extends Controller
{
        // Method untuk menyimpan data pelanggaran baru
    public function store(Request $request) : JsonResponse
    {
        return response()->json(['message' => 'API OK'], 200);
        // // Validasi input
        // $request->validate([
        //     'jenis_kendaraan'   => 'required|string',
        //     'waktu_pelanggaran' => 'required|date',
        //     'image'             => 'required|image|max:2048'  // harus berupa file image, maks 2MB
        // ]);

        // // Upload file image ke folder public/uploads
        // if ($request->hasFile('image')) {
        //     $file       = $request->file('image');
        //     $filename   = time().'_'.$file->getClientOriginalName();  // contoh penamaan file unik
        //     $file->move(public_path('uploads'), $filename);  // pindahkan file ke folder public/uploads
        //     $imagePath  = 'uploads/'.$filename;              // path yang disimpan ke database
        // } else {
        //     $imagePath = null;
        // }

        // // Simpan data ke database
        // $pelanggaran = Pelanggaran::create([
        //     'jenis_kendaraan'   => $request->jenis_kendaraan,
        //     'waktu_pelanggaran' => $request->waktu_pelanggaran,
        //     'image'             => $imagePath
        // ]);

        // // Kembalikan response (misal data yang baru disimpan)
        // return response()->json([
        //     'message' => 'Data pelanggaran berhasil disimpan.',
        //     'data'    => $pelanggaran
        // ], 201);
    }
}
