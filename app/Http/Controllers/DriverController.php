<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index()
    {
        $data = Driver::all();
        return view('driver.index', ['data' => $data]);
    }

    public function create()
    {
        return view('location.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'license_number' => 'required',
            'phone' => 'required',
        ]);


        Driver::create($validatedData);

        return redirect('/driver')->with('success', 'Driver data successfully added');
    }

    public function edit(string $id)
    {
        $data = Driver::find($id);
        return view('user.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'license_number' => 'required',
            'phone' => 'required',
        ]);


        Driver::find($id)->update([
            'name' => $request->name,
            'license_number' => $request->license_number,
            'phone' => $request->phone,
        ]);

        return redirect('/driver')->with('success', 'Driver data successfully edited');
    }

    public function destroy(String $id)
    {
        $check = Driver::find($id);
        if (!$check) {
            return redirect('/driver')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            Driver::destroy($id);

            return redirect('/driver')->with('success', 'Driver data successfully deleted');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/driver')->with('error' . 'Data User gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
