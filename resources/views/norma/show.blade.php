@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-dark text-white">
                    <h5 class="mb-0"><i class="bi bi-file-text"></i> Detalhes da Norma</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Código:</label>
                        <p class="form-control-plaintext"><span class="badge bg-info">{{ $norma->codigo }}</span></p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título:</label>
                        <p class="form-control-plaintext">{{ $norma->titulo }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descrição:</label>
                        <p class="form-control-plaintext">{{ $norma->descricao }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Criado em:</label>
                        <p class="form-control-plaintext">{{ $norma->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-bold">Atualizado em:</label>
                        <p class="form-control-plaintext">{{ $norma->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
                <div class="card-footer">
                    <a href="{{ route('norma.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Voltar
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
