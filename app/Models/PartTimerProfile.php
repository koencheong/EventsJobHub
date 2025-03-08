<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartTimerProfile extends Model
{
    protected $fillable = ['user_id', 'full_name', 'phone', 'location', 'bio', 'work_experience', 'work_photos'];
    
    protected $casts = [
        'work_photos' => 'array',
    ];
    
    public function partTimerProfile()
    {
        return $this->hasOne(PartTimerProfile::class, 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
