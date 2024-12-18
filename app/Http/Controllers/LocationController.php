<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function index()
    {
        $data = Location::all();
        return view('location.index', ['data' => $data]);
    }

    public function create()
    {
        return view('location.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);
        Location::create($validatedData);

        return redirect('/location')->with('success', 'Location data successfully added');
    }

    public function edit(string $id)
    {
        $data = Location::find($id);
        return view('user.edit', [
            'data' => $data,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        Location::find($id)->update([
            'name' => $request->name,
            'address' => $request->address,
        ]);

        return redirect('/location')->with('success', 'Location data successfully edited');
    }

    public function destroy(String $id)
    {
        $check = Location::find($id);
        if (!$check) {
            return redirect('/location')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            Location::destroy($id);

            return redirect('/location')->with('success', 'Data User berhasil dihapus');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/location')->with('error' . 'Data User gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
