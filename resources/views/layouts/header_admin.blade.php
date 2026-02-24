<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Venda de Normas</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="#">Início</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('norma.index') }}">Normas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('precos.index') }}">Preços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('loja') }}">Loja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pedidos.index') }}">Pedidos</a>
                    </li>
                    <li>
                        <button type="button" class="btn btn-outline-primary" onclick="showCartModal()">
                            Produtos adicionados 
                            <i class="fas fa-shopping-cart"></i>
                            <span id="cart-badge" class="badge bg-danger" style="display: none; font-size: 0.7em; margin-left: 5px;">0</span>
                        </button>
                    </li>
            </ul>
        </div>
        <div class="d-flex">

            <a href="#" class="btn btn-outline-light">Portal Do Administrador</a>
            </div>
    </nav>

</header>