<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class _Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'start_date',
        'end_date',
        'status'];

    public function fees()
    {
        return $this->hasOne(Fees::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class, '__session_id');
    }

}
