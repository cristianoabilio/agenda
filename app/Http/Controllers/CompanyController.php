<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

use App\User;
use App\Models\Plan;
use App\Models\Profile;
use App\Models\Status;

use Illuminate\Support\Facades\DB;

use App\Helpers\Date;

use  App\Http\Requests\Company\StoreCompany;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->authorizeresource(Company::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::get();        

        $plans  = Plan::whereNull('company_id')
            ->where('status_id', Status::ACTIVE)
            ->get();
            
        return view('company.index', [
            'items' => $company,
            'plans' => $plans,
            'fields' => json_encode(['id', 'name', 'email']),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $companies = Company::where('status_id', '<>', Status::DELETED)
                        ->with('responsable')->get();

        return json_encode([
            'status' => 'success', 
             'data' => $companies
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
    public function store(StoreCompany $request)
    {
        //return response()->json($request->all());
        $response = DB::transaction(function () use ($request) {
            $date = new Date();
            $request->merge([
                'document'  => preg_replace('/[^0-9]/', '', $request->input('document')),
                'phone'     => preg_replace('/[^0-9]/', '', $request->input('phone')),
                'cellphone' => preg_replace('/[^0-9]/', '', $request->input('cellphone')),
            ]);

            $id = $request->input('id');
            if ($id) {
                $company = Company::where('id', $id)->first();
                if ($company) {
                    Company::where('id', $id)
                        ->update($request->all());
                }
                $message = 'Empresa atualizada com sucesso';
            } else {
                $company = Company::create($request->all());
                $message = 'Empresa cadastrada com sucesso';
            }

            // usuario
            if ($id) {
                $user = User::where('email', $request->input('email'))->first();


                if ($user) {
                    $user->name = $request->input('responsable');
                    $user->save();
                        
                }
            } else {
                $request->merge([
                    'company_id'  => $company->id,
                    'perfil_id'     => Profile::SCHOOL
                ]);

                $request->merge([
                    'password' => str_random(40)
                ]);
                $user = User::create($request->all());
            }

            return json_encode([
                'status' => 'success', 'action' => 'notify',
                'message' => $message, 'data' => $company
            ]);
        });
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ModelsCompany  $modelsCompany
     * @return \Illuminate\Http\Response
     */
    public function show(ModelsCompany $modelsCompany)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ModelsCompany  $modelsCompany
     * @return \Illuminate\Http\Response
     */
    public function edit(ModelsCompany $modelsCompany)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ModelsCompany  $modelsCompany
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ModelsCompany $modelsCompany)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = $request->input('id');        

        if ($id) {
            $company = Company::where('id', $id)->first();

            if ($company) {

                $company->status_id = Status::DELETED;
                $company->save();

                User::where('company_id', $company->id)
                    ->where('status_id', Status::ACTIVE)
                    ->update(array('status_id' => Status::DELETED));

                return json_encode([
                    'status' => 'success', 
                    'message' => 'Empsa excluída com sucesso.', 'data' => $company
                ]);
                               
            }
        }
    }
}
