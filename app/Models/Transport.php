<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transport extends Model
{
    use HasFactory;

    protected $fillable = [
        'vehicle_number',
        'vehicle_model',
        'driver_name',
        'driver_phone',
        'note',
    ];


    public function transport_routes()
    {
        return $this->belongsToMany(TransportRoute::class, 'route_transport');
    }

    public function staff()
    {
        return $this->hasOne(Staff::class,'transport_id');
    }

    public function transport()
    {
        return $this->hasOne(Admission::class,'transport_id');
    }
}
