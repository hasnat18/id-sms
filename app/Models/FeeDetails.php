<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'fee_id',
        'fee_type',
        'fee_amount',
        ];

    public function feees()
    {
        return $this->belongsTo(Fees::class, 'fee_id');
    }
}
