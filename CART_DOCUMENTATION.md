# Sistema de Carrinho de Compras - Documentação

## Alterações Realizadas

### 1. **Sistema Global de Carrinho**
- Arquivo: `public/js/cart.js` e `resources/js/cart.js`
- Funções principais:
  - `addToCart(id_norma, titulo, valor_unitario)` - Adiciona produtos ao carrinho
  - `showCartModal()` - Abre o modal do carrinho
  - `renderCartItems()` - Renderiza os itens do carrinho
  - `updateQty(idx, value)` - Atualiza quantidade de um item
  - `removeItem(idx)` - Remove um item do carrinho
  - `updateCartBadge()` - Atualiza o badge de contagem

### 2. **Modal do Carrinho (Reutilizável)**
- Arquivo: `resources/views/layouts/cart-modal.blade.php`
- Funcionalidades:
  - Exibe tabela com produtos do carrinho
  - Permite ajustar quantidades
  - Remove produtos
  - Formulário para dados do comprador (tipo, nome, email, telefone, NUIT, provincia, endereço)
  - Total automático
  - Envio para rota `pedidos.store`

### 3. **Header Ajustado**
- Arquivo: `resources/views/layouts/header_admin.blade.php`
- Botão "Produtos adicionados" agora:
  - Chama `showCartModal()` quando clicado
  - Exibe badge com quantidade de produtos
  - Funciona em qualquer página

### 4. **Layout Principal Atualizado**
- Arquivo: `resources/views/layouts/app.blade.php`
- Adições:
  - Inclusão do modal do carrinho globalmente
  - Carregamento do script `cart.js`

### 5. **Página de Loja Simplificada**
- Arquivo: `resources/views/loja.blade.php`
- Alterações:
  - Remoção de código duplicado (modal e JavaScript)
  - Botão de adicionar ao carrinho agora passa título e valor
  - Script de carregamento de províncias consolidado

## Como Usar

### Para Adicionar Produto ao Carrinho:

```javascript
// Com ID e dados diretos (recomendado)
addToCart(id_norma, 'Título do Produto', valor_unitario);

// Ou apenas com ID (se normas estiverem definidas globalmente)
addToCart(id_norma);
```

### Para Abrir o Carrinho de Qualquer Lugar:

```javascript
showCartModal();
```

### Para Verificar o Carrinho:

```javascript
console.log(cart); // Exibe array com todos os itens
```

## Características

✅ **Carrinho Global** - Funciona em qualquer página do site
✅ **Múltiplos Produtos** - Adicione quantos produtos quiser
✅ **Ajuste de Quantidades** - Mude quantidades diretamente no modal
✅ **Remover Itens** - Delete produtos do carrinho
✅ **Badge de Contagem** - Visualize quantos produtos estão no carrinho
✅ **Dados do Comprador** - Colete informações necessárias na compra
✅ **Cálculo Automático** - Total é calculado automaticamente
✅ **Geração de Referência** - Sistema automático de referência de pagamento

## Fluxo de Compra

1. Usuário clica no botão "Adicionar ao carrinho" (ícone de carrinho)
2. Produto é adicionado ao carrinho global
3. Badge do header mostra quantidade de produtos
4. Usuário pode:
   - Continuar comprando em outras páginas
   - Adicionar mais produtos
   - Clicar em "Produtos adicionados" para abrir o carrinho
5. No modal:
   - Visualiza todos os produtos adicionados
   - Pode ajustar quantidades
   - Pode remover itens
   - Preenche dados do comprador
   - Clica "Confirmar Pedido"
6. Pedido é salvo no banco de dados
7. Referência de pagamento é gerada automaticamente

## Dados Armazenados

O carrinho mantém os seguintes dados por produto:
- `id_norma` - ID do produto
- `titulo` - Nome do produto
- `valor_unitario` - Preço unitário
- `quantidade` - Quantidade pedida
- `valor_iva` - IVA (imposto)

## Notas Importantes

- O carrinho é armazenado em memória JavaScript (sessão do navegador)
- Se a página for recarregada, o carrinho será limpo
- Para persister carrinho entre páginas, modifique o código para usar localStorage
- O pedido é validado no servidor antes de ser salvo
- Valor mínimo de 10 MT é necessário para gerar referência de pagamento
