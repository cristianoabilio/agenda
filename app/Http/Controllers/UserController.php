<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Status;

use  App\Http\Requests\Users\StoreUser;
use Illuminate\Support\Facades\DB;
use App\Helpers\Date;

use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.index', []);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function filter()
    {
        $users = User::whereNull('company_id')
            ->where('status_id', '<>', Status::DELETED)->get();
        return json_encode([
            'status' => 'success', 
             'data' => $users
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
        $response = DB::transaction(function () use ($request) {
            $date = new Date();
            $request->merge([
                'document' => preg_replace('/[^0-9]/', '', $request->input('document')),
                'phone' => preg_replace('/[^0-9]/', '', $request->input('phone')),
                'cellphone' => preg_replace('/[^0-9]/', '', $request->input('cellphone')),
                'birthday'  => $date->dateToSql($request->input('birthday'))
            ]);

            $id = $request->input('id');
            if ($id) {
                $user = User::where('id', $id)->first();
                if ($user) {
                    User::where('id', $id)
                        ->update($request->all());
                }
                $message = 'Usuário atualizado com sucesso';
            } else {
                $request->merge([
                    'password' => str_random(40)
                ]);
                $user = User::create($request->all());
                $message = 'Usuário cadastrado com sucesso';
            }

            return json_encode([
                'status' => 'success', 'action' => 'notify',
                'message' => $message, 'data' => $user
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUser $request)
    {
        
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
            $user = User::where('id', $id)->first();

            if ($user) {
                if ($user->id == Auth::user()->id) {
                    return json_encode([
                        'status' => 'error', 
                        'message' => 'O usuário não pode se excluir.', 'data' => $user
                    ]);
                } else {
                    $user->status_id = Status::DELETED;
                    $user->save();

                    return json_encode([
                        'status' => 'success', 
                        'message' => 'Usuário excluído com sucesso.', 'data' => $user
                    ]);
                }                
            }
        }
    }
}
