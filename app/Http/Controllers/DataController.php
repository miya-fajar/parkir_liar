<?php

namespace App\Http\Controllers;

use App\Events\CreateData;
use App\Models\Data;
use App\ObjectType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DataController extends Controller
{
    public function index() {}


    public function create(Request $request)
    {
        $validate = $request->validate([
            "object_type" => ['required', Rule::enum(ObjectType::class)],
            "image" => ['required', 'image'],
        ]);

        if ($request->hasFile('image')) {
            try {
                $image = $request->file('image');
                $path = $image->store('images', 'public');

                $data = new Data();
                $data->object_type = $validate['object_type'];
                $data->image_url = $path;
                $data->location = "cemerlang";
                $data->save();

                event(new CreateData($data));

                return response()->json([
                    'message' => 'successfully upload file',
                    'path' => $path,
                ]);
            } catch (Exception $err) {
                return response()->json(['message' => $err->getMessage()], 500);
            }
        } else {
            return response()->json(['message' => 'image file not found'], 400);
        }
    }
}
