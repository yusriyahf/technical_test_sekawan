<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicle_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehicle_id')->constrained('vehicles'); // ID kendaraan
            $table->foreignId('location_id')->constrained('locations'); // Lokasi penggunaan kendaraan
            $table->decimal('fuel_consumption', 8, 2); // Konsumsi BBM
            $table->timestamp('usage_date'); // Tanggal penggunaan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_logs');
    }
};
