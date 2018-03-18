<?php

namespace App\Http\Projects\Notifications;

use Illuminate\Mail\Mailable;

class SendProjectInvitation extends Mailable
{
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.project-invite')
            ->with(['title' => 'demo', 'content' => 'demo'])
            ->subject("Project Management Tool - You've been invited to a Project");
    }
}
