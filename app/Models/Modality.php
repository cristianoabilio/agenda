<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modality extends Model
{
    protected $table = 'modality';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

}
