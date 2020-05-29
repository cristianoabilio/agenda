<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Plan;
use App\Models\Status;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use  App\Http\Requests\StorePlan;

class PlanController extends Controller
{
    public function __construct()
    {
        $this->authorizeresource(Plan::class);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = Plan::TYPES;

        return view('plan.index', [
            'types' => $types
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

        $plans = Plan::where('company_id', Auth::user()->company_id)
            ->where('status_id', Status::ACTIVE)
            ->get();

        return view('plan.history', [
            'plans' => $plans
        ]);
    }     

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        $user = Auth::user();

        if ($user->company_id) {
            $query = Plan::where('company_id', $user->company_id);
                
        } else {
            $query = Plan::whereNull('company_id');                
        }

        $plans = $query->where('status_id', '<>', Status::DELETED)->get();

        if ($plans) {
            foreach ($plans as $plan) {

                switch ($plan->type) {
                    case 'M':
                        $plan->typeName = 'Mensalidade';
                    break;
                    case 'E':
                        $plan->typeName = 'Experimental';
                    break;
                    case 'C':
                        $plan->typeName = 'Créditos';
                    break;                                        
                }                
            }
        }

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
    public function store(StorePlan $request)
    {
        $response = DB::transaction(function () use ($request) {

            $id = $request->input('id');
            $classes = [];
            if ($id) {
                $plan = Plan::where('id', $id)->first();
                
                if ($plan) {

                    Plan::where('id', $id)
                    ->update($request->all());

                }
                $message = 'Atualização realizada com sucesso';
            } else {
                $company_id = Auth::user()->company_id;

                if ($company_id) {
                    $request->merge([
                        'company_id' => $company_id
                    ]);
                }
    
                $request->merge([
                    'status_id' => Status::ACTIVE,
                    'price' =>  number_format($request->input('price'), 2, '.', ''),
                ]);
    
                $plan = Plan::create($request->all());

                $message = 'Cadastro realizado com sucesso';
            }

            return json_encode([
                'status' => 'success', 'action' => 'notify',
                'message' => $message, 'data' => $plan
            ]);
        });

        return $response;
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
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $id = $request->input('id');        

        if ($id) {
            $plan = Plan::where('id', $id)->first();

            if ($plan) {

                $plan->status_id = Status::DELETED;
                $plan->save();

                return json_encode([
                    'status' => 'success', 
                    'message' => 'Plano excluído com sucesso.', 'data' => $plan
                ]);
            }
        }
    }
}
