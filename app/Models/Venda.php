<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venda extends Model
{
    protected $table = 'venda';
    protected $primaryKey = 'id_venda';
    protected $fillable = ['data_venda', 'quantidade', 'id_produto', 'id_cliente'];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'id_produto');
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }
}
