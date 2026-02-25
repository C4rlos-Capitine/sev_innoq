<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    protected $table = 'item_pedido';
    protected $primaryKey = 'id_item_pedido';
    protected $fillable = [
        'quantidade',
        'valor_unitario',
        'valor_iva',
        'id_norma',
        'id_pedido',
    ];

    public function produto()
    {
        return $this->belongsTo(Norma::class, 'id_norma');
    }

    public function norma()
    {
        return $this->belongsTo(Norma::class, 'id_norma');
    }

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}
