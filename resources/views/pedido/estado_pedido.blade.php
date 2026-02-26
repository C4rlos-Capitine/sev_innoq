@extends('layouts.app')

@section('content')

        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title"><strong>Pedido:</strong> {{ $pedido['num_pedido'] }}</h5>
                <p><strong>Data:</strong> {{ $pedido['data_pedido'] }}</p>
                <p><strong>Estado:</strong> {{ ucfirst($pedido['estado']) }}</p>
                <p><strong>Comprador:</strong> {{ $pedido['nome_completo_comprador'] }}</p>
                <p><strong>Email:</strong> {{ $pedido['email_comprador'] }}</p>
                <p><strong>Telefone:</strong> {{ $pedido['telefone_comprador'] }}</p>
          
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ route('pedido.pdf', ['id' => $pedido['id_pedido']]) }}" 
               class="btn btn-outline-secondary" 
               target="_blank">
                <i class="bi bi-file-earmark-pdf"></i> Ver Fatura em PDF
            </a>
        </div>

@endsection