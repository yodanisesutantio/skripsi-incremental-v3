<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class instructorCertificate extends Model
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

    // Default Value for certificateStatus attribute
    protected $attributes = [
        'certificateStatus' => 'Belum Divalidasi',
    ];

    // Many to One Relationship with User Tables for Instructors
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }
}
