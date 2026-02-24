# 📚 EXEMPLOS DE IMPLEMENTAÇÃO - SISTEMA DE CARRINHO

## 1. Adicionar Carrinho na Página de Detalhe do Produto

### Exemplo em `resources/views/norma/show.blade.php`:

```php
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <h1>{{ $norma->titulo }}</h1>
            <p>{{ $norma->descricao }}</p>
            
            <div class="card">
                <div class="card-body">
                    <h5>Preço: 
                        <span class="text-success">
                            {{ number_format($norma->precos[0]->valor ?? 0, 2, ',', ' ') }} MT
                        </span>
                    </h5>
                    
                    <!-- Input de quantidade -->
                    <div class="input-group" style="max-width: 150px;">
                        <span class="input-group-text">Quantidade:</span>
                        <input type="number" id="quantidade" 
                               class="form-control" value="1" min="1">
                    </div>
                    
                    <!-- Botão para adicionar ao carrinho -->
                    <button type="button" 
                            class="btn btn-success btn-lg mt-3"
                            onclick="adicionarAoCarrinho()">
                        <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function adicionarAoCarrinho() {
        const quantidade = parseInt(document.getElementById('quantidade').value) || 1;
        
        // Adiciona ao carrinho
        addToCart(
            {{ $norma->id_norma }},
            '{{ addslashes($norma->titulo) }}',
            {{ $norma->precos[0]->valor ?? 0 }}
        );
        
        // Opcional: mostrar mensagem
        alert(`${quantidade} unidade(s) adicionada(s) ao carrinho!`);
    }
</script>
@endsection
```

---

## 2. Adicionar Carrinho em uma Lista de Produtos Customizada

### Exemplo em `resources/views/produtos/lista.blade.php`:

```php
@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Catálogo de Produtos</h2>
    
    <div class="row">
        @foreach($produtos as $produto)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ $produto->imagem }}" class="card-img-top" alt="{{ $produto->titulo }}">
                    
                    <div class="card-body">
                        <h5 class="card-title">{{ $produto->titulo }}</h5>
                        <p class="card-text">{{ Str::limit($produto->descricao, 100) }}</p>
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="badge bg-primary">
                                {{ number_format($produto->valor, 2) }} MT
                            </span>
                            
                            <button class="btn btn-sm btn-success"
                                    onclick="adicionarProduto({{ $produto->id }}, '{{ addslashes($produto->titulo) }}', {{ $produto->valor }})">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    function adicionarProduto(id, titulo, valor) {
        addToCart(id, titulo, valor);
        
        // Feedback visual
        const btn = event.target.closest('button');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-check"></i> Adicionado';
        
        setTimeout(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fas fa-plus"></i>';
        }, 1500);
    }
</script>

@endsection
```

---

## 3. Adicionar Carrinho com Quantidade e Validação

### Exemplo com Formulário:

```php
<form id="addToCartForm" onsubmit="return adicionarComValidacao(event)">
    <div class="row g-3">
        <div class="col-md-8">
            <select class="form-control" id="produtoSelect" required>
                <option value="">-- Selecione um produto --</option>
                @foreach($normas as $norma)
                    <option value="{{ $norma->id_norma }}" 
                            data-titulo="{{ $norma->titulo }}"
                            data-valor="{{ $norma->precos[0]->valor ?? 0 }}">
                        {{ $norma->titulo }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="col-md-4">
            <input type="number" id="quantidade" 
                   class="form-control" 
                   value="1" min="1" max="100" 
                   placeholder="Quantidade" required>
        </div>
    </div>
    
    <button type="submit" class="btn btn-success mt-3">
        <i class="fas fa-shopping-cart"></i> Adicionar ao Carrinho
    </button>
</form>

<script>
    function adicionarComValidacao(event) {
        event.preventDefault();
        
        const select = document.getElementById('produtoSelect');
        const option = select.options[select.selectedIndex];
        
        if (!option.value) {
            alert('Selecione um produto!');
            return false;
        }
        
        const id = option.value;
        const titulo = option.dataset.titulo;
        const valor = parseFloat(option.dataset.valor);
        const quantidade = parseInt(document.getElementById('quantidade').value);
        
        // Validar quantidade mínima
        if (quantidade < 1) {
            alert('Quantidade deve ser maior que 0!');
            return false;
        }
        
        // Adicionar múltiplas vezes se quantidade > 1
        for (let i = 0; i < quantidade; i++) {
            addToCart(id, titulo, valor);
        }
        
        // Limpar formulário
        event.target.reset();
        
        // Mensagem de sucesso
        alert(`${quantidade} unidade(s) de "${titulo}" adicionada(s)!`);
        
        return false;
    }
</script>
```

---

## 4. Verificar Carrinho Antes de Confirmar

### Função Customizada:

```php
<script>
    function verificarCarrinho() {
        console.log('Carrinho atual:', cart);
        console.log('Total de itens:', cart.length);
        
        let total = 0;
        cart.forEach(item => {
            const subtotal = item.valor_unitario * item.quantidade;
            total += subtotal;
            console.log(`${item.titulo}: ${item.quantidade}x ${item.valor_unitario} = ${subtotal}`);
        });
        
        console.log('Total geral:', total);
        
        return cart.length > 0;
    }
    
    // Chamar antes de enviar pedido
    function confirmarPedidoComValidacao(e) {
        if (!verificarCarrinho()) {
            e.preventDefault();
            alert('Carrinho está vazio!');
            return false;
        }
        
        console.log('Enviando pedido com', cart.length, 'produtos');
        return submitCartForm(e);
    }
</script>
```

---

## 5. Adicionar Desconto/Cupom (Exemplo Avançado)

### Modificar o Carrinho com Desconto:

```php
<script>
    function aplicarDesconto(codigoCupom) {
        const desconto = 0.10; // 10% de desconto exemplo
        
        cart.forEach(item => {
            item.desconto = (item.valor_unitario * item.quantidade) * desconto;
        });
        
        renderCartItems();
        
        // Recalcular total com desconto
        const totalComDesconto = calcularTotalComDesconto();
        console.log('Total com desconto:', totalComDesconto);
    }
    
    function calcularTotalComDesconto() {
        let total = 0;
        cart.forEach(item => {
            const subtotal = (item.valor_unitario * item.quantidade) + (item.valor_iva || 0);
            const desconto = item.desconto || 0;
            total += (subtotal - desconto);
        });
        return total;
    }
</script>
```

---

## 6. Integração com Múltiplas Páginas

### Exemplo em `resources/views/menu.blade.php`:

```php
<div class="container-fluid">
    <nav class="navbar">
        <!-- ... menu items ... -->
        
        <div class="ms-auto">
            <!-- Badge do carrinho no menu -->
            <button class="btn btn-outline-primary position-relative"
                    onclick="showCartModal()" 
                    title="Abrir carrinho">
                <i class="fas fa-shopping-cart"></i>
                <span id="cart-badge-menu" class="position-absolute top-0 start-100 translate-middle 
                                                   badge rounded-pill bg-danger" 
                      style="display: none;">
                    <span id="badge-count">0</span>
                </span>
            </button>
        </div>
    </nav>
</div>

<script>
    // Atualizar badge do menu também
    function updateAllCartBadges() {
        const count = cart.length;
        
        // Badge do header
        const badge1 = document.getElementById('cart-badge');
        if (badge1) badge1.textContent = count;
        
        // Badge do menu (se existir)
        const badge2 = document.getElementById('cart-badge-menu');
        if (badge2) {
            badge2.textContent = count;
            badge2.style.display = count > 0 ? 'inline' : 'none';
        }
    }
    
    // Modificar updateCartBadge original para usar nova função
    const originalUpdateBadge = updateCartBadge;
    updateCartBadge = function() {
        originalUpdateBadge();
        updateAllCartBadges();
    };
</script>
```

---

## 7. Depuração - Função para Ver Carrinho em Tempo Real

```php
<script>
    // Adicionar ao console: debugCarrinho()
    function debugCarrinho() {
        console.clear();
        console.group('🛒 DEBUG CARRINHO');
        console.log('Total de produtos:', cart.length);
        console.log('Produtos:', cart);
        
        let total = 0;
        cart.forEach((item, index) => {
            const subtotal = item.valor_unitario * item.quantidade;
            total += subtotal;
            console.log(`[${index}] ${item.titulo} - ${item.quantidade}x ${item.valor_unitario}MT = ${subtotal}MT`);
        });
        
        console.log('Total sem IVA:', total);
        console.groupEnd();
    }
    
    // Usar no console: debugCarrinho()
</script>
```

---

## ✨ Dicas Importantes

1. **Sempre use `addslashes()`** para evitar problemas com aspas no título
2. **Valide dados no servidor** - nunca confie apenas na validação JavaScript
3. **Use `number_format()`** para formatar moeda corretamente
4. **Teste em múltiplos navegadores** - o localStorage tem limitações
5. **Limpe o carrinho após confirmação** com: `cart = []; updateCartBadge();`
