<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggaran extends Model
{
    use HasFactory;
    protected $table = 'pelanggaran';  // Nama tabel di database
    protected $fillable = ['jenis_kendaraan', 'waktu_pelanggaran', 'image'];
}
