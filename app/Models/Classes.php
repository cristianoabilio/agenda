<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    protected $table = 'classes';
    protected $primaryKey = 'id';
    protected $fillable = ['modality_id', 'teacher_id', 'level_id', 'start', 'end', 'description', 'weekday'];


    public function modality() {
        return $this->hasOne('App\Models\CompanyModality', 'id', 'modality_id');
    }

    public function teacher() {
        return $this->hasOne('App\User', 'id', 'teacher_id');
    }

    public function level() {
        return $this->hasOne('App\Models\Level', 'id', 'level_id');
    }

    public function checkin() {
        return $this->hasOne('App\Models\Checkin', 'id', 'class_id');
    }
}
