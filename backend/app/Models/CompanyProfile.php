<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'company_name',
        'profile_image',
        'contact_email',
        'phone_number',
        'country',
        'city',
        'address',
        'currency',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
