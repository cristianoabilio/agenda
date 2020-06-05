<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\CompanyModality;
use App\Models\Level;
use App\Models\Profile;
use App\Models\Status;
use App\User;
use Illuminate\Http\Request;

use  App\Http\Requests\StoreClasses;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClassesController extends Controller
{
    public function __construct()
    {
        $this->authorizeresource(Classes::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $teachers = User::where('company_id', $user->company_id)
            ->where('status_id', Status::ACTIVE)
            ->where('profile_id', Profile::TEACHER)
            ->get();

        $modalities = CompanyModality::where('company_id', $user->company_id)
            ->with('modality')
            ->get();

        $levels = Level::get();

        $weekdays = [
            array('id' =>'0', 'name' => 'Domingo'), 
            array('id' =>'1', 'name' => 'Segunda-feira'), 
            array('id' =>'2', 'name' => 'Terça-feira'), 
            array('id' =>'3', 'name' => 'Quarta-feira'), 
            array('id' =>'4', 'name' => 'Quinta-feira'), 
            array('id' =>'5', 'name' => 'Sexta-feira'), 
            array('id' =>'6', 'name' => 'Sábado'),   
        ];

        return view('classes.index', [
            'teachers'      => $teachers,
            'modalities'    => $modalities,
            'levels'        => $levels, 
            'weekdays'      => json_encode($weekdays)
        ]);
    }



     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {
        if (Auth::user()->profile_id == Profile::STUDENT) {
            //return response()->json([$request->all()]);
            $companies = Classes::with(['teacher' => function($query) use ($request) {
                $query->where('company_id', $request->input('company_id'));
            }])
            ->where('weekday', date('w'))
            ->where('status_id', Status::ACTIVE)
            ->with('modality.modality')
            ->with('level')
            ->get();
        } else {
            $companies = Classes::with(['teacher' => function($query) {
                $query->where('company_id', Auth::user()->company_id);
            }])
                ->where('status_id', Status::ACTIVE)
                ->with('modality.modality')
                ->with('level')
                ->get();

                $companies = [];
        }

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
    public function store(StoreClasses $request)
    {
        $response = DB::transaction(function () use ($request) {           
            $id = $request->input('id');
            $classes = [];
            if ($id) {
                $class = Classes::where('id', $id)->first();
                
                if ($class) {

                    $item = $request->input('item');

                    $request->merge([
                        'weekday'  => $item,
                    ]);

                    Classes::where('id', $id)
                    ->update($request->except(['item']));

                }
                $message = 'Aula atualizada com sucesso';
            } else {
                $items = $request->input('item');
                
                foreach ($items as $k => $item) {
                    $request->merge([
                        'weekday'  => $item,
                    ]);
                    $classes[] = $request->all();
                    Classes::create($request->all());
                }            
                $message = 'Aula cadastrada com sucesso';
            }

            
            return json_encode([
                'status' => 'success', 'action' => 'notify',
                'message' => $message, 'data' => $classes
            ]);
        });
        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function show(Classes $classes)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function edit(Classes $classes)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Classes  $classes
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Classes $classes)
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
            $class = Classes::where('id', $id)->first();

            if ($class) {

                $class->status_id = Status::DELETED;
                $class->save();

                return json_encode([
                    'status' => 'success', 
                    'message' => 'Aula excluída com sucesso.', 'data' => $class
                ]);
            }
        }
    }
}
