<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'license_number', 'phone'];

    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
