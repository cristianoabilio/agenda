<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plano';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name', 'status_id', 'company_id', 
        'description', 'price', 'validity', 'type',
        'quantidity', 'created_at'
    ];

    const EXPERIMENTAL = 'E';

    const TYPES = ['C' => 'Créditos', 'M' => 'Mensalidade', 'E' => 'Experimental'];

    public function company()
    {
        return $this->belongsTo('App\Models\Company', 'company_id', 'id');
    }


    public function users() {
        return $this->hasOne('App\Models\UserPlan', 'plan_id', 'id');
    }
}
