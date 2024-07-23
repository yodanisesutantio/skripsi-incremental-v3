<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    // public function drivingSchoolLicense() {
    //     return $this->hasOne(drivingSchoolLicense::class);
    // }

    public function courses()
    {
        return $this->hasMany(Course::class); // For admins/instructors
    }

    public function singleCourse()
    {
        return $this->hasOne(Course::class); // For users/students
    }
}
