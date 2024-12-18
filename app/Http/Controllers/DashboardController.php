<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Models\Order;
use App\Models\Vehicle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard dengan grafik pemakaian kendaraan
     * dan jenis kendaraan yang sedang dalam pemeliharaan.
     *
     * @return \Illuminate\View\View
     */


    public function index(Request $request)
    {
        // Ambil bulan dari query parameter
        $totalDrivers = Driver::count();
        $totalBookings = Order::count();
        $totalVehicles = Vehicle::count();
        $selectedMonth = $request->query('month', Carbon::now()->format('Y-m'));

        // Filter data berdasarkan bulan yang dipilih
        $orderData = DB::table('orders')
            ->join('vehicles', 'orders.vehicle_id', '=', 'vehicles.id')
            ->selectRaw('DATE(orders.created_at) as date, vehicles.type as type, COUNT(orders.id) as total')
            ->whereRaw('DATE_FORMAT(orders.created_at, "%Y-%m") = ?', [$selectedMonth])
            ->groupBy('date', 'vehicles.type')
            ->orderBy('date')
            ->get();


        // Format data untuk grafik
        $formattedData = [];
        foreach ($orderData as $data) {
            $formattedData[$data->date][$data->type] = $data->total;
        }

        $dates = array_keys($formattedData);
        $rentalData = [];
        $personalData = [];

        foreach ($dates as $date) {
            $rentalData[] = $formattedData[$date]['rental'] ?? 0;
            $personalData[] = $formattedData[$date]['personal'] ?? 0;
        }

        // Hitung bulan saat ini dan 3 bulan ke belakang
        $currentMonth = Carbon::now();
        $months = [];
        for ($i = 0; $i < 4; $i++) {
            $monthName = $currentMonth->format('F Y');
            $months[] = [
                'value' => $currentMonth->format('Y-m'),
                'name' => $monthName,
            ];
            $currentMonth->subMonth();
        }

        return view('dashboard.index', compact('dates', 'rentalData', 'personalData', 'months', 'totalDrivers', 'totalVehicles', 'totalBookings'));
    }
}
