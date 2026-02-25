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

<div class="py-4">
    <div class="row mb-5">
        <div class="col-lg-8">
            <h1 class="mb-2">
                <i class="bi bi-file-text"></i> Gestão de Normas
            </h1>
            <p class="text-muted">Gerencie todas as normas institucionais e documentos técnicos</p>
        </div>
        <div class="col-lg-4 text-end">
            <button class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#normaModal" onclick="resetForm()">
                <i class="bi bi-plus-circle"></i> Nova Norma
            </button>
        </div>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong><i class="bi bi-exclamation-circle"></i> Erro de validação!</strong>
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
            <i class="bi bi-check-circle"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="example" class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="border-0 ps-4">Código</th>
                            <th class="border-0">Título</th>
                            <th class="border-0">Descrição</th>
                            <th class="border-0">Data Criação</th>
                            <th class="border-0 pe-4">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($normas as $norma)
                            <tr>
                                <td class="ps-4">
                                    <span class="badge bg-primary">{{ $norma->codigo }}</span>
                                </td>
                                <td>
                                    <strong class="text-dark">{{ $norma->titulo }}</strong>
                                </td>
                                <td>
                                    <small class="text-muted">{{ Str::limit($norma->descricao, 60) }}</small>
                                </td>
                                <td class="text-muted small">
                                    {{ $norma->created_at->format('d/m/Y H:i') }}
                                </td>
                                <td class="pe-4">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-sm btn-outline-primary" onclick='detalhesNorma(@json($norma))' title="Ver detalhes">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                        <a href="{{ route('documentos.download', ['nome_tabela' => 'norma', 'chave' => $norma->id_norma]) }}" class="btn btn-sm btn-outline-info" title="Baixar documento">
                                            <i class="bi bi-download"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-outline-warning" onclick='editarNorma(@json($norma))' title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <form action="{{ route('norma.destroy', $norma->id_norma) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Deletar" onclick="return confirm('Tem certeza que deseja eliminar esta norma?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox" style="font-size: 2rem; opacity: 0.5;"></i>
                                    <p class="mt-3">Nenhuma norma registada</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nova/Editar Norma -->
<div class="modal fade" id="normaModal" tabindex="-1" aria-labelledby="normaLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="normaLabel">
                    <i class="bi bi-file-earmark-plus"></i> Nova Norma
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="normaForm" method="POST" action="{{ route('norma.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="normaId" name="id_norma">
                <input type="hidden" id="formMethod" name="_method" value="POST">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="titulo" class="form-label">Título <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="titulo" name="titulo" required>
                        <small class="text-danger" id="tituloError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="codigo" class="form-label">Código <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="codigo" name="codigo" required>
                        <small class="text-danger" id="codigoError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="descricao" class="form-label">Descrição <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="4" required style="resize: none;"></textarea>
                        <small class="text-danger" id="descricaoError"></small>
                    </div>

                    <div class="mb-3">
                        <label for="documento" class="form-label">Documento (PDF)</label>
                        <input type="file" class="form-control" id="documento" name="documento" accept="application/pdf">
                        <small class="form-text text-muted d-block mt-2"><i class="bi bi-info-circle"></i> Opcional. Apenas PDF, máximo 10MB.</small>
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

<!-- Modal Detalhes Norma -->
<div class="modal fade" id="detalhesModal" tabindex="-1" aria-labelledby="detalhesLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-white" id="detalhesLabel">
                    <i class="bi bi-file-text"></i> Detalhes da Norma
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-4">
                    <div class="col-md-8">
                        <h4 id="detalhesTitulo" class="text-dark mb-2"></h4>
                        <p><strong>Código:</strong> <span id="detalhesCodigo" class="badge bg-primary"></span></p>
                    </div>
                    <div class="col-md-4 text-end">
                        <h6 class="text-uppercase text-muted small">Preço Atual</h6>
                        <p id="detalhesPreco" class="fs-4 fw-bold text-primary">—</p>
                    </div>
                </div>

                <hr>

                <h6 class="text-uppercase text-muted small mb-3">Descrição</h6>
                <p id="detalhesDescricao" class="text-secondary" style="line-height: 1.6;"></p>

                <hr>

                <h6 class="text-uppercase text-muted small mb-3">Documentos</h6>
                <div class="list-group" id="detalhesDocumentos">
                    <div class="list-group-item text-muted text-center py-3">
                        <i class="bi bi-inbox"></i> Sem documentos
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-light">
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
