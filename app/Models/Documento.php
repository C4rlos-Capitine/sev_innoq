<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    protected $table = 'documento';
    protected $primaryKey = 'id_documento';
    public $timestamps = true;

    // Fields according to migration
    protected $fillable = [
        'path',
        'nome_tabela',
        'chave_primaria',
    ];

    public function norma()
    {
        return $this->belongsTo(Norma::class, 'chave_primaria', 'id_norma');
    }
}
