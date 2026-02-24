<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Pedido;
use App\Models\ItemPedido;
use App\Models\Preco;
use App\Models\Norma;
use GuzzleHttp\Client;
use App\Models\referencia;
use Illuminate\Support\Facades\Log;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pedidos = Pedido::with(['referencia'])->orderBy('data_pedido', 'desc')->get();
        //return response()->json($pedidos);
        return view('pedido.index', compact('pedidos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $total_amout = 0;

        foreach(json_decode($request->input('items'), true) as $it){
            $valor_unitario = isset($it['valor_unitario']) ? floatval($it['valor_unitario']) : 0;
            $quantidade = intval($it['quantidade'] ?? 1);
            $total_amout += ($valor_unitario * $quantidade);
        }

         // Gerar referência de pagamento
         $referenciaData = $this->gerarReferenciaChamadaApi($total_amout);
         Log::info('Referencia API Response: '.json_encode($referenciaData));
         if(isset($referenciaData->error) || !isset($referenciaData->reference)){
             $errorMsg = isset($referenciaData->error) ? $referenciaData->error : 'Referência não disponível';
             return back()->withInput()->with('ErroRef', 'Erro ao gerar referência de pagamento: '.$errorMsg);
         }

        $data = $request->validate([
            'tipo_comprador' => 'nullable|string',
            'nome_completo_comprador' => 'required|string',
            'email_comprador' => 'nullable|email',
            'telefone_comprador' => 'nullable|string',
            'nuit_comprador' => 'nullable|string',
            'id_provincia' => 'nullable|integer',
            'endereco_comprador' => 'nullable|string',
            'items' => 'required|string'
        ]);

        $items = json_decode($request->input('items'), true);
        if(!$items || !is_array($items) || count($items) === 0){
            return back()->withInput()->with('error', 'Carrinho vazio');
        }

        DB::beginTransaction();
        try{
            $pedido = Pedido::create([
                'num_pedido' => 'PED-'.time(),
                'data_pedido' => Carbon::now()->toDateString(),
                'estado' => 'pendente',
                'tipo_comprador' => $data['tipo_comprador'] ?? null,
                'nome_completo_comprador' => $data['nome_completo_comprador'] ?? null,
                'email_comprador' => $data['email_comprador'] ?? null,
                'telefone_comprador' => $data['telefone_comprador'] ?? null,
                'nuit_comprador' => $data['nuit_comprador'] ?? null,
                'id_provincia' => $data['id_provincia'] ?? null,
                'endereco_comprador' => $data['endereco_comprador'] ?? null,
                'codigo_pedido' => uniqid('COD_'),
            
            ]);

            foreach($items as $it){
                $id_norma = $it['id_norma'] ?? null;
                $quantidade = intval($it['quantidade'] ?? 1);
                $valor_unitario = isset($it['valor_unitario']) ? floatval($it['valor_unitario']) : 0;
                $valor_iva = isset($it['valor_iva']) ? floatval($it['valor_iva']) : 0;

                // if no unit price provided try to fetch latest preco
                if(empty($valor_unitario) && $id_norma){
                    $preco = Preco::where('id_norma', $id_norma)->orderBy('created_at','desc')->first();
                    if($preco) $valor_unitario = floatval($preco->valor);
                }

                ItemPedido::create([
                    'id_pedido' => $pedido->id_pedido,
                    'id_norma' => $id_norma,
                    'quantidade' => $quantidade,
                    'valor_unitario' => $valor_unitario,
                    'valor_iva' => $valor_iva
                ]);
            }

            referencia::create([
                'id_pedido' => $pedido->id_pedido,
                'reference' => $referenciaData->reference ?? null,
                'status' => $referenciaData->status ?? 'pendente',
                'messageId' => $referenciaData->messageId ?? null,
                'entity' => $referenciaData->entity ?? null,
                'value' => $total_amout
            ]);

            DB::commit();
            return redirect()->route('loja')->with('success', 'Pedido criado com sucesso');
        }catch(\Exception $e){
            DB::rollBack();
            \Log::error('Pedido store error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Erro ao criar pedido');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    private function gerarReferenciaChamadaApi($amount){
              /*-------------------REFERENCE GENERATE---------------------*/
      $mytime = Carbon::now();
      $dateRef = Carbon::parse($mytime)->format('mYd');
      $timeRef = Carbon::parse($mytime)->format('his');
      $invertedTimeRef = Carbon::parse($mytime)->format('sih');
      $transaID = $invertedTimeRef.''.$dateRef.''.$timeRef;
      
      // Convert amount to cents (multiply by 100) - SMS2Q expects value in cents
      $amountInCents = intval($amount * 100);
      
      Log::info('Gerando referência para transação ID: '.$transaID.' com valor: '.$amount.' MT (cents: '.$amountInCents.')');
      
      // Validate minimum amount (e.g., minimum 1000 cents = 10 MT)
      if($amountInCents < 1000){
          Log::warning('Valor de pagamento abaixo do mínimo permitido: '.$amount.' MT');
          return (object)['error' => 'Valor mínimo de 10 MT não atingido', 'status' => 'Invalid'];
      }
      
      $client = new Client([
          'headers' => [
              'apikey' => '229YE2D9EkwO8ccCz9oao0Vr3LDQJFfp',
              'method' => 'POST',
              'content-type' => 'application/json',
              'Accept'      => 'application/json',
                      ],
          'verify' => false, // Disable SSL certificate verification globally
      ]);

      try {
          $response = $client->request('POST', 'https://sms2q.com/mobile/reference/request',[
              'json' =>[
                          'username' => 'QUID',
                          'transactionId' => $transaID,
                          'value' => $amountInCents,
                          'deadline'=> date('Ymd', strtotime($mytime." +48 hours"))

              ],
          ]);
          $datas = $response->getBody();
          $datas = json_decode($datas);
          
          Log::info('SMS2Q Response: '.json_encode($datas));
          
          // Check if API returned error
          if(isset($datas->status) && strtolower($datas->status) === 'invalid'){
              Log::warning('SMS2Q API retornou erro: '.($datas->errorMessage ?? 'Unknown error'));
              $datas->error = $datas->errorMessage ?? 'API retornou status inválido';
          }
          
          return $datas;
      } catch (\GuzzleHttp\Exception\RequestException $e) {
          \Log::error('SMS2Q API Error: ' . $e->getMessage());
          return (object)['error' => 'Erro ao conectar ao servidor de pagamento', 'status' => 'Error'];
      }
    }
}
