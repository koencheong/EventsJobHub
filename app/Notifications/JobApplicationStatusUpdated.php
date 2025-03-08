<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class JobApplicationStatusUpdated extends Notification
{
    use Queueable;

    protected $application;

    public function __construct($application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Your job application for '" . ($this->application->event->name ?? 'Unknown Job') . "' has been updated to '" . ($this->application->status ?? 'Unknown Status') . "'.",
            'job_title' => $this->application->event->name ?? 'Unknown Job',
            'status' => $this->application->status ?? 'Unknown Status',
            'event_id' => $this->application->event->id ?? null,
            'url' => route('part-timers.dashboard'),
        ];
    }
    
}
