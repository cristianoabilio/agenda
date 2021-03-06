<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\SendMailWelcome;
use App\Models\Status;
use App\Models\Profile;
use App\Http\Requests\ChangePassword;

use  App\Http\Requests\Users\StoreUser;
use Illuminate\Support\Facades\DB;
use App\Helpers\Date;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $profiles = [];

        if ($user->company_id) {
            $profiles = Profile::where('private', 0)->get();
        } else {
            $profiles = Profile::get();
        }
        
        
        return view('user.index', ['profiles' => $profiles]);
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
            $query = User::where('company_id', $user->company_id);
                
        } else {
            $query = User::whereNull('company_id');                
        }

        if (($request->input('name')) && !empty($request->input('name'))) {
            $query = $query->where('name', 'LIKE', '%'.preg_replace('/([%_])/', '\\$1', $request->input('name')).'%');
        }

        if (($request->input('profile_id')) && !empty($request->input('profile_id'))) {
            $query = $query->where('profile_id', $request->input('profile_id'));            
        }
        $users = $query->where('status_id', '<>', Status::DELETED)->get();

        if ($users) {
            foreach ($users as $user) {
                $plan = $user->plan()->latest()->first();

                if ($plan) {
                    $date = new Date();
                    $user->available = $plan->available;
                    $user->end = $date->dateFromSql($plan->end);
                    $user->plan_id = $plan->id;
                    $user->plan_status = $plan->status_id;
                    $user->status_name = ($plan->status_id == Status::ACTIVE) ? 'Ativo' : 'Expirado';
                }
            }
        }

        return json_encode([
            'status' => 'success', 
             'data' => $users,
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

    public function password(Request $request)
    {
        return view('user.reset-password', ['token' => '']);
    }

    public function updatePassword(ChangePassword $request)
    {
        //return response()->json($request->all());
        $password = $request->input('password');

        $user = User::where('id', Auth::user()->id)->first();
        $user->password = Hash::make($password);
        $user->save();
        
        $request->session()->flash('alert-success', 'Senha atualizada com sucesso');

        return redirect()->route("change-password");

    }
}
