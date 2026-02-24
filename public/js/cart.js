// Global cart management
let cart = [];

function addToCart(id_norma, titulo = null, valor_unitario = null) {
    // If called with just ID, try to find from normas array
    if (!titulo || !valor_unitario) {
        if (typeof normas !== 'undefined') {
            const norma = normas.find(n => n.id === id_norma);
            if (!norma) return alert('Produto não encontrado');
            titulo = norma.titulo;
            valor_unitario = Number(norma.valor);
        } else {
            return alert('Dados do produto não disponíveis');
        }
    }

    const existing = cart.find(i => i.id_norma === id_norma);
    if (existing) {
        existing.quantidade += 1;
    } else {
        cart.push({
            id_norma: id_norma,
            titulo: titulo,
            valor_unitario: valor_unitario,
            quantidade: 1,
            valor_iva: 0
        });
    }
    updateCartBadge();
    showCartModal();
}

function showCartModal() {
    renderCartItems();
    const modal = new bootstrap.Modal(document.getElementById('cartModal'));
    modal.show();
}

function renderCartItems() {
    const tbody = document.getElementById('cart-items');
    if (!tbody) return;
    
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
            <td>${Number(it.valor_iva || 0).toFixed(2)}</td>
            <td>${lineTotal.toFixed(2)}</td>
            <td><button class="btn btn-sm btn-danger" onclick="removeItem(${idx})">Remover</button></td>
        `;
        tbody.appendChild(tr);
    });
    
    const totalElement = document.getElementById('cart-total');
    if (totalElement) {
        totalElement.textContent = total.toFixed(2);
    }
    
    const cartJsonInput = document.getElementById('cart-items-json');
    if (cartJsonInput) {
        cartJsonInput.value = JSON.stringify(cart);
    }
}

function updateQty(idx, value) {
    cart[idx].quantidade = parseInt(value) || 1;
    renderCartItems();
}

function removeItem(idx) {
    cart.splice(idx, 1);
    renderCartItems();
    updateCartBadge();
}

function submitCartForm(e) {
    if (cart.length === 0) {
        e.preventDefault();
        alert('O carrinho está vazio.');
        return false;
    }
    return true;
}

// Update cart badge
function updateCartBadge() {
    const badge = document.getElementById('cart-badge');
    if (badge) {
        if (cart.length > 0) {
            badge.textContent = cart.length;
            badge.style.display = 'inline-block';
        } else {
            badge.style.display = 'none';
        }
    }
}

// Initialize cart badge display
document.addEventListener('DOMContentLoaded', function() {
    updateCartBadge();
});

