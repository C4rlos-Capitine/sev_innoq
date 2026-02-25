<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade\Pdf;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Pedido;
use App\Models\ItemPedido;

class RelatorioController extends Controller
{
    public function gerarPDF() { $pdf = Pdf::loadView('relatorio.exemplo', ['dados' => 'valor']); return $pdf->download('relatorio.pdf'); }

    public function gerarFacturaPDF($id) {
        $pedido = Pedido::with('referencia')->findOrFail($id);
        Log::info('Gerando fatura para pedido ID: '.$id);
        Log::info('Pedido data: '.json_encode($pedido));
    
        $itens = ItemPedido::where('id_pedido', $id)->get();
        Log::info('Itens do pedido: '.json_encode($itens));
        $pdf = Pdf::loadView('pedido.fatura', compact('pedido', 'itens'));
        return $pdf->download('fatura_pedido_'.$id.'.pdf');
    }
    
}
