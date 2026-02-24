@extends('layouts.app')


@section('content')

<table id="pedidosTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Nome do Cliente</th>
            <th>ID Pedido</th>
            <th>Data do Pedido</th>
            <th>Valor Total</th>
            <th>Estado da ref.</th>
            <th>Referência</th>
            <th>estado do pedido</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pedidos as $pedido)
            <tr>
                <td>{{ $pedido->nome_completo_comprador }}</td>
                <td>{{ $pedido->num_pedido }}</td>
                <td>{{ $pedido->data_pedido }}</td>
                <td>R$ {{ number_format($pedido->referencia->value ?? 0, 2, ',', '.') }}</td>
                <td>{{ $pedido->referencia->status ?? 'N/A' }}</td>
                <td>{{ $pedido->referencia->reference ?? 'N/A' }}</td>
                <td>{{ $pedido->estado }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {
        $('#pedidosTable').DataTable();
    });
</script>


@endsection