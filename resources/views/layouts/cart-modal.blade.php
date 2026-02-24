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
