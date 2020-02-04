<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $table = 'profile';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'private'];

    const ADMIN = 1;
    const RESPONSABLE = 2;
    const TEACHER = 3;
    const STUDENT = 4;
    
    
}
