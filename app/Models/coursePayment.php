<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class coursePayment extends Model
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

    // Default Value for paymentStatus attribute
    protected $attributes = [
        'paymentStatus' => 0,
    ];

    // One to One Relationship with Enrollment Tables
    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class);
    }
}
