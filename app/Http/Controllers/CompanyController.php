<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

use App\User;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company = Company::get();        

        return view('company.index', [
            'items' => $company,
            'fields' => json_encode(['id', 'name', 'email']),
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
     * @param  \App\ModelsCompany  $modelsCompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(ModelsCompany $modelsCompany)
    {
        //
    }
}
