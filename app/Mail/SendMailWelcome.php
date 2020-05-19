<?php

namespace App\Mail;

use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailWelcome extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('ext.cristiano@havea.com.br')
                ->subject('GymMate - Boas vindas')
                ->view('emails.users.welcome')
                ->with([
                    'name' => $this->user->name,
                    'email' => $this->user->email,
                    'password' => $this->user->password
                ]);
    }
}
