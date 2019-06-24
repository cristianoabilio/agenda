<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mensagem extends Model
{
    protected $table = 'mensagem';
    protected $primaryKey = 'id';
    protected $fillable = ['contato_id', 'mensagem'];

    public function contato() {
        return $this->hasOne('App/Models/Contato', 'id', 'contato_id');
    }
}
