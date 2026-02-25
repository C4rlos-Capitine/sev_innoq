@extends('layouts.app')

@section('content')
<div class="py-5">
    <div class="mb-5">
        <h1 class="mb-2">
            <i class="bi bi-shop"></i> Loja de Normas
        </h1>
        <p class="text-muted">Consulte e adquira normas técnicas oficiais</p>
    </div>

    <div class="row g-4">
        @forelse($normas as $norma)
            @php
                // preco atual (assume precos está ordered desc pela controller)
                $current = isset($norma->precos[0]) ? $norma->precos[0] : null;
                $previous = isset($norma->precos[1]) ? $norma->precos[1] : null;
                $currentVal = $current ? (float) $current->valor : null;
                $previousVal = $previous ? (float) $previous->valor : null;
                $percent = null;
                if ($currentVal && $previousVal && $previousVal > 0) {
                    $percent = round((($previousVal - $currentVal) / $previousVal) * 100);
                }
                // rating placeholder (0-5)
                $rating = 4;
            @endphp

            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-sm product-card">
                    <div class="card-body d-flex flex-column">
                        <!-- Header do Card -->
                        <div class="mb-3">
                            <span class="badge bg-primary mb-2">{{ $norma->codigo }}</span>
                            <h5 class="card-title text-dark">
                                <a href="/norma/{{ $norma->id_norma }}" class="text-dark text-decoration-none">
                                    {{ Str::limit($norma->titulo, 50) }}
                                </a>
                            </h5>
                        </div>

                        <!-- Descrição -->
                        <p class="text-muted small mb-3" style="line-height: 1.5;">
                            {{ Str::limit($norma->descricao, 80) }}
                        </p>

                        <!-- Rating -->
                        <div class="mb-3">
                            <ul class="list-unstyled d-flex gap-1 mb-0">
                                @for ($i=0;$i<$rating;$i++)
                                    <li><i class="bi bi-star-fill text-warning"></i></li>
                                @endfor
                                @for ($j=0; $j<5-$rating; $j++)
                                    <li><i class="bi bi-star text-muted"></i></li>
                                @endfor
                            </ul>
                        </div>

                        <!-- Preço -->
                        <div class="mb-4 border-top border-bottom py-3">
                            @if($previousVal)
                                <small class="text-muted text-decoration-line-through d-block mb-1">
                                    {{ number_format($previousVal, 2, ',', '.') }} 
                                </small>
                            @endif
                            <div class="d-flex align-items-baseline gap-2">
                                <h4 class="mb-0 text-primary fw-bold">
                                    @if($currentVal)
                                        {{ number_format($currentVal, 2, ',', '.') }}
                                    @else
                                        —
                                    @endif
                                </h4>
                                @if($percent)
                                    <span class="badge bg-danger">-{{ $percent }}%</span>
                                @endif
                            </div>
                        </div>

                        <!-- Botões -->
                        <div class="mt-auto d-flex gap-2">
                            <a href="/norma/{{ $norma->id_norma }}" class="btn btn-outline-primary flex-grow-1 btn-sm">
                                <i class="bi bi-eye"></i> Ver Detalhes
                            </a>
                            <a href="{{ route('documentos.download', ['nome_tabela' => 'norma', 'chave' => $norma->id_norma]) }}" class="btn btn-primary flex-grow-1 btn-sm">
                                <i class="bi bi-download"></i> Baixar
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info border-0 shadow-sm">
                    <i class="bi bi-inbox"></i> Nenhuma norma encontrada no momento.
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
