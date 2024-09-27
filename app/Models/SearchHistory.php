<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SearchHistory extends Model
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

    // Setting Relationship where an Instructor can only have 1 Admin
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
