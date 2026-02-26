<html lang="pt">
<head>
 <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 12px;
        color: #333;
        margin: 20px;
    }

    .container {
        width: 100%;
    }

    .section {
        margin-bottom: 3px;
    }

    .section-title {
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 10px;
        border-bottom: 2px solid #b31b00;
        padding-bottom: 5px;
        color: #b33600;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 10px;
    }

    th, td {
        padding: 8px;
        border: 1px solid #ddd;
    }

    th {
        background-color: #f2f2f2;
        font-weight: bold;
        text-align: left;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    .totals {
        margin-top: 20px;
        width: 100%;
    }

    .totals-table {
        width: 50%;
        float: right;
        border-collapse: collapse;
    }

    .totals-table td {
        padding: 6px 10px;
    }

    .totals-table .label {
        font-weight: bold;
        text-align: right;
        width: 70%;
    }

    .totals-table .value {
        text-align: right;
        width: 30%;
    }

    .totals-table .total-row {
        background-color: #b31b00;
        color: white;
        font-weight: bold;
    }

    .reference-section {
       margin-top: 30px;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .reference-section strong {
        display: block;
        margin-bottom: 8px;
        font-size: 13px;
        color: #b32100;
    }

    .reference-section p {
        margin: 4px 0;
    }

    .reference-section span {
        font-size: 11px;
        font-weight: bold;
    }
    .totals{
        margin-top: 5px;
        width: 100%;
        padding-bottom: 70px;
    }
    header{
        text-align: center;
        margin-top: 0;
    }

    footer {
        position: fixed;
        bottom: 0;
        text-align: center;
        font-size: 11px;
        color: #666;
    }
</style>

</head>
<body>
    <header>
 @php
        $imagePath = public_path('/assets/images/Q_icon.png');
        $imageData = base64_encode(file_get_contents($imagePath));
        $imageSrc = 'data:image/png;base64,' . $imageData;

             
                
            @endphp
            <img id="header-img" src="{{ $imageSrc }}" width="80px" height="80px" alt="Image">
            <h1>Instituto Nacional de Normalização e Qualidade</h1>
            <h2>Delegação Provincial de Maputo</h2>
             <h3>Factura n: {{$pedido->codigo_pedido}}</h3>

    </header>

    @php
        // Normaliza itens, referência e subtotal caso não sejam passados individualmente
        $itens = isset($itens) ? collect($itens) : collect(data_get($pedido, 'itens', []));
        $referencia = $referencia ?? data_get($pedido, 'referencia', null);
        $subtotal = $subtotal ?? $itens->reduce(function ($carry, $item) {
            $valor = (float) data_get($item, 'valor_unitario', data_get($item, 'valor', 0));
            $quant = (int) data_get($item, 'quantidade', 1);
            return $carry + ($valor * $quant);
        }, 0);
    @endphp

    <div class="container">
       <p><strong>Nome do Cliente: </strong>{{ $pedido->nome_completo_comprador }}</p>
        <p><strong>Data do Pedido: </strong>{{ \Carbon\Carbon::parse($pedido->created_at)->format('d/m/Y') }}</p>
        <p><strong>Contato:</strong> {{ $pedido->contacto_comprador }}</p>
        <p><strong>Email:</strong> {{ $pedido->email_comprador }}</p>
        <div class="section">
            <div class="section-title">Itens do Pedido</div>
            <div class="section-content">
                <table>
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th class="text-center">Quantidade</th>
                            <th class="text-right">Valor Unitário</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($itens as $item)
                            <tr>
                                <td>
                                    <strong>{{ data_get($item, 'norma.titulo') ?? data_get($item, 'titulo') ?? 'N/A' }}</strong>
                                    <br>
                                    <small style="color: #999;">Código: {{ data_get($item, 'norma.codigo') ?? data_get($item, 'codigo') ?? '—' }}</small>
                                </td>
                                <td class="text-center">{{ data_get($item, 'quantidade', 1) }}</td>
                                <td class="text-right">{{ number_format((float) data_get($item, 'valor_unitario', data_get($item, 'valor', 0)), 2, ',', '.') }} MT</td>
                                <td class="text-right">
                                    <strong>{{ number_format((float) data_get($item, 'valor_unitario', data_get($item, 'valor', 0)) * (int) data_get($item, 'quantidade', 1), 2, ',', '.') }} MT</strong>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center" style="padding: 20px;">Nenhum item registado</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Totals -->
        <div class="totals">
            <table class="totals-table">
                <tr>
                    <td class="label">Subtotal:</td>
                    <td class="value">{{ number_format($subtotal, 2, ',', '.') }} MT</td>
                </tr>
                <tr>
                    <td class="label">IVA (0%):</td>
                    <td class="value">0,00 MT</td>
                </tr>
                <tr class="total-row">
                    <td class="label">VALOR TOTAL:</td>
                    <td class="value">{{ number_format($subtotal, 2, ',', '.') }} MT</td>
                </tr>
            </table>
        </div>

        <!-- Reference Information -->
        @if($referencia)
            <div class="reference-section">
                <strong>Informação de Pagamento</strong>
                <p><strong>Entidade:</strong> {{ data_get($referencia, 'entity') ?? data_get($referencia, 'entidade') }}</p>
                <p><strong>Referência:</strong> {{ data_get($referencia, 'reference') ?? data_get($referencia, 'reference') }}</p>
                <p><strong>Estado da Referência:</strong>
                    <span style="background-color: #0056b3; color: white; padding: 2px 8px; border-radius: 3px;">
                        {{ ucfirst(strtolower(data_get($referencia, 'status', ''))) }}
                    </span>
                </p>
                <p><strong>Valor a Pagar:</strong> {{ number_format((float) data_get($referencia, 'value', data_get($referencia, 'valor', 0)), 2, ',', '.') }} MT</p>
                <p style="margin-top: 8px; font-size: 11px; color: #666;">
                    <em>Utilize a referência acima para efetuar o pagamento. O pedido será confirmado após a validação do pagamento.</em>
                </p>
            </div>
        @endif

    </div>
    <footer>
        Avenida de Moçambique, nº 123, Maputo - Moçambique | Telefone: +258 21 123456 | Email:info.innoq@innoq.gov.mz | Site: www.innoq.gov.mz
    </footer>
</body>
</html>