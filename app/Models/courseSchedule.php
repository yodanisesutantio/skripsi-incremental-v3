<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseSchedule extends Model
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

    // Many to One Relationship with Enrollment Tables
    public function enrollment()
    {
        return $this->belongsTo(enrollment::class, 'enrollment_id');
    }

    // Many to One Relationship with Course Tables
    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id')->with('admin');
    }

    // Many to One Relationship with Instructors
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
