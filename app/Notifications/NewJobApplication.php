<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewJobApplication extends Notification
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
            'message' => 'A new job application has been submitted for your job.',
            'application_id' => $this->application->id,
            'job_title' => $this->application->event->name,
            'applicant_name' => $this->application->user->name,
            'url' => route('employer.jobs.applications', $this->application->event->id),
        ];
    }
}
