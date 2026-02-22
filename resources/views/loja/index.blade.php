@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="row">
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

            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column align-items-center text-center">
                        <div class="product-decs w-100">
                            <a class="inner-link" style="text-align: center" href="/norma/{{ $norma->id_norma }}"><span>{{ $norma->titulo }}</span></a>
                            <h2><a href="/search/{{ $norma->codigo }}" class="product-link" style="text-align: center">{{ $norma->codigo }}</a></h2>
                            <h2><a href="/norma/{{ $norma->id_norma }}" class="product-link" style="text-align: center">Ver detalhes</a></h2>

                            <div class="rating-product d-flex justify-content-center mb-2">
                                <ul class="list-unstyled d-flex gap-1 mb-0">
                                    @for ($i=0;$i<$rating;$i++)
                                        <li><i class="ion-android-star text-warning"></i></li>
                                    @endfor
                                    @for ($j=0; $j<5-$rating; $j++)
                                        <li><i class="ion-android-star-outline text-muted"></i></li>
                                    @endfor
                                </ul>
                            </div>

                            <div class="pricing-meta">
                                <ul class="list-unstyled d-flex flex-column align-items-center">
                                    @if($previousVal)
                                        <li class="old-price text-muted">{{ number_format($previousVal, 2, ',', ' ') }} MT</li>
                                    @endif
                                    @if($currentVal)
                                        <li class="current-price fs-4 fw-bold">{{ number_format($currentVal, 2, ',', ' ') }} MT</li>
                                    @else
                                        <li class="current-price fs-4 fw-bold">—</li>
                                    @endif
                                    @if($percent)
                                        <li class="discount-price text-danger">-{{ $percent }}%</li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="mt-auto w-100 d-flex justify-content-center gap-2">
                            <a href="/norma/{{ $norma->id_norma }}" class="btn btn-outline-primary btn-sm">Ver</a>
                            <a href="{{ route('documentos.download', ['nome_tabela' => 'norma', 'chave' => $norma->id_norma]) }}" class="btn btn-primary btn-sm">Baixar Documento</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info">Nenhuma norma encontrada.</div>
            </div>
        @endforelse
    </div>
</div>
@endsection
