<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotedOrDemoted extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id', 'promoted_or_demoted', 'status'
    ];
}
