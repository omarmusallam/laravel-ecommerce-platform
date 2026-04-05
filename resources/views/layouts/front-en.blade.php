<!DOCTYPE html>
<html class="no-js" lang="en" dir="ltr">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <title>{{ $title }}</title>
    <meta name="description" content="ShopGrids premium electronics store" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    @php
        $frontFavicon = $settings->tab_logo_url ?? asset('assets/images/favicon.svg');
        $frontLogo = $settings->website_logo_url ?? asset('assets/images/logo/logo.svg');
        $contactPhone = $settings->phone ?: '+1 202 555 0187';
    @endphp
    <link rel="shortcut icon" type="image/x-icon" href="{{ $frontFavicon }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/LineIcons.3.0.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/tiny-slider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/glightbox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <style>
        .header.navbar-area {
            background: #fff;
            box-shadow: 0 10px 35px rgba(15, 23, 42, 0.06);
            border-bottom: 1px solid #eef2f7;
        }

        .topbar {
            background: linear-gradient(90deg, #081a2f 0%, #0f2743 100%);
        }

        .topbar .menu-top-link li,
        .topbar .useful-links li a,
        .topbar .user,
        .topbar .user a,
        .topbar .user-login li a {
            color: rgba(255, 255, 255, 0.9) !important;
        }

        .header-middle {
            padding: 18px 0;
            background: #fff;
        }

        .header-middle .navbar-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-height: 54px;
        }

        .header-middle .navbar-brand img {
            max-height: 44px;
            width: auto;
        }

        .header-middle .brand-text {
            color: #081828;
            font-size: 26px;
            font-weight: 800;
            letter-spacing: -0.03em;
        }

        .header-middle .main-menu-search {
            padding: 0;
        }

        .header-middle .navbar-search {
            border: 1px solid #d8e2f0;
            border-radius: 16px;
            overflow: hidden;
            background: #fff;
        }

        .header-middle .navbar-search .search-input input {
            border: 0;
            min-height: 52px;
            padding-inline: 18px;
        }

        .header-middle .navbar-search .search-btn button {
            min-width: 60px;
            border-radius: 0;
        }

        .middle-right-area {
            gap: 18px;
        }

        .nav-hotline {
            padding: 10px 14px;
            border-radius: 16px;
            background: #f8fbff;
            border: 1px solid #e6edf7;
        }

        .nav-hotline h3 {
            font-size: 14px;
            line-height: 1.45;
        }

        .nav-hotline h3 span {
            margin-top: 2px;
            font-size: 13px;
            color: #667085;
        }

        .nav-inner {
            min-height: 72px;
            border-radius: 20px;
            padding: 0 18px;
            background: #fff;
            border: 1px solid #edf2f7;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.05);
        }

        .mega-category-menu {
            min-width: 210px;
        }

        .mega-category-menu .cat-button {
            border-radius: 14px;
            background: #f8fbff;
            border: 1px solid #e6edf7;
            min-height: 50px;
            display: inline-flex;
            align-items: center;
            padding: 0 16px;
        }

        .nav-inner .navbar {
            padding: 0;
        }

        .nav-inner .navbar-nav .nav-item a {
            font-weight: 600;
        }

        .nav-social {
            justify-content: flex-end;
        }

        .nav-social ul li a {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #f8fbff;
            border: 1px solid #e6edf7;
        }

        .product-card-column {
            display: flex;
        }

        .product-card-column .single-product {
            width: 100%;
            min-height: 100%;
            display: flex;
            flex-direction: column;
            margin-top: 0;
        }

        .single-product .product-image {
            position: relative;
            overflow: hidden;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 10px;
        }

        .single-product .product-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            padding: 14px;
        }

        .single-product .product-info {
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            padding-bottom: 0;
        }

        .single-product .product-info .product-title {
            min-height: 44px;
            margin-bottom: 6px;
            overflow: hidden;
        }

        .single-product .product-info .product-title a {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.45;
            min-height: 42px;
        }

        .single-product .product-info .product-review {
            min-height: 24px;
        }

        .single-product .product-info .product-price {
            margin-top: auto;
            display: flex;
            align-items: baseline;
            gap: 10px;
            flex-wrap: wrap;
        }

        .single-product .product-info .price .discount-price {
            margin-left: 0;
        }

        .single-product .product-image .button {
            position: absolute;
            inset: auto 16px 16px 16px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: all 0.25s ease;
            z-index: 2;
        }

        .single-product:hover .product-image .button {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .single-product .product-image::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(8, 24, 40, 0) 45%, rgba(8, 24, 40, 0.22) 100%);
            opacity: 0;
            transition: opacity 0.25s ease;
            pointer-events: none;
        }

        .single-product:hover .product-image::after {
            opacity: 1;
        }

        .single-product:hover {
            transform: translateY(-3px);
            transition: transform 0.25s ease;
        }

        .single-product .product-image .button .btn {
            width: 100%;
            min-height: 42px;
            padding: 0 18px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.96);
            border: 1px solid rgba(255, 255, 255, 0.96);
            color: #081828;
            font-size: 13px;
            font-weight: 700;
            box-shadow: 0 12px 24px rgba(8, 24, 40, 0.12);
        }

        .single-product .product-image .button .btn:hover {
            background: #0167f3;
            border-color: #0167f3;
            color: #fff;
        }

        .product-card-grid {
            --bs-gutter-x: 28px;
            --bs-gutter-y: 28px;
        }

        .special-offer .offer-content .image {
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(180deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 4px;
        }

        .special-offer .offer-content .image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            object-position: center;
            padding: 16px;
        }

        .special-offer .offer-content .text p {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .footer {
            background: linear-gradient(180deg, #081a2f 0%, #0a2038 100%);
        }

        .footer .footer-middle {
            padding-top: 72px;
        }

        .footer .single-footer h3 {
            font-size: 18px;
            margin-bottom: 22px;
        }

        .footer .single-footer ul li,
        .footer .single-footer ul li a,
        .footer .single-footer .mail a,
        .footer .single-footer .phone {
            color: rgba(255, 255, 255, 0.78) !important;
        }

        .footer .single-footer ul li a:hover,
        .footer .single-footer .mail a:hover {
            color: #fff !important;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            margin-top: 24px;
        }

        .footer .payment-gateway,
        .footer .copyright,
        .footer .socila {
            color: rgba(255, 255, 255, 0.78);
        }

        .footer .socila li a {
            width: 34px;
            height: 34px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
        }

        @media (max-width: 991.98px) {
            .header-middle {
                padding: 14px 0;
            }

            .nav-inner {
                padding: 14px 16px;
            }

            .single-product .product-image {
                height: 250px;
            }

            .special-offer .offer-content .image {
                height: 280px;
            }
        }

        @media (max-width: 575.98px) {
            .topbar .top-middle,
            .topbar .top-end {
                text-align: center;
            }

            .single-product .product-image {
                height: 220px;
            }

            .single-product .product-info {
                padding: 18px 16px;
            }

            .special-offer .offer-content .image {
                height: 240px;
            }
        }
    </style>
    @stack('styles')
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
                            <ul class="menu-top-link">
                                <li>
                                    <div class="select-position">
                                        <form action="{{ route('currency.store') }}" method="post">
                                            @csrf
                                            <select name="currency_code" onchange="this.form.submit()">
                                                <option value="USD" @selected('USD' == session('currency_code', 'USD'))>$ USD</option>
                                                <option value="EUR" @selected('EUR' == session('currency_code'))>EUR</option>
                                                <option value="ILS" @selected('ILS' == session('currency_code'))>ILS</option>
                                                <option value="JOD" @selected('JOD' == session('currency_code'))>JOD</option>
                                                <option value="SAR" @selected('SAR' == session('currency_code'))>SAR</option>
                                                <option value="QAR" @selected('QAR' == session('currency_code'))>QAR</option>
                                            </select>
                                        </form>
                                    </div>
                                </li>
                                <li><span class="text-white">ShopGrids</span></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-middle">
                            <ul class="useful-links">
                                <li><a href="{{ route('home') }}">Home</a></li>
                                <li><a href="{{ route('about-us') }}">About</a></li>
                                <li><a href="{{ route('contact-us') }}">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-12">
                        <div class="top-end">
                            @auth
                                <div class="user">
                                    <i class="lni lni-user"></i>
                                    <a href="{{ route('user-profile.edit') }}" style="color: #fff">{{ Auth::user()->name }}</a>
                                </div>
                                <ul class="user-login">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault(); document.getElementById('logout').submit()">Sign Out</a>
                                    </li>
                                    <form action="{{ route('logout') }}" id="logout" method="post" style="display:none">
                                        @csrf
                                    </form>
                                </ul>
                            @else
                                <div class="user">
                                    <i class="lni lni-user"></i>
                                    Welcome
                                </div>
                                <ul class="user-login">
                                    <li><a href="{{ route('login') }}">Sign In</a></li>
                                    <li><a href="{{ route('user.register') }}">Create Account</a></li>
                                </ul>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="header-middle">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-3 col-md-3 col-7">
                        <a class="navbar-brand" href="{{ route('home') }}">
                            <img src="{{ $frontLogo }}" alt="ShopGrids">
                            <span class="brand-text">ShopGrids</span>
                        </a>
                    </div>
                    <div class="col-lg-5 col-md-7 d-xs-none">
                        <form action="{{ route('list-products.index') }}" method="get">
                            <div class="main-menu-search">
                                <div class="navbar-search search-style-5">
                                    <div class="search-input">
                                        <x-form.input name="name" placeholder="Search for a laptop, phone, or monitor"
                                            :value="request('name')" />
                                    </div>
                                    <div class="search-btn">
                                        <button><i class="lni lni-search-alt"></i></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-4 col-md-2 col-5">
                        <div class="middle-right-area">
                            <div class="nav-hotline">
                                <i class="lni lni-phone"></i>
                                <h3>Phone Support:
                                    <span>{{ $contactPhone }}</span>
                                </h3>
                            </div>
                            <div class="navbar-cart">
                                <x-cart-menu />
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
                        <div class="mega-category-menu">
                            <span class="cat-button"><i class="lni lni-menu"></i>All Categories</span>
                            <ul class="sub-category">
                                @foreach ($categories as $category)
                                    <li><a href="{{ route('list-products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                                @endforeach
                            </ul>
                        </div>
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
                                    <li class="nav-item"><a href="{{ route('home') }}">Home</a></li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-pages" aria-expanded="false">Pages</a>
                                        <ul class="sub-menu collapse" id="submenu-pages">
                                            <li class="nav-item"><a href="{{ route('about-us') }}">About</a></li>
                                            <li class="nav-item"><a href="{{ route('faq') }}">FAQ</a></li>
                                            <li class="nav-item"><a href="{{ route('login') }}">Sign In</a></li>
                                            <li class="nav-item"><a href="{{ route('register') }}">Register</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item">
                                        <a class="dd-menu collapsed" href="javascript:void(0)" data-bs-toggle="collapse"
                                            data-bs-target="#submenu-store" aria-expanded="false">Store</a>
                                        <ul class="sub-menu collapse" id="submenu-store">
                                            <li class="nav-item"><a href="{{ route('list-products.index') }}">All Products</a></li>
                                            <li class="nav-item"><a href="{{ route('cart.index') }}">Cart</a></li>
                                            <li class="nav-item"><a href="{{ route('checkout') }}">Checkout</a></li>
                                        </ul>
                                    </li>
                                    <li class="nav-item"><a href="{{ route('contact-us') }}">Contact</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 col-12">
                    <div class="nav-social">
                        <h5 class="title">Follow Us:</h5>
                        <ul>
                            <li><a href="javascript:void(0)"><i class="lni lni-facebook-filled"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-twitter-original"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-instagram"></i></a></li>
                            <li><a href="javascript:void(0)"><i class="lni lni-linkedin-original"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{ $breadcrumb ?? '' }}
    {{ $slot }}

    <footer class="footer">
        <div class="footer-middle">
            <div class="container">
                <div class="bottom-inner">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer f-contact">
                                <h3>Contact the Store Team</h3>
                                <p class="phone">Phone: {{ $contactPhone }}</p>
                                <ul>
                                    <li><span>Monday - Friday:</span> 9:00 AM - 8:00 PM</li>
                                    <li><span>Saturday:</span> 10:00 AM - 6:00 PM</li>
                                </ul>
                                <p class="mail">
                                    <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                                </p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h3>Quick Links</h3>
                                <ul>
                                    <li><a href="{{ route('register') }}">Create Account</a></li>
                                    <li><a href="{{ route('login') }}">Sign In</a></li>
                                    <li><a href="{{ route('about-us') }}">About</a></li>
                                    <li><a href="{{ route('contact-us') }}">Contact</a></li>
                                    <li><a href="{{ route('faq') }}">FAQ</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h3>Departments</h3>
                                <ul>
                                    @foreach ($categories as $category)
                                        <li><a href="{{ route('list-products.index', ['category' => $category->slug]) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="single-footer f-link">
                                <h3>Store Info</h3>
                                <ul>
                                    <li><a href="javascript:void(0)">Secure checkout</a></li>
                                    <li><a href="javascript:void(0)">Fast fulfillment</a></li>
                                    <li><a href="javascript:void(0)">Reliable support</a></li>
                                    <li><a href="javascript:void(0)">USD default pricing</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="inner-content">
                    <div class="row align-items-center">
                        <div class="col-lg-4 col-12">
                            <div class="payment-gateway">
                                <span>Accepted Payments:</span>
                                <img src="{{ asset('assets/images/footer/credit-cards-footer.png') }}" alt="Payments">
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <div class="copyright">
                                <p>Designed for {{ $settings->name }}</p>
                            </div>
                        </div>
                        <div class="col-lg-4 col-12">
                            <ul class="socila">
                                <li><span>Follow Us:</span></li>
                                <li><a href="#"><i class="lni lni-facebook-filled"></i></a></li>
                                <li><a href="#"><i class="lni lni-twitter-original"></i></a></li>
                                <li><a href="#"><i class="lni lni-instagram"></i></a></li>
                                <li><a href="#"><i class="lni lni-linkedin-original"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <a href="#" class="scroll-top">
        <i class="lni lni-chevron-up"></i>
    </a>

    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/tiny-slider.js') }}"></script>
    <script src="{{ asset('assets/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    @stack('scripts')
</body>

</html>
