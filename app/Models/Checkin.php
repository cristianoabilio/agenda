<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkin extends Model
{
    protected $table = 'checkin';
    protected $primaryKey = 'id';
    protected $fillable = ['user_id', 'class_id', 'status_id'];

    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

    public function class() {
        return $this->hasMany('App\Models\Classes', 'id', 'class_id');
    }

}
