<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Entidade extends Model
{
    protected $table = 'entidade';
    protected $primaryKey = 'id_entidade';
    protected $fillable = ['nome', 'email', 'telefone', 'endereco', 'provincia'];
}
