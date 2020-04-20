<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\UserPlan;
use App\Models\Status;

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
        $this->line('Display this on the screen');

        $today = date('Y-m-d');

        $plans = UserPlan::where('end', '<', $today)
            ->where('status_id', Status::ACTIVE)            
            ->update(['status_id' => Status::INACTIVE]);

        //$this->table([], $plans);    

        $this->line('Updated plan less than '.$today);    

    }
}
