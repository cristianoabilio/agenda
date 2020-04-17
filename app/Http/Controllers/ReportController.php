<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Checkin;
use App\Models\Classes;
use App\Models\CompanyModality;
use App\Models\Plan;
use App\Models\UserPlan;
use App\Models\Status;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Carbon\Carbon;


class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('report.index');
    }

    public function bar(Request $request) 
    {
        $from = strtotime("-7 days");
        $today = date('Y-m-d');


        $modalities = CompanyModality::where('company_id', Auth::user()->company_id)
                        ->with('modality')
        ->get();

        $columns = $rows = $labels = [];

        
        foreach ($modalities as $m) {
            $columns[] = [$m->modality->name];
            

            $count = [];
            
            DB::enableQueryLog();
            for ($i = 0; $i <7; $i++) {
                $checkins = 0;
                $end = date('Y-m-d H:i:s', strtotime(date('Y-m-d 23:59:59')."-".$i." days"));
                $start = date('Y-m-d H:i:s', strtotime(date('Y-m-d 00:00:00')."-".$i." days"));

                if (count($labels) < 7) {
                    $labels[] = date('d/m', strtotime("-".$i." days"));
                }
                
                $class = Classes::where('modality_id', $m->id)
                    ->with(['teacher' => function($query) {
                        $query->where('company_id', Auth::user()->company_id);
                    }])
                    ->get()->pluck('id');
                
                $total = Checkin::where('status_id', Status::ACTIVE)
                    ->whereBetween('created_at', [$start, $end])
                    ->whereIn('class_id', $class)
                    ->get()->count();
                    
                $count[] = $total;

                   // dd(DB::getQueryLog());

            }
            $rows[] = $count;   

        }   


        $totalDay = [];
        
        for ($i = 0; $i <7; $i++) {
            $checkins = 0;
            $end = date('Y-m-d H:i:s', strtotime(date('Y-m-d 23:59:59')."-".$i." days"));
            $start = date('Y-m-d H:i:s', strtotime(date('Y-m-d 00:00:00')."-".$i." days"));


            $total =  Checkin::where('status_id', Status::ACTIVE)
                    ->whereBetween('created_at', [$start, $end])
                    ->with(['class' => function($query) {
                        $query->with(['teacher' => function($query) {
                            $query->where('company_id', Auth::user()->company_id);
                        }]);
                    }])
                    ->get()->count();

            $totalDay[] = [date("D M d Y H:i:s O", strtotime(date('Y-m-d 00:00:00')."-".$i." days")), $total];

        }

        return response()->json([
            'status' => 'success', 
            'columns' => $columns,
            'to' => $today,
            'from' => $from,
            'labels' => $labels,
            'values' => $rows,
        ]);
    }


    public function bubble(Request $request)
    {
        for ($i = 0; $i <7; $i++) {
            $checkins = 0;
            $end = date('Y-m-d H:i:s', strtotime(date('Y-m-d 23:59:59')."-".$i." days"));
            $start = date('Y-m-d H:i:s', strtotime(date('Y-m-d 00:00:00')."-".$i." days"));


            $total =  Checkin::where('status_id', Status::ACTIVE)
                    ->whereBetween('created_at', [$start, $end])
                    ->with(['class' => function($query) {
                        $query->with(['teacher' => function($query) {
                            $query->where('company_id', Auth::user()->company_id);
                        }]);
                    }])
                    ->get()->count();

            $totalDay[] = [date("Y-m-d H:i:s", strtotime(date('Y-m-d 00:00:00')."-".$i." days")), $total];

        }

        return response()->json([
            'status' => 'success', 
            'data' => $totalDay,
            'start' => date('Y-m-d H:i:s', strtotime(date('Y-m-d 00:00:00')."-7 days")),
            'end' => date('Y-m-d 00:00:00')
            
        ]);
    }


    public function line(Request $request)
    {

        $plans = Plan::where('company_id', Auth::user()->company_id)
                    ->where('status_id', Status::ACTIVE)
                    ->get();


        $labels = $days = $values = [];
        foreach ($plans as $p) {
            $labels[] = $p->name;

            $total = [];
            for ($i = 0; $i <7; $i++) {
                
                $end = date('Y-m-d H:i:s', strtotime(date('Y-m-d 23:59:59')."-".$i." days"));
                $start = date('Y-m-d H:i:s', strtotime(date('Y-m-d 00:00:00')."-".$i." days"));
    
    
                $total[] =  UserPlan::whereBetween('created_at', [$start, $end])
                        ->where('plan_id', $p->id)
                        
                        ->get()->count();
    
                if (count($days) < 7) {
                    $days[] = [date("d/m", strtotime(date('Y-m-d 00:00:00')."-".$i." days"))];
                }                                   
    
            }
            $values[] = $total;

        }           

        return response()->json([
            'status' => 'success', 
            'start' => date('Y-m-d H:i:s', strtotime(date('Y-m-d 00:00:00')."-7 days")),
            'end' => date('Y-m-d 00:00:00'),
            'plans' => $labels,
            'labels' => $days,
            'values' => $values
            
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
