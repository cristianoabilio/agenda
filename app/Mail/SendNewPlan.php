<?php

namespace App\Mail;


use App\User;
use App\Models\UserPlan;
use App\Helpers\Date;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewPlan extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, UserPlan $plan)
    {
        $this->user = $user;
        $this->plan = $plan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $date = new Date();
        return $this->from('ext.cristiano@havea.com.br')
        ->subject('GymMate - Novo Plano')
        ->view('emails.users.newplan')
        ->with([
            'name'      => $this->user->name,
            'company'   => $this->plan->plan->company->name,
            'total'     => $this->plan->total,
            'price'     => 'R$ '. number_format($this->plan->price - $this->plan->discount, 2, ',', '.'),
            'validate'  => $date->dateFromSql($this->plan->end),
            'available'  => $this->plan->available,
            

        ]);
    }
}
