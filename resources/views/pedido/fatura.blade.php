<html lang="pt">
<head>
    ...existing code...
</head>
<body>
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
        <!-- Header -->
        ...existing code...

        <!-- Buyer Information -->
        ...existing code...

        <!-- Items Table -->
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

        <!-- Footer -->
        ...existing code...
    </div>
</body>
</html>