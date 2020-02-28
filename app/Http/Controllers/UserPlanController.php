<?php

namespace App\Http\Controllers;

use App\Models\UserPlan;
use App\Models\Plan;
use App\Models\Status;
use App\User;
use App\Helpers\Date;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use  App\Http\Requests\Credit\Store;

class UserPlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $plans = Plan::where('company_id', Auth::user()->company_id)
                    ->where('status_id', Status::ACTIVE)
                    ->get();

        return view('user.plan.index', ['plans' => $plans]);        

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
    public function store(Store $request)
    {

        $user = User::where('id', $request->input('user_id'))->first();
        $plan = Plan::where('id', $request->input('plan_id'))->first();

        if ($user) {
            $planActive = UserPlan::where('user_id', $user->id)
                            ->where('status_id', Status::ACTIVE)
                            ->with(['plan' => function($query) {
                                $query->with(['company' => function($query) {
                                    $query->where('id', Auth::user()->company_id);
                                }]);
                            }])->first();



            //return response()->json(['data' => date($planActive->end)]);
            if ($planActive) {

                $date = new Date();
                $days = $date->diffDate($planActive->end, date('Y-m-d'), '%R%a'); 

                
                $end = ($days>0) ? $planActive->end : date('Y-m-d');
                
                $request->merge([
                    'price' => $plan->price,
                    'total' => $plan->quantidity,
                    'available' => $plan->quantidity+$planActive->available,
                    'start' => date('Y-m-d'),
                    'validity' => $plan->validity,
                    'end'       => date('Y-m-d', strtotime('+'.$plan->validity.' days',strtotime($end))),
                    'discount' =>  number_format($request->input('discount'), 2, '.', ''),
                    'status_id' => Status::ACTIVE
                ]);
            } else {
                $request->merge([
                    'price' => $plan->price,
                    'total' => $plan->quantidity,
                    'available' => $plan->quantidity,
                    'start' => date('Y-m-d'),
                    'end'       => date('Y-m-d', strtotime('+'.$plan->validity.' days')),
                    'discount' =>  number_format($request->input('discount'), 2, '.', ''),
                    'status_id' => Status::ACTIVE
                ]);
            }
        }
        
        $response = DB::transaction(function () use ($request, $planActive) {
            $id = $request->input('id');

                $credit = UserPlan::create($request->all());
                $planActive->status_id = Status::RENOVED;
                $planActive->save();

                $message = 'Crédito cadastrado com sucesso';
            
                
            return json_encode([
                'status' => 'success', 'action' => 'notify',
                'message' => $message, 'data' => $credit
            ]);
        });
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserPlan  $userPlan
     * @return \Illuminate\Http\Response
     */
    public function show(UserPlan $userPlan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserPlan  $userPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(UserPlan $userPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserPlan  $userPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserPlan $userPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserPlan  $userPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserPlan $userPlan)
    {
        //
    }
}
