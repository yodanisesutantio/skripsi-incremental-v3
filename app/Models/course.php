<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class course extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    // Many to One Relationship with User Tables for Admins
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    // Many to One Relationship with User Tables for Instructors
    public function instructors()
    {
        return $this->belongsToMany(User::class, 'course_instructors', 'course_id', 'instructor_id')
                    ->withTimestamps();
    }

    // One to Many Relationship with Enrollment Tables
    public function enrollments()
    {
        return $this->hasMany(enrollment::class);
    }

    // Many to Many Relationship with Course Instructors
    public function courseInstructors()
    {
        return $this->hasMany(courseInstructor::class, 'course_id');
    }
}
