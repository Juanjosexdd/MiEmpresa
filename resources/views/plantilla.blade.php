@php
    use App\Http\Controllers\Controller;
@endphp
<!DOCTYPE html>
<html class="no-js" lang="zxx">
<head>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<title>@yield('title') | Mi Empresa</title>
<meta name="path" content="{{ url('/') }}">
<meta name="csrf" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/alertify.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/main.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/themes/bootstrap.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
<script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/alertify.min.js') }}"></script>

</head>
<body>

    <div class="preloader">
        <div class="preloader-inner">
            <div class="preloader-icon">
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <header class="header navbar-area">
        <div class="topbar">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-left">
                            <ul class="menu-top-link"></ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-middle">
                            <ul class="useful-links"></ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-end">
                            <ul class="user-login">
                                <li>
                                    <a href="{{ route('login') }}">
                                        <div class="user">
                                            <i class="lni lni-user"></i>
                                            Login
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">

                        <a class="navbar-brand" href="{{ url('/') }}">
                            {{-- <img src="{{ asset('assets/images/settings/' . Controller::get_settings()->logo_shop) }}" alt="Logo"> --}}
                        </a>

                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">

                        <div class="main-menu-search">

                            <div class="navbar-search search-style-5">

                                <div class="search-input">
                                    <input type="text" placeholder="Escriba algo para buscar">
                                </div>
                                <div class="search-btn">
                                    <button><i class="lni lni-search-alt"></i></button>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="nav-hotline">
                                <i class="lni lni-phone"></i>
                                <h3>Teléfono:
                                    <span>(+58) 4125205105</span>
                                </h3>
                            </div>

                            <div class="navbar-cart">
                                <div class="cart-items">
                                    <a href="{{ route('cart') }}" class="main-btn">
                                        <i class="lni lni-cart"></i>
                                        <span class="total-items quantity_products"></span>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 col-md-6 col-12">
                    <div class="nav-inner">
                        <nav class="navbar navbar-expand-lg">
                            <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="collapse"
                                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                                <span class="toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse sub-menu-bar" id="navbarSupportedContent">
                                <ul id="nav" class="navbar-nav ms-auto">
                                    <li class="nav-item">
                                        <a href="{{ route('home') }}" class=""
                                            aria-label="Toggle navigation">Inicio</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('letter') }}" aria-label="Toggle navigation">Carta</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="contact.html" aria-label="Toggle navigation">Contacto</a>
                                    </li>

                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 col-12">
                    <div class="nav-social">
                        <h5 class="title">Síguenos:</h5>
                        <ul>
                            <li>
                                <a href="" target="_blank"><i class="lni lni-facebook-filled"></i></a>
                            </li>
                            <li>
                                <a href="" target="_blank"><i class="lni lni-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
    </header>
    
    @yield('content')
    
    
    
    <footer class="footer">
        <div class="footer-top">
            <div class="container">
                <div class="inner-content">
                    <div class="row">
                        <div class="col-lg-3 offset-md-5 col-md-4 col-12">
                            <div class="footer-logo">
                                <a href="{{ route('home') }}">
                                    {{-- <img src="{{ asset('assets/images/settings/' . Controller::get_settings()->logo_footer) }}" alt="#"> --}}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
        
    <a href="#" class="scroll-top">
    <i class="lni lni-chevron-up"></i>
    </a>
   
    <script type="text/javascript">
            //========= Hero Slider 
            tns({
                container: '.hero-slider',
                slideBy: 'page',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 0,
                items: 1,
                nav: false,
                controls: true,
                controlsText: ['<i class="lni lni-chevron-left"></i>', '<i class="lni lni-chevron-right"></i>'],
            });
    
            //======== Brand Slider
            tns({
                container: '.brands-logo-carousel',
                autoplay: true,
                autoplayButtonOutput: false,
                mouseDrag: true,
                gutter: 15,
                nav: false,
                controls: false,
                responsive: {
                    0: {
                        items: 1,
                    },
                    540: {
                        items: 3,
                    },
                    768: {
                        items: 5,
                    },
                    992: {
                        items: 6,
                    }
                }
            });
    
        </script>
    <script>
            const finaleDate = new Date("February 15, 2023 00:00:00").getTime();
    
            const timer = () => {
                const now = new Date().getTime();
                let diff = finaleDate - now;
                if (diff < 0) {
                    document.querySelector('.alert').style.display = 'block';
                    document.querySelector('.container').style.display = 'none';
                }
    
                let days = Math.floor(diff / (1000 * 60 * 60 * 24));
                let hours = Math.floor(diff % (1000 * 60 * 60 * 24) / (1000 * 60 * 60));
                let minutes = Math.floor(diff % (1000 * 60 * 60) / (1000 * 60));
                let seconds = Math.floor(diff % (1000 * 60) / 1000);
    
                days <= 99 ? days = `0${days}` : days;
                days <= 9 ? days = `00${days}` : days;
                hours <= 9 ? hours = `0${hours}` : hours;
                minutes <= 9 ? minutes = `0${minutes}` : minutes;
                seconds <= 9 ? seconds = `0${seconds}` : seconds;
    
                document.querySelector('#days').textContent = days;
                document.querySelector('#hours').textContent = hours;
                document.querySelector('#minutes').textContent = minutes;
                document.querySelector('#seconds').textContent = seconds;
    
            }
            timer();
            setInterval(timer, 1000);
        </script>
        <script>
            function load_quantity()
            {
                let path = $('meta[name="path"]').attr('content'),
                    csrf = $('meta[name="csrf"]').attr('content');

                    $.ajax({
                        url 		: path + '/quantityproducts',
                        method  	: 'POST',
                        data        : {
                            '_token' : csrf
                        },
                        success		: function(r) {
                            if(!r.status) {
                                alert(r.msg);
                                return;
                            }

                            $('.quantity_products').html(r.quantity);
                            load_cart();
                        },
                        dataType	: 'json'
                    });
            }

            load_quantity();
        </script>
    @yield('scripts')
    </body>
    </html>