<?php

namespace App\Http\Controllers;

use App\Models\Approval;
use App\Models\Driver;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        if (Gate::allows('IsAdmin')) {
            $data = Order::all();
        } else {
            $data = Order::where('approver1_id', Auth::user()->id)
                ->orWhere('approver2_id', Auth::user()->id)
                ->get();
        }
        return view('order.index', ['data' => $data]);
    }

    public function create()
    {
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $approvals = User::where('role', 'approver')->get();
        return view('order.create',  ['vehicles' => $vehicles, 'drivers' => $drivers, 'approvals' => $approvals]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'vehicle' => 'required',
            'driver' => 'required',
            'approval1' => 'required',
            'approval2' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);

        Order::create([
            'vehicle_id' => $validatedData['vehicle'],
            'driver_id' => $validatedData['driver'],
            'approver1_id' => $validatedData['approval1'],
            'approver2_id' => $validatedData['approval2'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'reason' => $validatedData['reason'],
            'status' => 'pending',
        ]);

        $vehicle = Vehicle::find($validatedData['vehicle']);

        // Jika driver ditemukan, update statusnya menjadi 'in_use'
        if ($vehicle) {
            $vehicle->status = 'in_use';
            $vehicle->save();
        }

        // Order::create($validatedData);

        return redirect('/order')->with('success', 'Order data successfully added');
    }

    public function edit(string $id)
    {
        $data = Order::find($id);
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

        Order::find($id)->update([
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
        $check = Order::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data stok tidak ditemukan');
        }

        try {
            Order::destroy($id);

            return redirect('/user')->with('success', 'Data User berhasil dihapus');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/User')->with('error' . 'Data User gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function approve(string $id)
    {
        $order = Order::find($id);

        if ($order->status == 'pending') {
            $order->update([
                'status' => 'approved_level_1',
            ]);
            return redirect('/order')->with('success', 'Approval Level 1 Successful');
        } elseif ($order->status == 'approved_level_1') {
            $order->update([
                'status' => 'approved_level_2',
            ]);
            return redirect('/order')->with('success', 'Approval Level 2 Successful');
        }

        return redirect('/order')->with('error', 'Invalid status for approval');
    }

    public function rejected(string $id)
    {
        $order = Order::find($id);

        $order->update([
            'status' => 'rejected',
        ]);

        return redirect('/order')->with('success', 'Rejected Successful');
    }
}
