<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SUBSTAFF extends Model
{
    use HasFactory;

    protected $table = 'subject_staff';

    protected $fillable = [ 'subject_id', 'staff_id' ];
    
    public function getSubject(){
        return $this->belongsTo(Subject::class, 'subject_id');
    }

}
