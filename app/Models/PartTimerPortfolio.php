<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PartTimerPortfolio extends Model
{
    protected $fillable = ['user_id', 'full_name', 'phone', 'location', 'bio', 'work_experience', 'work_photos'];
    
    public function partTimerPortfolio()
    {
        return $this->hasOne(PartTimerPortfolio::class, 'user_id');
    }

}
