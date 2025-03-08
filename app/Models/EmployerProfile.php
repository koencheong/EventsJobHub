<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployerProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 
        'company_name', 
        'industry',
        'organization_type',
        'establishment_year',
        'about',
        'vision',
        'company_location',
        'team_size',
        'phone',
        'business_email',
        'company_website',
        'social_media',
        'company_logo',
    ];

    protected $casts = [
        'social_media' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}