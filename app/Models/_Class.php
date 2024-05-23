<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class _Class extends Model
{
    use HasFactory;

    protected $fillable = ['section_id', 'name'];

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function admission()
    {
        return $this->hasOne(Admission::class, '__class_id');
    }

    public function subject()
    {
        return $this->hasMany(Subject::class, '__class_id');
    }

    public function student()
    {
        return $this->hasOne(Student::class, '__class_id');
    }

    public function students()
    {
        return $this->hasMany(Student::class, '__class_id');
    }

    public function results()
    {
        return $this->hasOne(Result::class, 'class_id');
    }

    public function live_class()
    {
        return $this->hasOne(LiveClass::class, 'class_id');
    }

    public function study_material()
    {
        return $this->hasOne(StudyMaterial::class, 'class_id');
    }
}
