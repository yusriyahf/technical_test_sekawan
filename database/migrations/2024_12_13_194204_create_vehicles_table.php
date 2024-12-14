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
        // Schema::create('vehicles', function (Blueprint $table) {
        //     $table->id();
        //     $table->enum('vehicle_type', ['personal', 'rental']);
        //     $table->string('license_plate', 50);
        //     $table->string('vehicle_model')->nullable();
        //     $table->float('fuel_consumption')->nullable();
        //     $table->date('service_schedule')->nullable();
        //     $table->enum('status', ['available', 'in_use', 'under_maintenance']);
        //     $table->timestamps();
        // });
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('vehicle_name');
            $table->string('vehicle_number');
            $table->enum('type', ['personal', 'rental']);
            $table->float('fuel_consumption')->nullable();

            $table->enum('status', ['available', 'in_use', 'under_maintenance']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
