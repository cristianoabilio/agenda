<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'status';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];

    const ACTIVE = 1;
    const INACTIVE = 2;
    const DELETED = 3;
}
