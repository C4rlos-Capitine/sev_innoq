<!-- Footer Area Start -->
<div class="footer-area">
    <div class="footer-container">
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-lg-4 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <h4 class="footer-herading">Loja das Artes</h4>
                            <div class="need-help">
                                <p class="phone-info">
                                    Precisa de Ajuda?
                                    <span>
                                        847 331 220<br />
                                    <small>contacto@lojadasartes.co.mz</small>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 mb-md-30px mb-lm-30px">
                        <div class="single-wedge">
                            <h4 class="footer-herading">Informações</h4>
                            <div class="footer-links">
                                <ul>
                                    <li><a href="https://artista.lojadasartes.co.mz/" target="_blank">Portal do Artista</a></li>
                                    <li><a href="/faq">Como efectuar o pagamento?</a></li>
                                    <li><a href="/faq">Perguntas Frequentes</a></li>
                                    <li><a href="/about">Sobre nós</a></li>
                                    <li><a href="/contact">Contacto</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-2 mb-sm-30px mb-lm-30px">
                        <div class="single-wedge">
                            <h4 class="footer-herading">Links Úteis</h4>
                            <div class="footer-links">
                                <ul>
                                    <li><a href="/shop">Loja</a></li>
                                    <li><a href="/order">Encomendas </a></li>
                                    <li><a href="/login">Login</a></li>
                                    <li><a href="/register">Resgistar-se</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4 ">
                        <div class="single-wedge">
                            <h4 class="footer-herading">Inscreva-se no nosso Newsletter</h4>
                            <div id="mc_embed_signup" class="subscribe-form">
                                <form
                                    class="validate"
                                    action="/addNewsletter" method="POST">
                                    @csrf
                                    <div  class="mc-form">
                                        <input  type="email" required placeholder="Seu Email..." name="email" />
                                        
                                        <div class="clear"> 
                                            <input class="button" type="submit" name="subscribe" value="SUBMETER" />
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="social-info">
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
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        
                        <p class="copy-text">  Copyright © 2021 Todos os Direitos Reservados <a class="company-name" href="https://quidgest.co.mz/">
                            <strong>| QUIDGEST SOFTWARE PLANT.</strong> </a></p>
                    </div>
                    <div class="col-md-6 text-right">
                        <img class="payment-img" src="/assets/images/icons/payment.png" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Footer Area End -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12 mb-lm-100px mb-sm-30px">
                         <!-- Swiper -->
                          <div class="swiper-container gallery-top">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide"> 
                                        <img class="img-responsive m-auto" id="product_picture" src="" alt="">
                                   </div>
                                </div>
                          </div>
                          <div class="pro-details-cart btn-hover">
                            <a href="" id="product_profile_link">VER MAIS&nbsp;&nbsp;<i class="ion-eye"></i></a>
                        </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                        <div class="product-details-content quickview-content">
                            <h2 id="product_name"></h2>
                            <!--<p class="reference">Reference:<span > demo_17</span></p>-->
                            <div class="pro-details-rating-wrap">
                                <!--<div class="rating-product">
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                    <i class="ion-android-star"></i>
                                </div>-->
                                <span class="read-review">Stock: <span id="product_stock"></span></span>
                            </div>
                            <div class="pricing-meta">
                                <ul>
                                    <li class="old-price not-cut" id="product_price"> MT</li>
                                </ul>
                            </div>
                            <p class="quickview-para" id="product_description"></p>
                            <form action="" id="product_cart_link" method="">
                                <div class="pro-details-quality">
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" type="text" name="qtybutton" value="1"/>
                                    </div>
                                    <div class="pro-details-cart btn-hover">
                                        <button type="submit" style="margin-left: 2px; margin-top: 0.3rem" class="btn btn-success" ><i class="ion-ios-cart"></i> Adicionar</button>
                                    </div>
                                </div>
                            </form>
                            <div class="pro-details-wish-com">
                                <div class="pro-details-wishlist">
                                    <a href="" id="product_wishlist_link"><i class="ion-android-favorite-outline"></i>Adicionar aos Favoritos</a>
                                </div>
                                <div class="pro-details-compare">
                                    <a href="" id="product_compare_link"><i class="ion-ios-shuffle-strong"></i>Adicionar a Comparação</a>
                                </div>
                            </div>
                            <div class="pro-details-social-info">
                                <span>Partilhar</span>
                                <div class="social-info">
                                    <ul>
                                        <li>
                                            <a href="#"><i class="ion-social-facebook"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-twitter"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-google"></i></a>
                                        </li>
                                        <li>
                                            <a href="#"><i class="ion-social-instagram"></i></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal end -->

<!-- JS 
============================================ -->

    <!-- Vendors JS -->
<script src="{{ asset('assets/js/vendor/jquery-3.5.1.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/jquery-migrate-3.3.0.min.js')}}"></script>
<script src="{{ asset('assets/js/vendor/modernizr-3.7.1.min.js')}}"></script>
<script src="{{ asset('assets/vendor/DataTables/datatables.js')}}"></script>
<script src="{{ asset('assets/vendor/DataTables/datatables.min.js')}}"></script>

    <!-- Plugins JS -->
 <script src="{{ asset('assets/js/plugins/jquery-ui.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/swiper.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/countdown.js')}}"></script>
<script src="{{ asset('assets/js/plugins/scrollup.js')}}"></script>
<script src="{{ asset('assets/js/plugins/elevateZoom.js')}}"></script>


<!-- Use the minified version files listed below for better performance and remove the files listed above -->
<!-- <script src="{{ asset('assets/js/vendor/vendor.min.js')}}"></script>
<script src="{{ asset('assets/js/plugins/plugins.min.js')}}"></script> -->
<!-- Owl Carousel Js -->
<script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
<script src="{{ asset('assets/js/nouislider.min.js')}}"></script>
<script src="{{ asset('assets/js/slick.min.js')}}"></script>

<!-- Main Activation JS -->
<script src="{{ asset('assets/js/main.js')}}"></script>

<script>
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
    });
    </script>
</body>

<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/614c269fd326717cb682e913/1fg8ndo8j';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
    </script>
<!--End of Tawk.to Script-->

<script>
 $(function(){
        var dtToday = new Date();
    
        var month = dtToday.getMonth() + 1;// jan=0; feb=1 .......
        var day = dtToday.getDate();
        var year = dtToday.getFullYear() - 18;
        if(month < 10)
            month = '0' + month.toString();
        if(day < 10)
            day = '0' + day.toString();
    	var minDate = year + '-' + month + '-' + day;
        var maxDate = year + '-' + month + '-' + day;
    	$('#example-date-input').attr('max', maxDate);
    });
</script>

<!-- Made with love by Samuel Bruno Nhamazana || Yourfavoritenerd  && Cesaltina Chivite-->
</html>