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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role' => 'required',
        ]);


        Vehicle::create($validatedData);

        return redirect('/user')->with('success', 'Data user Berhasil Ditambahkan');
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            'role' => 'required',
            // 'password' => 'required',
        ]);

        $password = bcrypt($request->password);

        Vehicle::find($id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $password,
            'role' => $request->role,
        ]);

        return redirect('/user')->with('success', 'Data user berhasil diubah');
    }

    public function destroy(String $id)
    {
        $check = Vehicle::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            Vehicle::destroy($id);

            return redirect('/user')->with('success', 'Data User berhasil dihapus');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/User')->with('error' . 'Data User gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
