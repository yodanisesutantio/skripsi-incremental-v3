<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class drivingSchoolLicense extends Model
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

    // Default Value for licenseStatus attribute
    protected $attributes = [
        'licenseStatus' => 'Belum Divalidasi',
    ];

    // Many to One Relationship with User Tables for Admins
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
