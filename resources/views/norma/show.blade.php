@extends('layouts.app')

@section('content')
<div class="py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-4">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('norma.index') }}" class="text-decoration-none">Normas</a></li>
                    <li class="breadcrumb-item active">{{ $norma->titulo }}</li>
                </ol>
            </nav>

            <div class="card border-0 shadow-sm norma-card">

                <!-- Header -->
                <div class="card-body pb-0">

                    <div class="d-flex justify-content-between align-items-start mb-4">
                        <div>
                            <span class="badge bg-primary mb-2 px-3 py-2">
                                {{ $norma->codigo }}
                            </span>

                            <h1 class="fw-semibold mb-2">
                                {{ $norma->titulo }}
                            </h1>

                            <p class="text-muted mb-0">
                                <i class="bi bi-file-text"></i> Documento técnico normativo
                            </p>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Descrição -->
                    <div class="mb-4">
                        <h6 class="text-uppercase text-muted small mb-3">
                            <i class="bi bi-chat-left-text"></i> Descrição
                        </h6>
                        <p class="mb-0 text-secondary" style="line-height: 1.7;">
                            {{ $norma->descricao }}
                        </p>
                    </div>

                    <hr class="my-4">

                    <!-- Metadados -->
                    <div class="row text-muted small mb-4">
                        <div class="col-md-6 mb-3">
                            <strong>
                                <i class="bi bi-calendar-event"></i> Criado em:
                            </strong><br>
                            <span class="text-dark">{{ $norma->created_at->format('d/m/Y \à\s H:i') }}</span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <strong>
                                <i class="bi bi-arrow-counterclockwise"></i> Atualizado em:
                            </strong><br>
                            <span class="text-dark">{{ $norma->updated_at->format('d/m/Y \à\s H:i') }}</span>
                        </div>
                    </div>

                </div>

                <!-- Footer -->
                <div class="card-footer bg-light border-0 pt-4 pb-4">

                    <div class="d-flex justify-content-between align-items-center gap-3">

                        <a href="{{ route('norma.index') }}"
                           class="btn btn-outline-secondary px-4">
                            <i class="bi bi-arrow-left"></i> Voltar
                        </a>

                        <button class="btn btn-primary px-4"
                            onclick="addToCart({{ $norma->id }}, '{{ addslashes($norma->titulo) }}', 0)">
                            <i class="bi bi-shopping-cart"></i>
                            Adicionar ao Carrinho
                        </button>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>
@endsection