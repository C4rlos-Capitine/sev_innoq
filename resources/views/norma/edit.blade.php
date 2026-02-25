@extends('layouts.app')

@section('content')
<div class="py-5">
    <div class="row">
        <div class="col-lg-8 offset-lg-2">
            <div class="mb-4">
                <h1 class="mb-2">
                    <i class="bi bi-pencil-square"></i> Editar Norma
                </h1>
                <p class="text-muted">Atualize as informações da norma técnica</p>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0 text-white">
                        <i class="bi bi-file-text"></i> {{ $norma->titulo }}
                    </h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong><i class="bi bi-exclamation-triangle"></i> Erro de validação!</strong>
                            <ul class="mb-0 mt-2">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form action="{{ route('norma.update', $norma->id_norma) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="titulo" class="form-label">
                                <i class="bi bi-card-text"></i> Título <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('titulo') is-invalid @enderror" 
                                   id="titulo" 
                                   name="titulo" 
                                   value="{{ old('titulo', $norma->titulo) }}" 
                                   required>
                            @error('titulo')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="codigo" class="form-label">
                                <i class="bi bi-barcode"></i> Código <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   class="form-control @error('codigo') is-invalid @enderror" 
                                   id="codigo" 
                                   name="codigo" 
                                   value="{{ old('codigo', $norma->codigo) }}" 
                                   required>
                            @error('codigo')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="descricao" class="form-label">
                                <i class="bi bi-file-text"></i> Descrição <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control @error('descricao') is-invalid @enderror" 
                                      id="descricao" 
                                      name="descricao" 
                                      rows="6" 
                                      required
                                      style="resize: vertical;">{{ old('descricao', $norma->descricao) }}</textarea>
                            @error('descricao')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="documento" class="form-label">
                                <i class="bi bi-file-pdf"></i> Documento (PDF)
                            </label>
                            <input type="file" 
                                   class="form-control" 
                                   id="documento" 
                                   name="documento" 
                                   accept="application/pdf">
                            <small class="form-text text-muted d-block mt-2">
                                <i class="bi bi-info-circle"></i> Enviar novo ficheiro para substituir o anterior (opcional).
                            </small>
                        </div>

                        <div class="d-flex gap-3 mt-5">
                            <button type="submit" class="btn btn-primary btn-lg flex-grow-1">
                                <i class="bi bi-check-circle"></i> Guardar Alterações
                            </button>
                            <a href="{{ route('norma.index') }}" class="btn btn-outline-secondary btn-lg">
                                <i class="bi bi-x-circle"></i> Cancelar
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
