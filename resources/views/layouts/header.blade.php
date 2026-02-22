<!DOCTYPE html>
<html class="no-js" lang="en">

<!-- Made with love by Samuel Bruno Nhamazana || Yourfavoritenerd  && Cesaltina Chivite-->
<head>
        <meta charset="utf-8" />
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <title>Loja das Artes</title>
        <meta name="keywords" content="Loja,loja das artes, arte, moçambique, moz, pintura, escultura, pintura, musica, literatura, artista, quidgest, loja moçambicana,mozambique, nhamazana, bruno, samuel, samuel bruno nhamazana, ">
        <meta name="description" content="Loja das artes! Compra e Venda a sua arte" />
        <meta name="author" content="Samuel Bruno Nhamazana">
        <meta name="author" content="Cesaltina Rufino">
        <meta name="author" content="Quidgest Software Plant">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/favicon/favicon.png')}}" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800&amp;display=swap" rel="stylesheet" />

        <!-- CSS
  ============================================ -->
          <!-- CSS
  ============================================ -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

            <!-- Vendor CSS (Bootstrap & Icon Font) -->
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/ionicons.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/simple-line-icons.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/font-awesome.min.css')}}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.css')}}" type="text/css">
        <link rel="stylesheet" href="{{ asset('assets/vendor/DataTables/datatables.min.css')}}" type="text/css">
        <!-- Plugins CSS (All Plugins Files) -->
         <link rel="stylesheet" href="/assets/css/plugins/animate.css">
        <link rel="stylesheet" href="/assets/css/plugins/jquery-ui.min.css">


        <!-- Use the minified version files listed below for better performance and remove the files listed above -->
        <link rel="stylesheet" href="{{ asset('assets/css/vendor/vendor.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('assets/css/plugins/plugins.min.css')}}" />
        <link rel="stylesheet" href="{{ asset('assets/css/style.min.css')}}">

        <script>
            function edit_product(el) {
            var link = $(el) //refer `a` tag which is clicked
            var modal = $("#exampleModal") //your modal
            var product_name = link.data('name')
            var product_id = link.data('id')
            var product_description = link.data('description')
            var product_price = link.data('price')
            var product_stock = link.data('stock')
            var product_picture = link.data('picture')
            modal.find('#product_name').text(product_name); 
            modal.find('#product_id').text(product_id);
            modal.find('#product_description').text(product_description);
            modal.find('#product_price').text(product_price);
            modal.find('#product_stock').text(product_stock);
            modal.find('#product_picture').attr('src',product_picture);
            modal.find('#product_cart_link').attr('action','/add-to-cart-multiple/'+product_id);
            modal.find('#product_profile_link').attr('href','/product/'+product_id);
            modal.find('#product_wishlist_link').attr('href','/wishlist/'+product_id);
            modal.find('#product_compare_link').attr('href','/add-to-compare/'+product_id);
            }
        </script>
        <!-- Main Style CSS -->
        <!-- <link rel="stylesheet" href="assets/css/style.css" />     -->
    </head>

    <body>
        <!-- Header Section Start From Here -->
        <header class="header-wrapper">
            <!-- Header Nav Start -->
            <div class="header-nav">
                <div class="container">
                    <div class="header-nav-wrapper d-md-flex d-sm-flex d-xl-flex d-lg-flex justify-content-between">
                        <div class="header-static-nav">
                            <p>Bem vindo a Loja das Artes! <a href="https://artista.lojadasartes.co.mz/" target="_blank"> Quer Vender a Sua Arte? Clique Aqui para acessar o Portal do Vendedor ou acesse artista.lojadasartes.co.mz</a></p>
                        </div>
                        <div class="header-menu-nav">
                            <ul class="menu-nav">
                                @if(Route::has('login'))
                                @auth
                                <li>
                                    <div class="dropdown">
                                        <button type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{Auth::user()->name}} <i class="ion-ios-arrow-down"></i></button>
                                        <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton">
                                            <li><a href="/user/profile"><i class="icon-user"></i> Perfil - Utilizador</a></li>
                                            <li><a href="/signup"><i class="icon-user"></i> Perfil - Cliente</a></li>
                                            <li><a href="/cart"><i class="icon-bag" aria-hidden="true"></i> Carrinho</a></li>
                                            <li><a href="/order"><i class="icon-credit-card" aria-hidden="true"></i> Encomendas</a></li>
                                            <li><a href="/wishlist"><i class="icon-heart" aria-hidden="true"></i> Favoritos</a></li>
                                            <li><a href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item"><i class="icon-logout" aria-hidden="true"></i> Sair</a></li>
                                            <form id="logout-form" method="POST" action="{{route('logout')}}">
                                                @csrf
                                            </form>
                                        </ul>
                                    </div>
                                </li>
                                
                                @else
                                    <a  class="btn log" style="height:25px; font-size:10px; color:#fff; background-color:#2a7361; display:inline-block;  " href="{{ route('login') }}"><i class="icon-login" aria-hidden="true"></i> Login</a>
                                    <a class="btn log" style="height:25px; font-size:10px; color:#fff; background-color:#2a7361; display:inline-block;  " href="{{route('register')}}"><i class="fa fa-user-plus" aria-hidden="true"></i>Registar</a>
                                @endif
                                @endif
                                <li>
                                    <div class="dropdown">
                                        <button type="button" id="dropdownMenuButton-2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">MT <i class="ion-ios-arrow-down"></i></button>

                                        <ul class="dropdown-menu animation slideDownIn" aria-labelledby="dropdownMenuButton-2">
                                            <li><a href="#">MT   </a></li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="pr-0">
                                    <div class="dropdown">
                                        <button type="button" id="dropdownMenuButton-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <img src="/assets/images/flag/3.png" alt="" /> Português <i class="ion-ios-arrow-down"></i>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Nav End -->
            <div class="header-top bg-white ptb-30px d-xl-block d-none">
                <div class="container">
                    <div class="row">
                        <div class="col-md-2">
                            <div class="logo">
                                <a href="/"><img style="height:80px" class="img-responsive" src="{{ asset('assets/images/logo/loja-das-artes.png')}}"  alt="logo.jpg" /></a>
                            </div>
                        </div>
                        <div class="col-md-10 align-self-center">
                            <div class="header-right-element d-flex">
                                <div class="search-element media-body">
                                    <form class="d-flex" action="/search" method="GET">
                                        <div class="search-category">
                                            <select id="categ" name="categ">
                                          
                                            </select>
                                        </div>
                                        <input type="text" name="value" placeholder="O que procuras?" />
                                        <button type="submit"><i class="icon-magnifier"></i></button>
                                    </form>
                                </div>
                                <div class="contact-link">
                                    <div class="phone">
                                        <!-- Contact info removed to avoid blade data references -->
                                        <a href="tel:+258872331220">+258 87 233 1220</a>
                                    </div>
                                </div>
                                <!--Cart info Start -->
                                    <?php $total = 0; 
                                    $quant = 0; ?>
                                  
                                    
                                <div class="header-tools d-flex">
                                    <div class="cart-info d-flex align-self-center">
                                        <a href="/compare" class="shuffle" data-number="{{ count((array) session('compare'))}}"><i class="icon-shuffle"></i></a>
                                     
                                        <a href="#offcanvas-cart" class="bag offcanvas-toggle" data-number="{{$quant}}"><i class="icon-bag"></i><span>{{number_format($total, 2,',',' ')}} MT</span></a>
                                    </div>
                                </div>
                            </div>
                            <!--Cart info End -->
                        </div>
                    </div>
                </div>
            </div>
            <!-- Header Nav End -->
            <div class="header-menu bg-blue sticky-nav d-xl-block d-none padding-0px">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 custom-col-2"> 
                            <div class="header-menu-vertical">
                                <h4 class="menu-title">Categorias</h4>
                                <ul class="menu-content display-none">

                                <!-- menu content -->
                            </div>
                            <!-- header menu vertical -->
                        </div>
                        <div class="col-lg-9 custom-col-2">
                            <div class="header-horizontal-menu">
                                <ul class="menu-content">
                                    <li class="active menu-dropdown">
                                        <a href="/">Início </a>
                                    </li>
                                    <li class="menu-dropdown">
                                        <a href="/shop">Loja </a>
                                    </li>
                                    <li class="menu-dropdown">
                                        <a href="/order">Encomendas </a>
                                    </li>
                                    <li class="menu-dropdown">
                                        <a href="/compare">Comparar</a>
                                    </li>
                                    <li class="menu-dropdown">
                                        <a href="/about">Sobre nós </a>
                                    </li>
                                    <li class="menu-dropdown">
                                        <a href="/contact">Contacto </a>
                                    </li>
                                    <li class="menu-dropdown">
                                        <a href="https://artista.lojadasartes.co.mz/" target="_blank">Portal do Vendedor</a>
                                    </li>

                                </ul>
                            </div>
                            <!-- header horizontal menu -->
                            <div class="intro-text-shipping text-right">
                                <div class="free-ship"></div>
                            </div>
                        </div>
                    </div>
                    <!-- row -->
                </div>
                <!-- container -->
            </div>
            <!-- header menu -->
        </header>
        <!-- Header Section End Here -->

        <!-- Mobile Header Section Start -->
    <div class="mobile-header d-xl-none sticky-nav bg-white ptb-10px">
        <div class="container">
            <div class="row align-items-center">

                <!-- Header Logo Start -->
                <div class="col">
                    <div class="header-logo">
                        <a href="/"><img class="img-responsive" style="height: 50px" src="{{ asset('assets/images/logo/loja-das-artes.png')}}" width="35%" height="35%" alt="logo.jpg" /></a>
                    </div>
                </div>
                <!-- Header Logo End -->

                <!-- Header Tools Start -->
                <div class="col-auto">
                    <div class="header-tools justify-content-end">
                        <div class="cart-info d-flex align-self-center">
                            <a href="/compare" class="shuffle d-xs-none"  data-number="{{ count((array) session('compare'))}}"><i class="icon-shuffle"></i></a>
            
                            <a href="#offcanvas-cart" class="bag offcanvas-toggle"data-number="{{$quant}}"><i class="icon-bag"></i><span>{{number_format($total, 2,',',' ')}} MT</span></a>
                        </div>
                        <div class="mobile-menu-toggle">
                            <a href="#offcanvas-mobile-menu" class="offcanvas-toggle">
                                <svg viewBox="0 0 800 600">
                                    <path d="M300,220 C300,220 520,220 540,220 C740,220 640,540 520,420 C440,340 300,200 300,200" id="top"></path>
                                    <path d="M300,320 L540,320" id="middle"></path>
                                    <path d="M300,210 C300,210 520,210 540,210 C740,210 640,530 520,410 C440,330 300,190 300,190" id="bottom" transform="translate(480, 320) scale(1, -1) translate(-480, -318) "></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Header Tools End --> 

            </div>
        </div>
    </div>

    <!-- Search Category Start -->
    <div class="mobile-search-area d-xl-none mb-15px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="search-element media-body">
                        <form class="d-flex" action="search" method="GET">
                            <div class="search-category">
                                <select id="categ" name="categ">
                                    <option value="Todas Categorias">Categorias</option>
 
                                </select>
                            </div>
                            <input type="text" name="value" placeholder=" O que procura? ... " />
                            <button><i class="icon-magnifier"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Category End -->
    <div class="mobile-category-nav d-xl-none mb-15px">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <!--=======  category menu  =======-->
                    <div class="hero-side-category">
                        <!-- Category Toggle Wrap -->
                        <div class="category-toggle-wrap">
                            <!-- Category Toggle -->
                            <button class="category-toggle"><i class="fa fa-bars"></i> Todas Categorias</button>
                        </div>

                        <!-- Category Menu -->
                        <nav class="category-menu">
                            <ul>

                            </ul>
                        </nav>
                    </div>

                    <!--=======  End of category menu =======-->
                </div>
            </div>
        </div>

        <!-- Header Nav End -->
        <div class="header-menu  d-xl-none bg-light-gray">
            <div class="container">
                <div class="row">

                </div>
                <!-- row -->
            </div>
            <!-- container -->

        </div>
        <!-- header menu -->
    </div>
    <!-- Mobile Header Section End -->
    <!-- OffCanvas Wishlist Start -->
    <div id="offcanvas-wishlist" class="offcanvas offcanvas-wishlist">
        <div class="inner">
            <div class="head">
                <span class="title">Favoritos</span>
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll">
                <ul class="minicart-product-list">

                </ul>
            </div>
            <div class="foot">
                <div class="buttons">
                    <a href="/wishlist" class="btn btn-dark btn-hover-primary mt-30px">Ver Favoritos</a>
                </div>
            </div>
        </div>
    </div>
    <!-- OffCanvas Wishlist End -->

    <!-- OffCanvas Cart Start -->
    <div id="offcanvas-cart" class="offcanvas offcanvas-cart">
        <div class="inner">
            <div class="head">
                <span class="title">Carrinho</span>
                <button class="offcanvas-close">×</button>
            </div>
            <div class="body customScroll">
                <ul class="minicart-product-list">
                    <?php $total = 0 ?>

                </ul>
            </div>
            <div class="foot">
                <div class="sub-total">
                    <strong>Subtotal :</strong>
                    <span class="amount">{{number_format($total, 2,',',' ')}} MT</span>
                </div>
                <div class="buttons">
                    <a href="/cart" class="btn btn-dark btn-hover-primary mb-30px">Ver Carrinho</a>
                    <a href="/checkout" class="btn btn-outline-dark current-btn">Fazer Checkout</a>
                </div>
                <p class="minicart-message"></p>
            </div>
        </div>
    </div>
    <!-- OffCanvas Cart End -->

    <!-- OffCanvas Search Start -->
    <div id="offcanvas-mobile-menu" class="offcanvas offcanvas-mobile-menu">
        <div class="inner customScroll">
            <div class="head">
                <span class="title">&nbsp;</span>
                <button class="offcanvas-close">×</button>
            </div>
            <!--<div class="offcanvas-menu-search-form">
                <form action="#">
                    <input type="text" placeholder="Search...">
                    <button><i class="icon-magnifier"></i></button>
                </form>
            </div>-->
            <div class="offcanvas-menu" style="height:21rem;">
                <ul>
                    <li><a href="/"><span class="menu-text">Início</span></a></li>
                    <li><a href="/shop"><span class="menu-text">Loja</span></a> </li>
                    <li><a href="/order"><span class="menu-text">Encomendas</span></a></li>
                    <li><a href="/compare"><span class="menu-text">Comparar</span></a> </li>
                    <li><a href="/about"><span class="menu-text">Sobre nós</span></a></li>
                    <li><a href="/contact"><span class="menu-text">Contacto</span></a> </li>
                    <li><a href="https://artista.lojadasartes.co.mz/" target="_blank"><span class="menu-text">Portal do Artista</span></a> </li>
                    <li><a href="/signup"><span class="menu-text">Perfil do Cliente</span></a> </li>
                    <li><a href="/user/profile"><span class="menu-text">Perfil do Utilizador</span></a> </li>
                </ul>
            </div>
            <div class="offcanvas-buttons mt-30px">
                <div class="header-tools d-flex">
                    <div class="cart-info d-flex align-self-center">

                        <a href="/cart" data-number="{{ count((array) session('cart'))}}"><i class="icon-bag"></i></a>
                    </div>
                </div>
            </div>
            <div class="offcanvas-social mt-30px">
                <ul>
                    <li>
                        <a href="https://www.facebook.com/quidgest.co.mz/" target="_blank"><i class="ion-social-facebook"></i></a>
                    </li>
                    <li>
                        <a href="https://www.linkedin.com/company/quidgest-software-plant" target="_blank"><i class="ion-social-linkedin"></i></a>
                    </li>
                    <li>
                        <a href="https://www.instagram.com/quidgest.mz" target="_blank"><i class="ion-social-instagram"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- OffCanvas Search End -->
    @if (session('success'))
    <div class="alert alert-success"> 
      {{ session('success') }} - Abrir <a href="/cart" data-toggle="tooltip" title="Carrinho"><i class="ion-ios-cart"></i></a> | <a href="/wishlist" data-toggle="tooltip" title="Favoritos"><i class="ion-heart"></i></a> | <a href="/compare" data-toggle="tooltip" title="Comparar"><i class="ion-shuffle"></i></a>
    </div>
    @endif

    @if (session('missingStock'))
    <div class="alert alert-warning">
      {{ session('missingStock') }} - <a href="/cart">Abrir Carrinho</a>
    </div>
    @endif

    @if (session('SucessoAvaliacao'))
            <div class="alert alert-success">
              {{ session('SucessoAvaliacao') }}
            </div>
            @endif

            @if (session('favoritado'))
            <div class="alert alert-success">
              {{ session('favoritado') }} - <a href="/wishlist">Abrir Favoritos</a>
            </div>
            @endif
            @if (session('desfavoritado'))
                <div class="alert alert-success">
                {{ session('desfavoritado') }}  - <a href="/wishlist">Abrir Favoritos</a>
                </div>
            @endif
            @if (session('newsletter'))
            <div class="alert alert-success">
                {{ session('newsletter') }}
            </div>
            @endif
            @if (session('orderDeliver'))
            <div class="alert alert-warning">
                {{ session('orderDeliver') }}
            </div>
            @endif
            @if (session('Existnewsletter'))
            <div class="alert alert-danger">
                {{ session('Existnewsletter') }}
            </div>
            @endif
            <script>
                $(".remove-from-cart").click(function (e) {
                        e.preventDefault();
                        var ele = $(this);
                        if(confirm("Tem certeza que deseja eliminar?")) {
                            $.ajax({
                                url: '{{ url('remove-from-cart') }}',
                                method: "DELETE",
                                data: {_token: '{{ csrf_token() }}', id: ele.attr("data-id")},
                                success: function (response) {
                                    window.location.reload();
                                }
                            });
                        }
                    });
            </script>
            <!-- Made with love by Samuel Bruno Nhamazana || Yourfavoritenerd  && Cesaltina Chivite-->

