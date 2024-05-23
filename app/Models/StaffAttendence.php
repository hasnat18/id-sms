<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAttendence extends Model
{
    use HasFactory;

    protected $fillable = ['staff_id','time_in','time_out','add_at','month_off','status',];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function staffs()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
