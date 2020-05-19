<?php

namespace App\Mail;

use App\User;
use App\Models\Checkin;
use App\Models\UserPlan;
use App\Helpers\Date;


use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendCheckinMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Checkin $checkin, UserPlan $plan)
    {
        $this->checkin = $checkin;
        $this->user = $checkin->user;
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
        ->subject('GymMate - Registro de Atividade')
        ->view('emails.users.checkin')
        ->with([
            'name'      => $this->user->name,
            'company'   => $this->plan->plan->company->name,
            'available'  => $this->plan->available, 
            'date'       => date('d/m/Y H:i', strtotime($this->checkin->created_at)), //$date->dateFromSql($this->checkin->created_at),
            'class'      => $this->checkin->class->modality->modality->name
        ]);
    }
}
