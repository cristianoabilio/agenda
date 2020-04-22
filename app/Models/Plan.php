<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = 'plano';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'status_id', 'company_id', 'description', 'price', 'validity', 'type', 'quantidity', 'created_at'];

    const EXPERIMENTAL = 'E';

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }
}
