@extends('layouts.app')

@section('content')
<div class="py-5">

    <!-- Header -->
    <div class="mb-5">
        <h1 class="fw-semibold mb-2">
            <i class="bi bi-shop"></i> Loja de Normas
        </h1>
        <p class="text-muted mb-0">Consulte e adquira normas técnicas oficiais disponíveis</p>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-check-circle"></i>    {!! session('success') !!}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @elseif(session('error'))
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm" role="alert">
            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Grid de Produtos -->
    <div class="row g-4">
        @forelse ($normas as $norma)
            <div class="col-12 col-sm-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="card-body d-flex flex-column">
                        
                        <!-- Badge Código -->
                        <div class="mb-3">
                            <span class="badge bg-danger">{{ $norma['codigo'] }}</span>
                        </div>

                        <!-- Título -->
                        <h5 class="card-title text-dark mb-2">
                            <a href="/norma/{{ $norma['id_norma'] }}" class="text-decoration-none text-dark">
                                {{ Str::limit($norma['titulo'], 45) }}
                            </a>
                        </h5>

                        <!-- Descrição -->
                        <p class="text-muted small flex-grow-1" style="line-height: 1.5;">
                            {{ Str::limit($norma['descricao'], 90) }}
                        </p>

                        <!-- Separador -->
                        <hr class="my-3">

                        <!-- Preço -->
                        <div class="mb-4">
                            <h5 class="text-danger fw-bold mb-0">
                                {{ number_format($norma['precos'][0]['valor'] ?? 0, 2, ',', '.') }}
                            </h5>
                        </div>

                        <!-- Botões -->
                        <div class="d-flex gap-2 mt-auto">
                            <a href="/norma/{{ $norma['id_norma'] }}"
                               class="btn btn-outline-danger btn-sm flex-grow-1">
                                <i class="bi bi-eye"></i> Ver
                            </a>
                           @guest
                            <button type="button"
                                class="btn btn-danger btn-sm flex-grow-1"
                                onclick="addToCart({{ $norma['id_norma'] }}, '{{ addslashes($norma['titulo']) }}', {{ $norma['precos'][0]['valor'] ?? 0 }})">
                                <i class="bi bi-shopping-cart"></i> Adicionar
                            </button>
                           @endguest
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm">
                    <i class="bi bi-inbox"></i> Nenhuma norma disponível no momento.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection