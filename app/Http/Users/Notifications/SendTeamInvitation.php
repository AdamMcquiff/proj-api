<?php

namespace App\Http\Users\Notifications;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendTeamInvitation extends Notification
{
    public $user_id;
    public $team_id;

    public function __construct($user_id, $team_id)
    {
        $this->user_id = $user_id;
        $this->team_id = $team_id;
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
            ->subject('Project Management Tool - You\'ve been invited to a Team')
            ->line('You are receiving this email because someone has invited you to a team.')
            ->action('Accept Invitation', url(config('app.url').route('invitation.team', ['accept' => 1, 'user_id' => $this->user_id, 'team_id' => $this->team_id], false)))
            ->line('If you do not want to join this team, you can disregard this email.');
    }
}
