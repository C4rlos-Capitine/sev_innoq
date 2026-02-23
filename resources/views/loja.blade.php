@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <h1>Loja</h1>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

<div class="row products responsive-md-class responsive-xl-class responsive-lg-class">
    <div class="row mb-4">
        @foreach ($normas as $norma)
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">
                <div class="card" id="{{ $norma['codigo'] }}">
                    <div class="card-body">
                        <h5 class="card-title">{{ $norma['titulo'] }}</h5>
                        <h6 class="card-subtitle mb-2 text-muted">{{ $norma['codigo'] }}</h6>
                        <p class="card-text">{{ substr($norma['descricao'], 0, 100) }}...</p>   
                        <div class="pricing-meta">
                            <span class="badge badge-primary">{{ number_format($norma['precos'][0]['valor'], 2, ',', ' ') }} MT</span>
                        </div>
                        <a href="/norma/{{ $norma['id_norma'] }}" class="btn btn-primary mt-2"><i class="fas fa-eye"></i></a>
                        <button class="btn btn-success mt-2" onclick="addToCart({{ $norma['id_norma'] }})"><i class="fas fa-shopping-cart"></i></button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    </div>

@endsection

        @section('scripts')
        <script>
                const normas = @json($normasJs);

                const provincias = @json($provincias ?? []);

                let cart = [];

                function addToCart(id_norma){
                        const norma = normas.find(n => n.id === id_norma);
                        if(!norma) return alert('Produto não encontrado');
                        const existing = cart.find(i => i.id_norma === id_norma);
                        if(existing){ existing.quantidade += 1; }
                        else{ cart.push({ id_norma: norma.id, titulo: norma.titulo, valor_unitario: Number(norma.valor), quantidade: 1, valor_iva: 0 }); }
                        showCartModal();
                }

                function showCartModal(){
                        renderCartItems();
                        const modal = new bootstrap.Modal(document.getElementById('cartModal'));
                        modal.show();
                }

                function renderCartItems(){
                        const tbody = document.getElementById('cart-items');
                        tbody.innerHTML = '';
                        let total = 0;
                        cart.forEach((it, idx) => {
                                const lineTotal = (it.valor_unitario * it.quantidade) + (it.valor_iva || 0);
                                total += lineTotal;
                                const tr = document.createElement('tr');
                                tr.innerHTML = `
                                        <td>${it.titulo}</td>
                                        <td><input type="number" min="1" value="${it.quantidade}" onchange="updateQty(${idx}, this.value)" class="form-control form-control-sm" /></td>
                                        <td>${Number(it.valor_unitario).toFixed(2)}</td>
                                        <td>${Number(it.valor_iva||0).toFixed(2)}</td>
                                        <td>${lineTotal.toFixed(2)}</td>
                                        <td><button class="btn btn-sm btn-danger" onclick="removeItem(${idx})">Remover</button></td>
                                `;
                                tbody.appendChild(tr);
                        });
                        document.getElementById('cart-total').textContent = total.toFixed(2);
                        document.getElementById('cart-items-json').value = JSON.stringify(cart);
                }

                function updateQty(idx, value){ cart[idx].quantidade = parseInt(value) || 1; renderCartItems(); }
                function removeItem(idx){ cart.splice(idx,1); renderCartItems(); }

                // submit form
                function submitCartForm(e){
                        if(cart.length === 0){ e.preventDefault(); alert('O carrinho está vazio.'); return false; }
                        // form will submit normally with cart JSON in hidden input
                        return true;
                }

                document.addEventListener('DOMContentLoaded', function(){
                        const provinciasSelect = document.getElementById('provincia_select');
                        if(provinciasSelect && provincias.length){
                                provincias.forEach(p => {
                                        const opt = document.createElement('option'); opt.value = p.id_provincia; opt.text = p.nome_provincia; provinciasSelect.appendChild(opt);
                                });
                        }
                });
        </script>

        <!-- Cart Modal -->
        <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form method="POST" action="{{ route('pedidos.store') }}" onsubmit="return submitCartForm(event)">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartLabel">Carrinho de Compras</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                        </div>
                        <div class="modal-body">
                            <table class="table">
                                <thead>
                                    <tr><th>Produto</th><th>Qtd</th><th>Unit.</th><th>IVA</th><th>Total</th><th></th></tr>
                                </thead>
                                <tbody id="cart-items"></tbody>
                            </table>
                            <div class="d-flex justify-content-end mb-3">Total: <strong class="ms-2">MT <span id="cart-total">0.00</span></strong></div>

                            <h5>Dados do Comprador</h5>
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <label class="form-label">Tipo</label>
                                    <select name="tipo_comprador" class="form-control">
                                        <option value="individual">Individual</option>
                                        <option value="empresa">Empresa</option>
                                    </select>
                                </div>
                                <div class="col-md-8">
                                    <label class="form-label">Nome completo</label>
                                    <input name="nome_completo_comprador" class="form-control" required />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Email</label>
                                    <input name="email_comprador" type="email" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Telefone</label>
                                    <input name="telefone_comprador" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">NUIT</label>
                                    <input name="nuit_comprador" class="form-control" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Provincia</label>
                                    <select id="provincia_select" name="id_provincia" class="form-control">
                                        <option value="">-- Selecionar --</option>
                                        @foreach($provincias as $provincia)
                                            <option value="{{ $provincia->id_provincia }}">{{ $provincia->nome_provincia }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Endereço</label>
                                    <input name="endereco_comprador" class="form-control" />
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <input type="hidden" name="items" id="cart-items-json" />
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            <button type="submit" class="btn btn-primary">Confirmar Pedido</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @endsection
