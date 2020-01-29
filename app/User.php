<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'profile_id', 'password', 'document', 'gender', 'birthday', 'company_id', 'status_id', 'phone', 'cellphone'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'birthday'  => 'date:dmY',
    ];

    public function company() {
        return $this->hasOne('App\Models\Company');
    }

    public function status() {
        return $this->hasOne('App\Models\Status');
    }

    public function profile() {
        return $this->hasOne('App\Models\Profile');
    }
}
