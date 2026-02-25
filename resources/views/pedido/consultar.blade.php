@extends('layouts.app')

@section('content')

<form method="GET" 
      action="{{ route('pedidos.consultar') }}" 
      class="mx-auto mt-5 p-4 bg-white rounded shadow-sm"
      style="max-width: 400px;">

    <h2 class="mb-4 text-center">Consultar Pedido</h2>

    <div class="mb-3">
        <label for="codigo_pedido" class="form-label">Código do Pedido</label>
        <input type="text" 
               class="form-control" 
               id="codigo_pedido" 
               name="codigo_pedido" 
               placeholder="Digite o código do pedido" 
               required>
    </div>

    <button type="submit" class="btn btn-primary w-100">Consultar</button>

</form>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm mt-4" role="alert">
        <i class="bi bi-check-circle"></i> {!! session('success') !!}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    @php
        $pedido = session('pedido'); // guardado no controller com ->with('pedido', $pedido)
    @endphp

    @if($pedido)
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Pedido {{ $pedido['num_pedido'] }}</h5>
                <p><strong>Data:</strong> {{ $pedido['data_pedido'] }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($pedido['estado']) }}</p>
                <p><strong>Comprador:</strong> {{ $pedido['nome_completo_comprador'] }}</p>
                <p><strong>Email:</strong> {{ $pedido['email_comprador'] }}</p>
                <p><strong>Telefone:</strong> {{ $pedido['telefone_comprador'] }}</p>
                <p><strong>Valor:</strong> {{ $pedido['referencia']['value'] }} MT</p>
                <p><strong>Referência:</strong> {{ $pedido['referencia']['reference'] }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('pedido.pdf', ['id' => $pedido['id_pedido']]) }}" 
               class="btn btn-outline-secondary" 
               target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Ver Fatura em PDF
            </a>
        </div>
    @endif
@elseif(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mt-4" role="alert">
        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@endsection