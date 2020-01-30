<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompanyModality extends Model
{
    protected $table = 'company_modality';
    protected $primaryKey = 'id';
    protected $fillable = ['company_id', 'modality_id'];
}
