<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class enrollment extends Model
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

    // Many to One Relationship with Course Tables
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    // Many to One Relationship with User Tables for Instructors
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    // Many to One Relationship with User Tables for Students
    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // One to Many Relationship with Course Schedule Tables
    public function schedule()
    {
        return $this->hasMany(CourseSchedule::class, 'enrollment_id');
    }
}
