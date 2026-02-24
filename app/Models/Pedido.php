<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $primaryKey = 'id_pedido';
    protected $fillable = [
        'num_pedido',
        'data_pedido',
        'estado',
        'id_agente_economico',
        'id_entidade',
        'tipo_comprador',
        'nome_completo_comprador',
        'email_comprador',
        'telefone_comprador',
        'nuit_comprador',
        'codigo_pedido',
        'tipo_doc',
        'id_provincia',
        'endereco_comprador'
    ];

    public function agenteEconomico()
    {
        return $this->belongsTo(AgenteEconomico::class, 'id_agente_economico');
    }
    
    public function provincia()
    {
        return $this->belongsTo(Provincia::class, 'id_provincia');
    }

    public function entidade()
    {
        return $this->belongsTo(Entidade::class, 'id_entidade');
    }

    public function itens()
    {
        return $this->hasMany(ItemPedido::class, 'id_pedido');
    }

    public function referencia()
    {
        return $this->hasOne(\App\Models\referencia::class, 'id_pedido', 'id_pedido');
    }

}
