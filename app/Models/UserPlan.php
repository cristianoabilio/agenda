<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserPlan extends Model
{
    protected $table = 'user_plan';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'plan_id', 'status_id', 'start', 'end', 'total', 'available', 'price', 'discount'];

    public function plan() {
        return $this->hasOne('App\Models\Plan', 'id', 'plan_id');
    }
}
