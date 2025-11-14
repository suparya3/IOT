<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Device;

class DeviceController extends Controller
{
    // menampilkan halaman kontroler 6 object
    public function index()
    {
        $devices = Device::all();
        return view('devices.index', compact('devices'));
    }

    // mengubah status On/Of menggunakan ajax
    public function toggle(Request $request)
    {
        $device = Device::findOrFail($request->id);
        $device->status = $request->status; //status dikirim dari js
        $device->save();

        return response()->json([
            'success' => true,
            'status' => $device->status
        ]);
    }

 public function getLampu()
{
    $devices = Device::all();

    // Jika tidak ada data
    if ($devices->isEmpty()) {
        return response()->json([
            'nama'=> $devices->nama,
            'status' => $devices->status,
            'message' => 'Tidak ada device'
        ], 404);
    }

    // Return semua lampu dalam bentuk array
    return response()->json($devices);
}

}
