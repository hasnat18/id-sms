<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;

    protected $fillable = [
            'title',
            'notice',
            'start_date',
            'end_date',
            'user_id',
            'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
