<?php

namespace App\Http\Controllers;


use App\Mail\SendNewPlan;
use App\Models\UserPlan;
use App\Models\Plan;
use App\Models\Status;
use App\User;
use App\Helpers\Date;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
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

        return view('user.plan.index', [
            'plans' => $plans,            
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


                $response = DB::transaction(function () use ($request, $planActive, $user) {
        
                        $credit = UserPlan::create($request->all());
                        
                        $planActive->status_id = Status::RENOVED;
                        $planActive->save();
        
                        $message = 'Crédito cadastrado com sucesso';
                    
                        $to = 'cristianocafr@gmail.com';
                        Mail::to($to)->send(new SendNewPlan($user, $credit)); 
                        
                    return json_encode([
                        'status' => 'success', 'action' => 'notify',
                        'message' => $message, 'data' => $credit
                    ]);
                });
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


                $response = DB::transaction(function () use ($request, $user) {
        
                        $credit = UserPlan::create($request->all());
        
                        $message = 'Crédito cadastrado com sucesso';
                    
                        $to = 'cristianocafr@gmail.com';
                        Mail::to($to)->send(new SendNewPlan($user, $credit)); 
                                               
                    return json_encode([
                        'status' => 'success', 'action' => 'notify',
                        'message' => $message, 'data' => $credit
                    ]);
                });
            }
        }
        

        

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

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');    

        if ($id) {
            $userPlan = UserPlan::where('id', $id)->first();

            if ($userPlan) {

                $userPlan->status_id = Status::DELETED;
                $userPlan->save();

                return json_encode([
                    'status' => 'success', 
                    'message' => 'Plano desativado com sucesso.', 'data' => $userPlan
                ]);
                               
            }
        }
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function expiration(Request $request)
    {
        $date = date('Y-m-d H:i:s', strtotime(date('Y-m-d 00:00:00')."+7 days"));   
        $items = [];

        $userPlan = UserPlan::where('status_id', Status::ACTIVE)
                    ->where('end', '<=', $date)
                    ->with('user')
                    ->with(['plan' => function($query) {
                        $query->with(['company' => function($query) {
                            $query->where('id', Auth::user()->company_id);
                        }]);
                    }])->get();

        if ($userPlan) {
            foreach ($userPlan as $plan) {
                $item = new \stdClass;
                $date = new Date();

                $item->id = $plan->user->id;
                $item->name = $plan->user->name;
                $item->email = $plan->user->email;
                $item->available = $plan->available;
                $item->end = $date->dateFromSql($plan->end);
                $item->plan_id = $plan->id;
                $item->plan_status = $plan->status_id;
                $item->status_name = ($plan->status_id == Status::ACTIVE) ? 'Ativo' : 'Expirado';
                $items[] = $item;
            }
        }

        return json_encode([
            'status' => 'success', 
             'data' => $items,
             'message' => 'Busca realizada'
        ]);
    }
}
