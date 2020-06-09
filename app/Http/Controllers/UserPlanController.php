<?php

namespace App\Http\Controllers;


use App\Mail\SendNewPlan;
use App\Mail\SendMailWelcome;
use App\Models\UserPlan;
use App\Models\Plan;
use App\Models\Profile;
use App\Models\Status;

use App\User;
use App\Helpers\Date;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use  App\Http\Requests\Credit\Store;
use  App\Http\Requests\Users\StoreUser;


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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        

        DB::enableQueryLog();
        $date = new Date();
        //return response()->json($date->dateToSql($request->input('start')));
        $query = UserPlan::where('status_id', Status::ACTIVE);

        if ($request->input('start') && !empty($request->input('start'))) {
            $query = $query->where('created_at', '>=', $date->dateToSql($request->input('start')));
        }

        if ($request->input('end') && !empty($request->input('end'))) {
            $query = $query->where('created_at', '<=', $date->dateToSql($request->input('end')));
        }

        if ($request->input('plan_id') && !empty($request->input('plan_id'))) {
            $query = $query->where('plan_id', $request->input('plan_id'));
        }

        $plans = $query->with(['plan' => function($query) {
            $query->with(['company' => function($query) {
                $query->where('id', Auth::user()->company_id);
            }]);
        }])
        ->with('user')
        ->get();

        //dd(DB::getQueryLog());
        
        return json_encode([
            'status' => 'success', 
             'data' => $plans,
             'message' => 'Busca realizada'
        ]);
    }   


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        

        DB::enableQueryLog();
        $date = new Date();
        //return response()->json($date->dateToSql($request->input('start')));
        $query = UserPlan::where('status_id', Status::ACTIVE);

        if ($request->input('start') && !empty($request->input('start'))) {
            $query = $query->where('created_at', '>=', $date->dateToSql($request->input('start')));
        }

        if ($request->input('end') && !empty($request->input('end'))) {
            $query = $query->where('created_at', '<=', $date->dateToSql($request->input('end')));
        }

        if ($request->input('plan_id') && !empty($request->input('plan_id'))) {
            $query = $query->where('plan_id', $request->input('plan_id'));
        }

        $plans = $query->where('user_id', Auth::user()->id)
        ->with('plan')
        ->with('plan.company')
        ->with('user')
        ->orderBy('created_at', 'DESC')
        ->limit(5)
        ->get();

        //dd(DB::getQueryLog());
        
        return json_encode([
            'status' => 'success', 
             'data' => $plans,
             'message' => 'Busca realizada'
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
    public function store(StoreUser $request)
    {
        $id = $request->input('id');
        
        $plan = Plan::where('id', $request->input('plan_id'))->first();


        if ($id) {
            $user = User::where('id', $id)->first();
        } else {

            $date = new Date();
            $request->merge([
                'document' => preg_replace('/[^0-9]/', '', $request->input('document')),
                'cellphone' => preg_replace('/[^0-9]/', '', $request->input('cellphone')),
                'birthday'  => $date->dateToSql($request->input('birthday')),
                'profile_id'    => Profile::STUDENT,
                'status_id'     => Status:: ACTIVE
            ]);


            $company_id = Auth::user()->company_id;

            if ($company_id) {
                $request->merge([
                    'company_id' => $company_id
                ]);
            }

            $password = str_random(8);
            $request->merge([
                'password' => Hash::make($password)
            ]);
            $user = User::create($request->all());
            $user->password = $password;

            $to = 'cristianocafr@gmail.com';
            Mail::to($to)->send(new SendMailWelcome($user));
            $message = 'Usuário cadastrado com sucesso';
        }
        

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
                    'status_id' => Status::ACTIVE,
                    'user_id'   => $user->id
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
                    'status_id' => Status::ACTIVE,
                    'user_id'   => $user->id
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
