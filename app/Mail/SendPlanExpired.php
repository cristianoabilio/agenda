<?php

namespace App\Mail;


use App\Helpers\Date;
use App\Models\Company;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPlanExpired extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Company $company, $plans)
    {
        $this->company = $company;
        $this->plans = $plans;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd($this->plans->users);
        $date = new Date();
        return $this->from('ext.cristiano@havea.com.br')
        ->subject('GymMate - Planos expirados')
        ->view('emails.plan.expired')
        ->with([
            'company'    => $this->company->name,
            'today'      => date('d/m/Y'), //$date->dateFromSql($this->checkin->created_at),
            'plans'      => $this->plans,
        ]);
    }
}
