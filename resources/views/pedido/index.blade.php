@extends('layouts.app')

@section('content')

<div class="py-4">
    <div class="mb-5">
        <h1 class="mb-2">
            <i class="bi bi-receipt"></i> Gestão de Pedidos
        </h1>
        <p class="text-muted">Acompanhe todos os pedidos e suas transações</p>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="pedidosTable" class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4">Nome do Cliente</th>
                            <th class="border-0">ID Pedido</th>
                            <th class="border-0">Data do Pedido</th>
                            <th class="border-0">Valor Total</th>
                            <th class="border-0">Estado da Ref.</th>
                            <th class="border-0">Referência</th>
                            <th class="border-0 pe-4">Estado do Pedido</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pedidos as $pedido)
                            <tr>
                                <td class="ps-4">
                                    <strong>{{ $pedido->nome_completo_comprador }}</strong>
                                </td>
                                <td>
                                    <span class="badge bg-primary">{{ $pedido->num_pedido }}</span>
                                </td>
                                <td class="text-muted small">
                                    {{ $pedido->data_pedido }}
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($pedido->referencia->value ?? 0, 2, ',', '.') }} </strong>
                                </td>
                                <td>
                                    @php
                                        $status = $pedido->referencia->status ?? 'N/A';
                                        $statusClass = match($status) {
                                            'completed' => 'bg-success',
                                            'pending' => 'bg-warning',
                                            'failed' => 'bg-danger',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">{{ $status }}</span>
                                </td>
                                <td class="small text-muted">
                                    {{ $pedido->referencia->reference ?? 'N/A' }}
                                </td>
                                <td class="pe-4">
                                    @php
                                        $estado = $pedido->estado ?? 'pendente';
                                        $estadoClass = match($estado) {
                                            'concluído' => 'bg-success',
                                            'processando' => 'bg-info',
                                            'cancelado' => 'bg-danger',
                                            default => 'bg-warning'
                                        };
                                    @endphp
                                    <span class="badge {{ $estadoClass }}">{{ $estado }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p class="mt-3">Nenhum pedido registado</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        $('#pedidosTable').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Portuguese.json'
            }
        });
    });
</script>

@endsection