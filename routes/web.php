<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\VehicleController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::middleware(['admin'])->group(function () {
        // Location
        Route::get('/location', [LocationController::class, 'index']);
        Route::get('/location/create', [LocationController::class, 'create']);
        Route::post('/location/create', [LocationController::class, 'store']);
        Route::get('/location/{id}/edit', [LocationController::class, 'edit']);
        Route::put('/location/{id}', [LocationController::class, 'update']);
        Route::delete('/location/{id}', [LocationController::class, 'destroy']);

        // Driver
        Route::get('/driver', [DriverController::class, 'index']);
        Route::get('/driver/create', [DriverController::class, 'create']);
        Route::post('/driver/create', [DriverController::class, 'store']);
        Route::get('/driver/{id}/edit', [DriverController::class, 'edit']);
        Route::put('/driver/{id}', [DriverController::class, 'update']);
        Route::delete('/driver/{id}', [DriverController::class, 'destroy']);

        // Vehicle
        Route::get('/vehicle', [VehicleController::class, 'index']);
        Route::get('/vehicle/create', [VehicleController::class, 'create']);
        Route::post('/vehicle/create', [VehicleController::class, 'store']);
        Route::get('/vehicle/{id}/edit', [VehicleController::class, 'edit']);
        Route::put('/vehicle/{id}', [VehicleController::class, 'update']);
        Route::delete('/vehicle/{id}', [VehicleController::class, 'destroy']);

        // Order
        Route::get('/order/create', [OrderController::class, 'create']);
        Route::post('/order/create', [OrderController::class, 'store']);
        Route::get('/order/{id}/edit', [OrderController::class, 'edit']);
        Route::put('/order/{id}', [OrderController::class, 'update']);
        Route::delete('/order/{id}', [OrderController::class, 'destroy']);
    });

    Route::middleware(['approver'])->group(function () {
        Route::put('/approve/{id}', [OrderController::class, 'approve']);
        Route::put('/rejected/{id}', [OrderController::class, 'rejected']);
    });
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/order', [OrderController::class, 'index']);


    Route::post('/logout', [AuthController::class, 'logout']);
});
