<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyModality;
use App\Models\Modality;
use App\Models\Status;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ModalityController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('viewAny', CompanyModality::class);

        $modalities = Modality::orderBy('name')->get();

        $company_id = Auth::user()->company_id;
        $companyModalities = CompanyModality::where('company_id', $company_id)
        ->where('status_id', Status::ACTIVE)
        ->pluck('modality_id');


        return view('modality.index', ['modalities' => $modalities, 'selected' => $companyModalities]);        
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
        $response = DB::transaction(function () use ($request) {
            $company_id = Auth::user()->company_id;
            $items = $request->input('item');

            CompanyModality::where('company_id',$company_id)
                ->whereNotIn('modality_id', $items)
                ->update(['status_id' => Status::INACTIVE]);                        
            
            if ($items) {
                $modalities = [];
                foreach ($items as $item) {
                    $modality = [
                        'company_id' => $company_id, 
                        'modality_id' => $item,
                        'status_id'   => Status::ACTIVE
                    ];
                    CompanyModality::updateOrCreate($modality);
                }
                
            }

            return json_encode([
                'status' => 'success', 'action' => 'notify',
                'message' => 'Cadastro realizado com sucesso', 'data' => $items
            ]);

        });
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Modality  $modality
     * @return \Illuminate\Http\Response
     */
    public function show(Modality $modality)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modality  $modality
     * @return \Illuminate\Http\Response
     */
    public function edit(Modality $modality)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Modality  $modality
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Modality $modality)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Modality  $modality
     * @return \Illuminate\Http\Response
     */
    public function destroy(Modality $modality)
    {
        //
    }
}
