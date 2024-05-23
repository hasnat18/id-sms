<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [ 'expense', 'note', 'user_id','date'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
