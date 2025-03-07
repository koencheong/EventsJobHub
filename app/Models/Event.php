<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'job_type',
        'other_job_type',
        'description',
        'start_date',
        'end_date', 
        'start_time',
        'end_time',
        'location',
        'company_id',
        'payment_amount',
        'job_photos',
    ];
    
    protected $casts = [
        'job_photos' => 'array',
    ];

    public static function jobTypes()
    {
        return [
            'Cashier',
            'Promoter',
            'Model',
            'Waiter/Waitress',
            'Event Crew',
            'Food Crew',
            'Sales Assistant',
            'Others'
        ];
    }
    
    public function employer()
    {
        return $this->belongsTo(User::class, 'company_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class, 'event_id');
    }


}