<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_number', 'type', 'location_id'];

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function vehicleLogs()
    {
        return $this->hasMany(VehicleLog::class);
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
