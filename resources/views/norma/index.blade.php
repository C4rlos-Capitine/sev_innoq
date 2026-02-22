@extends('layouts.app')

@section('content')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        try {
            if (typeof DataTable !== 'undefined') {
                new DataTable('#example');
            }
        } catch (e) {
            console.warn('DataTable init failed:', e);
        }
    });
</script>
<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Gestão de Normas</h2>
        </div>
        <div class="col-md-6 text-end">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#normaModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Nova Norma
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Erro!</strong>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="table-responsive">
        <table id="example" class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Data Criação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($normas as $norma)
                    <tr>
                        <td>
                            <span class="badge bg-info">{{ $norma->codigo }}</span>
                        </td>
                        <td>
                            <strong>{{ $norma->titulo }}</strong>
                        </td>
                        <td>
                            {{ Str::limit($norma->descricao, 50) }}
                        </td>
                        <td>
                            {{ $norma->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td>
                            <button class="btn btn-sm btn-secondary" onclick='detalhesNorma(@json($norma))'>
                                <i class="bi bi-eye"></i> Detalhes
                            </button>

                            <a href="{{ route('documentos.download', ['nome_tabela' => 'norma', 'chave' => $norma->id_norma]) }}" class="btn btn-sm btn-info" title="Baixar último documento">
                                <i class="bi bi-download"></i> Baixar
                            </a>

                            <button class="btn btn-sm btn-warning" onclick='editarNorma(@json($norma))'>
                                <i class="bi bi-pencil"></i> Editar
                            </button>
                            <form action="{{ route('norma.destroy', $norma->id_norma) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tem certeza?')">
                                    <i class="bi bi-trash"></i> Deletar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Nenhuma norma registada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="normaModal" tabindex="-1" aria-labelledby="normaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="normaLabel">Nova Norma</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="normaForm" method="POST" action="{{ route('norma.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="normaId" name="id_norma">
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título</label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                        <small class="text-danger" id="tituloError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código</label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                        <small class="text-danger" id="codigoError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3" required></textarea>
                        <small class="text-danger" id="descricaoError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="documento" class="form-label">Documento (PDF)</label>
                        <input type="file" class="form-control" id="documento" name="documento" accept="application/pdf">
                        <small class="form-text text-muted">Opcional. Apenas PDF, até 10MB.</small>
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

        <!-- Detalhes Modal -->
        <div class="modal fade" id="detalhesModal" tabindex="-1" aria-labelledby="detalhesLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="detalhesLabel">Detalhes da Norma</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5 id="detalhesTitulo"></h5>
                                <p><strong>Código:</strong> <span id="detalhesCodigo"></span></p>
                                <p id="detalhesDescricao"></p>
                            </div>
                            <div class="col-md-4">
                                <h6>Preço atual</h6>
                                <p id="detalhesPreco" class="fs-4 fw-bold">—</p>
                            </div>
                        </div>

                        <hr>
                        <h6>Histórico de Documentos</h6>
                        <ul class="list-group" id="detalhesDocumentos">
                            <li class="list-group-item text-muted">Sem documentos</li>
                        </ul>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>

<script>
    function resetForm() {
        document.getElementById('normaForm').reset();
        document.getElementById('normaId').value = '';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('normaForm').action = "{{ route('norma.store') }}";
        document.getElementById('normaLabel').textContent = 'Nova Norma';
        clearErrors();
    }

    function editarNorma(norma) {
        clearErrors();
        document.getElementById('titulo').value = norma.titulo;
        document.getElementById('codigo').value = norma.codigo;
        document.getElementById('descricao').value = norma.descricao;
        document.getElementById('normaId').value = norma.id_norma;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('normaForm').action = `/norma/${norma.id_norma}`;
        document.getElementById('normaLabel').textContent = 'Editar Norma';
        
        const modal = new bootstrap.Modal(document.getElementById('normaModal'));
        modal.show();
    }

    function detalhesNorma(norma) {
        document.getElementById('detalhesTitulo').textContent = norma.titulo;
        document.getElementById('detalhesCodigo').textContent = norma.codigo;
        document.getElementById('detalhesDescricao').textContent = norma.descricao;

        // Preco atual (first preco from relation)
        let precoText = '—';
        if (norma.precos && norma.precos.length > 0) {
            const p = norma.precos[0];
            precoText = parseFloat(p.valor).toFixed(2).replace('.', ',') + ' ';
        }
        document.getElementById('detalhesPreco').textContent = precoText;

        // Documentos history
        const list = document.getElementById('detalhesDocumentos');
        list.innerHTML = '';
        if (norma.documentos && norma.documentos.length > 0) {
            norma.documentos.forEach(function(doc) {
                const li = document.createElement('li');
                li.className = 'list-group-item d-flex justify-content-between align-items-center';
                const name = doc.path.split('/').pop();
                li.innerHTML = `<span>${name} <small class="text-muted">(${new Date(doc.created_at).toLocaleString()})</small></span>`;
                const a = document.createElement('a');
                a.className = 'btn btn-sm btn-outline-primary';
                a.href = `/documentos/download/id/${doc.id_documento}`;
                a.textContent = 'Baixar';
                li.appendChild(a);
                list.appendChild(li);
            });
        } else {
            const li = document.createElement('li');
            li.className = 'list-group-item text-muted';
            li.textContent = 'Sem documentos';
            list.appendChild(li);
        }

        const modal = new bootstrap.Modal(document.getElementById('detalhesModal'));
        modal.show();
    }

    function clearErrors() {
        document.getElementById('tituloError').textContent = '';
        document.getElementById('codigoError').textContent = '';
        document.getElementById('descricaoError').textContent = '';
    }
</script>
@endsection
