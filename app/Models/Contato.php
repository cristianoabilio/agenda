<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contato extends Model
{
    protected $table = 'contato';
    protected $primaryKey = 'id';
    protected $fillable = ['nome', 'sobrenome', 'email', 'telefone'];

    public function mensagens() {
        return $this->hasMany('App/Models/Mensagem', 'contato_id', 'id');
    }


}
