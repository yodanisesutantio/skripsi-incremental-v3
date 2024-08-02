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

    // Setting Relationship where an Instructor can only have 1 Admin
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Setting Relationship where an Admin can have more than 1 Instructors
    public function instructors()
    {
        return $this->hasMany(User::class, 'admin_id');
    }

    // Setting Relationship where an Admin can have more than on Driving School Licenses, to keep all the past records
    public function drivingSchoolLicense()
    {
        return $this->hasMany(drivingSchoolLicense::class);
    }

    // Setting Relationship where an Instructor can have more than one Instructor Certificate, to keep all the past records
    public function instructorCertificate()
    {
        return $this->hasMany(instructorCertificate::class);
    }

    // Setting Relationship where Admin and Instructor can have more than 1 Course
    public function courses()
    {
        return $this->hasMany(Course::class); // For admins/instructors
    }

    // Setting Relationship where Student can have only 1 Course
    public function singleCourse()
    {
        return $this->hasOne(Course::class); // For users/students
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'instructor_id');
    }

    // Setting Relationship where Admin can have more than 1 Payment Methods
    public function payment_methods()
    {
        return $this->hasMany(PaymentMethod::class);
    }
}
