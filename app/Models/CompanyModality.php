<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyModality extends Model
{
    protected $table = 'company_modality';
    protected $primaryKey = 'id';
    protected $fillable = ['company_id', 'modality_id'];

    public function modality() {
        return $this->hasOne('App\Models\Modality', 'id', 'modality_id');
    }

    public function company() {
        return $this->hasOne('App\Models\Company', 'id', 'company_id');
    }
}
