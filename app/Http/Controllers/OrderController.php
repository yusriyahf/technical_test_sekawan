<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Location;
use App\Models\Log;
use App\Models\Order;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Filter berdasarkan bulan
        if ($request->filled('month')) {
            $query->whereMonth('start_date', $request->month);
        }

        // Filter berdasarkan tahun
        if ($request->filled('year')) {
            $query->whereYear('start_date', $request->year);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan role
        if (Gate::allows('IsAdmin')) {
            $data = $query->get();
        } else {
            $data = $query->where(function ($q) {
                $q->where('approver1_id', Auth::user()->id)
                    ->orWhere('approver2_id', Auth::user()->id);
            })->get();
        }

        $locations = Location::all();
        $vehicles = Vehicle::all();
        $drivers = Driver::all();
        $approvals = User::where('role', 'approver')->get();

        return view('order.index', ['data' => $data, 'vehicles' => $vehicles, 'drivers' => $drivers, 'approvals' => $approvals, 'locations' => $locations]);
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
            'location' => 'required',
            'vehicle' => 'required',
            'driver' => 'required',
            'approval1' => 'required',
            'approval2' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);

        Order::create([
            'location_id' => $validatedData['location'],
            'vehicle_id' => $validatedData['vehicle'],
            'driver_id' => $validatedData['driver'],
            'approver1_id' => $validatedData['approval1'],
            'approver2_id' => $validatedData['approval2'],
            'start_date' => $validatedData['start_date'],
            'end_date' => $validatedData['end_date'],
            'reason' => $validatedData['reason'],
            'status' => 'pending',
        ]);

        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Add Booking',
            'details' => 'Add Booking Success.',
            'status' => 'Success',
        ]);

        $vehicle = Vehicle::find($validatedData['vehicle']);

        if ($vehicle) {
            $vehicle->status = 'in_use';
            $vehicle->save();
        }

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
            'location' => 'required',
            'vehicle' => 'required',
            'driver' => 'required',
            'approval1' => 'required',
            'approval2' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ]);


        Order::find($id)->update([
            'location_id' => $request->location,
            'vehicle_id' => $request->vehicle,
            'driver_id' => $request->driver,
            'approver1_id' => $request->approval1,
            'approver2_id' => $request->approval2,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
        ]);

        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Update Booking',
            'details' => 'Update Booking Success.',
            'status' => 'Success',
        ]);

        return redirect('/order')->with('success', 'Order data successfully edited');
    }

    public function destroy(String $id)
    {
        $check = Order::find($id);
        if (!$check) {
            return redirect('/order')->with('error', 'Data stok tidak ditemukan');
        }
        try {

            Order::destroy($id);
            Log::create([
                'user_id' => Auth::user()->id,
                'action' => 'Delete Booking',
                'details' => 'Delete Booking Success.',
                'status' => 'Success',
            ]);
            return redirect('/order')->with('success', 'Order data successfully deleted');
        } catch (\illuminate\Database\QueryException $e) {
            return redirect('/order')->with('error' . 'Data User gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function approve(string $id)
    {
        $order = Order::find($id);

        if ($order->status == 'pending') {
            $order->update([
                'status' => 'approved_level_1',
            ]);
            Log::create([
                'user_id' => Auth::user()->id,
                'action' => 'Approve Booking',
                'details' => 'Approve Level 1 Booking Success.',
                'status' => 'Success',
            ]);
            return redirect('/order')->with('success', 'Approval Level 1 Successful');
        } elseif ($order->status == 'approved_level_1') {
            $order->update([
                'status' => 'approved_level_2',
            ]);
            Log::create([
                'user_id' => Auth::user()->id,
                'action' => 'Approve Booking',
                'details' => 'Approve Level 2 Booking Success.',
                'status' => 'Success',
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
        Log::create([
            'user_id' => Auth::user()->id,
            'action' => 'Rejected Booking',
            'details' => 'Rejected Booking Success.',
            'status' => 'Success',
        ]);

        return redirect('/order')->with('success', 'Rejected Successful');
    }
}
