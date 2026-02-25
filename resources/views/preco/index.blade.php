@extends('layouts.app')

@section('content')

<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        new DataTable('table');
    })
</script>

<div class="py-4">
    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="mb-2">
                <i class="bi bi-tag"></i> Gestão de Preços
            </h1>
            <p class="text-muted">Gerencie os preços das normas técnicas</p>
        </div>
        <div class="col-lg-4 text-end">
            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#precoModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Novo Preço
            </button>
        </div>
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
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4">ID</th>
                            <th class="border-0">Valor</th>
                            <th class="border-0">Norma</th>
                            <th class="border-0">Data Início</th>
                            <th class="border-0">Data Fim</th>
                            <th class="border-0 pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($precos as $preco)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-secondary">{{ $preco->id_preco }}</span>
                                </td>
                                <td>
                                    <strong class="text-success">{{ number_format($preco->valor, 2, ',', '.') }} </strong>
                                </td>
                                <td>
                                    <small>{{ optional($preco->norma)->titulo ?? '—' }}</small>
                                </td>
                                <td class="text-muted small">
                                    {{ optional($preco->data_inicio)->format('d/m/Y') ?? $preco->data_inicio }}
                                </td>
                                <td class="text-muted small">
                                    {{ optional($preco->data_fim)->format('d/m/Y') ?? ($preco->data_fim ?? '—') }}
                                </td>
                                <td class="pe-4">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick='editarPreco(@json($preco))' title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('precos.destroy', $preco->id_preco) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Deletar" onclick="return confirm('Tem certeza que deseja eliminar este preço?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p class="mt-3">Nenhum preço registado</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Preço -->
<div class="modal fade" id="precoModal" tabindex="-1" aria-labelledby="precoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="precoLabel">
                    <i class="bi bi-tag-fill"></i> Novo Preço
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="precoForm" method="POST" action="{{ route('precos.store') }}">
                @csrf
                <input type="hidden" id="precoId" name="id_preco">
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" id="valor" name="valor" required placeholder="0.00">
                        <small class="text-danger" id="valorError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="id_norma" class="form-label">Norma <span class="text-danger">*</span></label>
                        <select id="id_norma" name="id_norma" class="form-select" required>
                            <option value="">-- Selecionar Norma --</option>
                            @foreach($normas as $norma)
                                <option value="{{ $norma->id_norma }}">{{ $norma->titulo }} ({{ $norma->codigo }})</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="normaError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="data_inicio" class="form-label">Data Início <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                        <small class="text-danger" id="dataInicioError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="data_fim" class="form-label">Data Fim (opcional)</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim">
                        <small class="text-danger" id="dataFimError"></small>
                    </div>
                </div>

                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check-circle"></i> Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>


    function resetForm() {
        document.getElementById('precoForm').reset();
        document.getElementById('precoId').value = '';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('precoForm').action = "{{ route('precos.store') }}";
        document.getElementById('precoLabel').textContent = 'Novo Preço';
        clearErrors();
    }

    function editarPreco(preco) {
        clearErrors();
        document.getElementById('valor').value = preco.valor;
        document.getElementById('id_norma').value = preco.id_norma;
        document.getElementById('data_inicio').value = preco.data_inicio ? preco.data_inicio.split(' ')[0] : preco.data_inicio;
        document.getElementById('data_fim').value = preco.data_fim ? preco.data_fim.split(' ')[0] : preco.data_fim;
        document.getElementById('precoId').value = preco.id_preco;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('precoForm').action = `/preco/${preco.id_preco}`;
        document.getElementById('precoLabel').textContent = 'Editar Preço';

        const modal = new bootstrap.Modal(document.getElementById('precoModal'));
        modal.show();
    }

    function clearErrors() {
        document.getElementById('valorError').textContent = '';
        document.getElementById('normaError').textContent = '';
        document.getElementById('dataInicioError').textContent = '';
        document.getElementById('dataFimError').textContent = '';
    }
</script>
@endsection
