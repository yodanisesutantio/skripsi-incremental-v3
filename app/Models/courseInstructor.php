<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class courseInstructor extends Model
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

    // Many to Many Relationship with Course Instructors
    public function course()
    {
        return $this->belongsTo(CourseInstructor::class, 'course_id');
    }

    // Many to Many Relationship with Course Instructors
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
