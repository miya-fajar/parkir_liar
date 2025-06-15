<?php

namespace App\Http\Controllers;

use App\Events\CreateData;
use App\Models\Data;
use App\Models\Pelanggaran;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PelanggaranController extends Controller
{
    public function index() {}


    public function create(Request $request)
    {
        $validate = $request->validate([
            "jenis_kendaraan" => ['required', Rule::in(["motor", "mobil"])],
            "image" => ['required', "image"],
        ]);

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $path = $image->store('images', 'public');

                $data = new Pelanggaran();
                $data->jenis_kendaraan = $validate['jenis_kendaraan'];
                $data->image = $path;
                $data->save();

                event(new CreateData($data));

                return [
                    'message' => 'successfully upload file',
                    'path' => $path,
                ];
            } catch (Exception $err) {
                return ['message' => $err->getMessage()];
            }
        } else {
            return ['message' => 'image file not found'];
        }
    }
}
