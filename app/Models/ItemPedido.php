<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table = 'item_pedido';
    protected $primaryKey = 'id_item_pedido';
    protected $fillable = [
        'quantidade',
        'preco_unitario',
        'id_produto',
        'id_pedido',
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}
