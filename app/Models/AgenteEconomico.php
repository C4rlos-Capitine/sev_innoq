<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgenteEconomico extends Model
{
    protected $table = 'agente_economico';
    protected $primaryKey = 'id_agente_economico';
    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'endereco',
        'provincia',
    ];
}
