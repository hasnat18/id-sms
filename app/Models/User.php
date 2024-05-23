<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id');
    }

    public function getIsAdminAttribute()
    {
        return $this->roles()->where('name', 'admin')->exists();
    }

    public function getIsTeacherAttribute()
    {
        return $this->roles()->where('name', 'teacher')->exists();
    }

    public function getIsStudentAttribute()
    {
        return $this->roles()->where('name', 'student')->exists();
    }

    public function expense()
    {
        return $this->hasOne(Expense::class, 'user_id');
    }

    public function live_class()
    {
        return $this->hasOne(LiveClass::class, 'class_id');
    }

    public function notice_board()
    {
        return $this->hasOne(NoticeBoard::class, 'user_id');
    }

    public function study_material()
    {
        return $this->hasOne(StudyMaterial::class, 'class_id');
    }

}
