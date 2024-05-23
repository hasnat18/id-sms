<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gatepass extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'relation',
        'phone_number',
        'address',
        'cnic',
        'time_in',
        'time_out',
    ];
}
