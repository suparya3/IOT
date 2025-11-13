<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}
