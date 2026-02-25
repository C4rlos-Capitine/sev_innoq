<header class="shadow-sm">
    <nav class="navbar navbar-expand-lg navbar-light bg-white py-3">
        <div class="container">

            <!-- Logo / Nome -->
            <a class="navbar-brand fw-semibold text-primary" href="#">
                Venda de Normas
            </a>

            <!-- Mobile toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" 
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">
                
                <!-- Links principais -->
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 gap-lg-3">
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="#">Início</a>
                    </li>
                    @auth
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('norma.index') }}">Normas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('precos.index') }}">Preços</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-medium" href="{{ route('pedidos.index') }}">Pedidos</a>
                    </li>
                    <li>
                        <a class="nav-link fw-medium" href="{{ route('users.index') }}">Utilizadores</a>
                    </li>
                    @endauth


                </ul>
                @guest
                <li class="nav-item">
                    <a class="nav-link fw-medium" href="{{ route('loja') }}">Loja</a>
                </li>
                <li>
                    <a class="nav-link fw-medium" href="{{ route('pedidos.consultar.form') }}">Consultar Pedido</a>
                </li>
                @endguest
                <!-- Área direita -->
                <div class="d-flex align-items-center gap-3">

                    <!-- Carrinho -->
                    <button type="button" 
                        class="btn btn-outline-secondary position-relative"
                        onclick="showCartModal()">

                        <i class="fas fa-shopping-cart me-1"></i>
                        Carrinho

                        <span id="cart-badge"
                            class="position-absolute top-0 start-100 translate-middle 
                                   badge rounded-pill bg-danger"
                            style="display: none;">
                            0
                        </span>
                    </button>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                    @auth
                    <a href="#" class="btn btn-outline-danger"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    @endauth
                    <!-- Admin -->
                    <a href="{{ route('login') }}" 
                       class="btn btn-primary">
                    Login
                    </a>

                </div>
            </div>
        </div>
    </nav>
</header>