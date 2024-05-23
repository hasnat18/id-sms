<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransportRoute extends Model
{
    use HasFactory;

    protected $fillable = ['name'];



    public function routes_transport()
    {
        return $this->belongsToMany(Transport::class, 'route_transport');
    }
}
