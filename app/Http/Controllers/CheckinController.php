<?php

namespace App\Http\Controllers;


use App\Helpers\Date;
use App\Mail\SendCheckinMail;
use App\Models\Classes;
use App\Models\Checkin;
use App\Models\Profile;
use App\Models\Status;
use App\Models\UserPlan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CheckinController extends Controller
{
    public function __construct()
    {
        $this->authorizeresource(Checkin::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $students = UserPlan::getStudents(Status::ACTIVE);


        
        $weekday = date('w');

        //DB::enableQueryLog();
        $classes = Classes::where('weekday', $weekday)
            ->with(['teacher' => function($query) {
                $query->where('company_id', Auth::user()->company_id);
            }])
            ->with('modality.modality')
            ->with('level')
            ->get();
            //dd(DB::getQueryLog());

        $schedule = [];
        if ($classes) {
            foreach ($classes as $c) {
                $modality = ['id' => $c->id, 'name' => $c->modality->modality->name, 'start' => $c->start, 'level' => $c->level->name];
                $schedule[] = $modality;
            }
        }


        return view('checkin.index', [
            'students' => $students,
            'schedule' => collect($schedule),
            'selected' => collect([])
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function history(Request $request)
    {
        $status_id = $request->input('status_id', Status::WAITING);

        $checkins = Checkin::with(['class' => function($query) {
            $query->with(['teacher' => function($query) {
                $query->where('company_id', Auth::user()->company_id);
            }]);
            $query->with('modality.modality');
        }])
            ->where('status_id', $status_id)
            ->with('user')
            ->orderBY('created_at', 'DESC')
            ->limit(5)
            ->get();

        return view('checkin.history', [

        ]);
    } 

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $status_id = $request->input('status_id', Status::ACTIVE);
        $start = $request->input('start');
        $end = $request->input('end');
        $date = new Date();

        $start = ($start) ? $date->dateToSql($start) : date('Y-m-d H:i:s', strtotime(date('Y-m-d 00:00:00')."-30 days"));
        $end = ($end) ? $date->dateToSql($end) : date('Y-m-d H:i:s', strtotime(date('Y-m-d 23:59:59')));

        $checkins = Checkin::with(['class' => function($query) {
            $query->with(['teacher' => function($query) {
                $query->where('company_id', Auth::user()->company_id);
            }]);
            $query->with('modality.modality');
        }])
            ->whereBetween('created_at', [$start, $end])
            ->where('status_id', $status_id)
            ->with('user')
            ->orderBY('created_at', 'DESC')
            ->get();

        return json_encode([
            'status' => 'success', 
             'data' => $checkins
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
    public function company(Request $request)
    {        
        $response = DB::transaction(function () use ($request) { 

            $user_id = $request->input('user_id');
            $classes = $request->input('class_id');

            $status = 'success';
            if ($user_id) {
                $userPlan = UserPlan::where('user_id', $user_id)
                    ->where('status_id', Status::ACTIVE)
                    ->with(['plan' => function($query) {
                        $query->with(['company' => function($query) {
                            $query->where('id', Auth::user()->company_id);
                        }]);
                    }])    
                    ->first();

                if ($userPlan && $userPlan->available) {
                    $request->merge([
                        'status_id' => ($request->input('status_id')) ? $request->input('status_id') : Status::ACTIVE
                    ]);

                    $checkin = Checkin::create($request->all());
                    $message = 'Check in realizado com sucesso.';

                    $userPlan->available = $userPlan->available-1;
                    $userPlan->save();


                    $checkin = Checkin::with(['class' => function($query) {
                        $query->with(['teacher' => function($query) {
                            $query->where('company_id', Auth::user()->company_id);
                        }]);
                        $query->with('modality.modality');
                    }])
                    ->where('id', $checkin->id)
                    ->with('user')
                    ->first();

                    if (Auth::user()->profile_id != Profile::STUDENT) {
                        $to = 'cristianocafr@gmail.com';
                        Mail::to($to)->send(new SendCheckinMail($checkin, $userPlan)); 
                    }                    
                    
                } else {
                    $message = 'O aluno não tem mais créditos disponíveis.';
                    $status  = 'error';
                }
            }


            return json_encode([
                'status' => $status, 'action' => 'notify',
                'message' => $message, 'data' => $checkin
            ]);
        });  
        return $response;  


    }  


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $response = DB::transaction(function () use ($request) {           
            $id = $request->input('id');
            if ($id) {
                $checkin = Checkin::with(['class' => function($query) {
                    $query->with(['teacher' => function($query) {
                        $query->where('company_id', Auth::user()->company_id);
                    }]);
                    $query->with('modality.modality');
                }])
                ->where('status_id', Status::WAITING)
                ->where('id', $id)
                ->with('user')
                ->first();

                $checkin->status_id = Status::ACTIVE;
                $checkin->save();

                // atualiza creditos
                $plan = UserPlan::where('user_id', $checkin->user_id)
                    ->where('status_id', Status::ACTIVE)
                    ->with(['plan' => function($query) {
                        $query->with(['company' => function($query) {
                            $query->where('id', Auth::user()->company_id);
                        }]);
                    }]) 
                    ->first();

                if ($plan->available > 0) {
                    $plan->available = $plan->available-1;
                    $plan->save();
                }
           

                $to = 'cristianocafr@gmail.com';
                Mail::to($to)->send(new SendCheckinMail($checkin, $plan)); 
                $message = 'Check in realizado com sucesso';
            }

            
            return json_encode([
                'status' => 'success', 'action' => 'notify',
                'message' => $message, 'data' => $checkin
            ]);
        });
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Checkin  $checkin
     * @return \Illuminate\Http\Response
     */
    public function show(Checkin $checkin)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Checkin  $checkin
     * @return \Illuminate\Http\Response
     */
    public function edit(Checkin $checkin)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Checkin  $checkin
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Checkin $checkin)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Checkin  $checkin
     * @return \Illuminate\Http\Response
     */
    public function destroy(Checkin $checkin)
    {
        //
    }
}
