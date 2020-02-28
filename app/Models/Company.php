<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'document', 'plan_id', 'status_id', 'responsable', 'cellphone', 'phone', 'email', 'website'];


    public function users() {
        return $this->hasMany('App\User', 'company_id', 'id');
    }

    public function responsable() {
        return $this->hasOne('App\User', 'company_id', 'id')->where('users.profile_id', '2');
    }

    public function plans() {
        return $this->hasMany('App\Models\Plan', 'company_id', 'id');
    }
}
