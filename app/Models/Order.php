<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // protected $fillable = ['vehicle_id', 'user_id', 'location_id', 'status'];
    protected $guarded = ['id'];

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
