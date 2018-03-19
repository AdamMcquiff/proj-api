<?php

namespace App\Http\Projects\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendProjectInvitation extends Notification
{
    public $user_id;
    public $project_id;

    public function __construct($user_id, $project_id)
    {
        $this->user_id = $user_id;
        $this->project_id = $project_id;
    }

    /**
     * Get the notification's channels.
     *
     * @param  mixed  $notifiable
     * @return array|string
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Build the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Project Management Tool - You\'ve been invited to a Project')
            ->line('You are receiving this email because someone has invited you to a project.')
            ->action('Accept Invitation', url(config('app.url').route('invitation.project', ['accept' => 1, 'user_id' => $this->user_id, 'project_id' => $this->project_id], false)))
            ->line('If you do not want to join this project, you can disregard this email.');
    }
}
