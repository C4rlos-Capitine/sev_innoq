<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class referencia extends Model
{
    protected $table = 'referencia';
    protected $primaryKey = 'id_referencia';
    protected $fillable = [
        'id_pedido',
        'status',
        'reference',
        'entity',
        'messageId',
        'value'
    ];

    public function pedido()
    {
        return $this->belongsTo(Pedido::class, 'id_pedido');
    }
}
