<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Norma extends Model
{
    protected $table = 'norma';
    protected $primaryKey = 'id_norma';
    protected $fillable = ['titulo', 'descricao', 'codigo'];
    public $timestamps = true;

    public function precos()
    {
        return $this->hasMany(Preco::class, 'id_norma');
    }

    public function itemPedidos()
    {
        return $this->hasMany(ItemPedido::class, 'id_norma');
    }

    public function documentos()
    {
        return $this->hasMany(Documento::class, 'chave_primaria', 'id_norma')->where('nome_tabela', 'norma');
    }
}
