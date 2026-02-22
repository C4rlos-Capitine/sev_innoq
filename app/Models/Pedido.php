<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedido';
    protected $primaryKey = 'id_pedido';
    protected $fillable = [
        'data',
        'status',
        'id_agente_economico',
        'id_entidade',
    ];

    public function agenteEconomico()
    {
        return $this->belongsTo(AgenteEconomico::class, 'id_agente_economico');
    }

    public function entidade()
    {
        return $this->belongsTo(Entidade::class, 'id_entidade');
    }

    public function itens()
    {
        return $this->hasMany(ItemPedido::class, 'id_pedido');
    }
}
