<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'document', 'plan_id', 'responsable', 'phone', 'email', 'website'];
}
