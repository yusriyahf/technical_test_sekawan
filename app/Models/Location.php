<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'address'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function vehicleLogs()
    {
        return $this->hasMany(VehicleLog::class);
    }
}
