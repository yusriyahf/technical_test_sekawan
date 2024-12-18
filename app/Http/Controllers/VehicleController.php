<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $data = Vehicle::all();
        return view('vehicle.index', ['data' => $data]);
    }

    public function create()
    {
        return view('vehicle.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vehicle_name' => 'required',
            'vehicle_number' => 'required',
            'type' => 'required',
            'fuel_consumption' => 'required',
        ]);

        $validatedData['status'] = 'available';

        Vehicle::create($validatedData);

        return redirect('/vehicle')->with('success', 'Vehicle data successfully added');
    }

    public function edit(string $id)
    {
        $data = Vehicle::find($id);
        return view('user.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'vehicle_name' => 'required',
            'vehicle_number' => 'required',
            'type' => 'required',
            'fuel_consumption' => 'required',
        ]);

        Vehicle::find($id)->update([
            'vehicle_name' => $request->vehicle_name,
            'vehicle_number' => $request->vehicle_number,
            'type' => $request->type,
            'fuel_consumption' => $request->fuel_consumption,
        ]);

        return redirect('/vehicle')->with('success', 'Vehicle data successfully edited');
    }

    public function destroy(String $id)
    {
        $check = Vehicle::find($id);
        if (!$check) {
            return redirect('/vehicle')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            Vehicle::destroy($id);

            return redirect('/vehicle')->with('success', 'Vehicle data successfully deleted');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/vehicle')->with('error' . 'Data User gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
