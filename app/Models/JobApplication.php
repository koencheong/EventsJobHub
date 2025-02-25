<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'event_id',
        'status',
    ];

    // Relationship with the User model (Part-timer)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with the Event model (Job)
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }
}
