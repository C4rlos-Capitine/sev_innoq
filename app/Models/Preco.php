<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Preco extends Model
{
    protected $table = 'precos';
    protected $primaryKey = 'id_preco';
    protected $fillable = ['valor', 'data_inicio', 'data_fim', 'id_norma'];

    public function norma()
    {
        return $this->belongsTo(Norma::class, 'id_norma');
    }
}
