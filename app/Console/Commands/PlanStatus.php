<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Mail\SendPlanExpired;
use App\Models\Company;
use App\Models\Plan;
use App\Models\UserPlan;
use App\Models\Status;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class PlanStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'plan:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user plan status to inactive if date is less than today';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Expiring plans with date less than today');

        $today = date('Y-m-d');


        $companies = Company::where('status_id', Status::ACTIVE)
            ->get();


        foreach ($companies as $company)  {
            
            $id = $company->id;

            $plans = UserPlan::where('end', '<', $today)
                ->where('user_plan.status_id', Status::ACTIVE)
                ->join('plano', 'plano.id', '=', 'user_plan.plan_id')
                ->where('plano.company_id', $id)
                ->with('user')
                ->with('plan')
                ->get();


            if ($plans->count()) {

                    $to = 'cristianocafr@gmail.com';
                    Mail::to($to)->send(new SendPlanExpired($company, $plans));                                 
                
            }   
            //$this->table([], $plans);    
        }  

        $plans = UserPlan::where('end', '<', $today)
            ->where('status_id', Status::ACTIVE)            
            ->update(['status_id' => Status::INACTIVE]);


        $this->line('Updated plan less than '.$today);    

    }
}
