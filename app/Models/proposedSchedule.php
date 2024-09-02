<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class proposedSchedule extends Model
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
    public function realSchedule()
    {
        return $this->belongsTo(CourseSchedule::class, 'course_schedule_id');
    }
}
