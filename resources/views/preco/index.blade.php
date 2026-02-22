@extends('layouts.app')

@section('content')

<script defer>
    document.addEventListener("DOMContentLoaded", function() {
        new DataTable('table');
})
</script>

<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Preços</h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#precoModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Novo Preço
            </button>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div id="example" class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Valor</th>
                    <th>Norma</th>
                    <th>Data Início</th>
                    <th>Data Fim</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($precos as $preco)
                    <tr>
                        <td>{{ $preco->id_preco }}</td>
                        <td>{{ number_format($preco->valor, 2, ',', '.') }}</td>
                        <td>{{ optional($preco->norma)->titulo ?? '—' }}</td>
                        <td>{{ optional($preco->data_inicio)->format('d/m/Y') ?? $preco->data_inicio }}</td>
                        <td>{{ optional($preco->data_fim)->format('d/m/Y') ?? ($preco->data_fim ?? '—') }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" onclick='editarPreco(@json($preco))'>
                                <i class="bi bi-pencil"></i> Editar
                            </button>

                            <form action="{{ route('precos.destroy', $preco->id_preco) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza que deseja eliminar este preço?')">
                                    <i class="bi bi-trash"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Nenhum preço registado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Preço -->
<div class="modal fade" id="precoModal" tabindex="-1" aria-labelledby="precoLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="precoLabel">Novo Preço</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="precoForm" method="POST" action="{{ route('precos.store') }}">
                @csrf
                <input type="hidden" id="precoId" name="id_preco">
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="valor" class="form-label">Valor</label>
                        <input type="number" step="0.01" class="form-control" id="valor" name="valor" required>
                        <small class="text-danger" id="valorError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="id_norma" class="form-label">Norma</label>
                        <select id="id_norma" name="id_norma" class="form-select" required>
                            <option value="">-- Selecionar Norma --</option>
                            @foreach($normas as $norma)
                                <option value="{{ $norma->id_norma }}">{{ $norma->titulo }} ({{ $norma->codigo }})</option>
                            @endforeach
                        </select>
                        <small class="text-danger" id="normaError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="data_inicio" class="form-label">Data Início</label>
                        <input type="date" class="form-control" id="data_inicio" name="data_inicio" required>
                        <small class="text-danger" id="dataInicioError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="data_fim" class="form-label">Data Fim (opcional)</label>
                        <input type="date" class="form-control" id="data_fim" name="data_fim">
                        <small class="text-danger" id="dataFimError"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
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
