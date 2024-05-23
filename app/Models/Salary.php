<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id','salary','deduction','deduction_days','month_of','note','status'
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function staffs()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
