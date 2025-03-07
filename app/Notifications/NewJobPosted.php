<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;
use App\Models\Event;

class NewJobPosted extends Notification
{
    use Queueable;

    protected $job;

    public function __construct(Event $job)
    {
        $this->job = $job;
    }

    public function via($notifiable)
    {
        return ['database']; // Save notification in the database
    }

    public function toArray($notifiable)
    {
        return [
            'message' => 'A new job has been posted and requires approval.',
            'job_id' => $this->job->id,
            'job_title' => $this->job->name,
            'company_id' => $this->job->company_id,
            'url' => route('events.show', $this->job->id)
        ];
    }
}
