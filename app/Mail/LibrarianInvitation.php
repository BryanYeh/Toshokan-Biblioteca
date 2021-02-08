<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Invitation;

class LibrarianInvitation extends Mailable
{
    use Queueable, SerializesModels;

    protected $invitation;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Invitation $invitation)
    {
        $this->invitation = $invitation;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.librarian_invitation')
                    ->with([
                        'invitation_token' => $this->invitation->invitation_token,
                        'first_name' => $this->invitation->first_name,
                        'last_name' => $this->invitation->last_name,
                        'email' => $this->invitation->email
                    ]);
    }
}
