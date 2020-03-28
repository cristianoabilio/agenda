<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\Auth;

class UserPlan extends Model
{
    protected $table = 'user_plan';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'plan_id', 'status_id', 'start', 'end', 'total', 'available', 'price', 'discount'];

    public function plan() {
        return $this->hasOne('App\Models\Plan', 'id', 'plan_id');
    }

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public static function getStudents($status_id){
        $data = self::where('status_id', $status_id)
        ->where('available', '>=', 1)
        ->with(['plan' => function($query) {
            $query->where('company_id', Auth::user()->company_id);
        }])
        ->with(['user' => function($query) {
            $query->orderBy('name', 'ASC');
        }])
        ->get();


        $students = [];

        if ($data) {
            foreach ($data as $k => $d) {
                $user = ['code' => $d->user_id, 'label' => $d->user->name];
                $students[] = $user;
            }
        }
        return collect($students);
    }
}
