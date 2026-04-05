<x-front-layout :title="$product->name">
    @push('styles')
        <style>
            .product-shell {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 24%, #f8fafc 100%);
            }

            .product-breadcrumbs {
                padding: 22px 0 10px;
            }

            .product-breadcrumbs .breadcrumb-nav {
                margin: 0;
                padding: 0;
                list-style: none;
                display: flex;
                flex-wrap: wrap;
                gap: 10px;
                color: #667085;
                font-size: 14px;
            }

            .product-breadcrumbs .breadcrumb-nav a {
                color: #667085;
            }

            .product-detail-card {
                background: #fff;
                border: 1px solid #e8eef7;
                border-radius: 28px;
                padding: 28px;
                box-shadow: 0 24px 50px rgba(15, 23, 42, 0.07);
            }

            .product-gallery-main {
                min-height: 520px;
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(180deg, #ffffff 0%, #f6f9ff 100%);
                border: 1px solid #e8eef7;
                border-radius: 24px;
                padding: 26px;
            }

            .product-gallery-main img {
                width: 100%;
                max-height: 460px;
                object-fit: contain;
            }

            .product-gallery-thumbs {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-top: 16px;
            }

            .product-gallery-thumbs .img {
                width: 88px;
                height: 88px;
                object-fit: contain;
                background: #fff;
                border: 1px solid #dce7f5;
                border-radius: 16px;
                padding: 10px;
                cursor: pointer;
                transition: all 0.2s ease;
            }

            .product-gallery-thumbs .img:hover {
                border-color: #0167f3;
                box-shadow: 0 10px 22px rgba(1, 103, 243, 0.12);
            }

            .product-summary {
                padding-left: 10px;
            }

            .product-chip {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 8px 14px;
                border-radius: 999px;
                background: #edf4ff;
                color: #0167f3;
                font-size: 12px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.06em;
                margin-bottom: 18px;
            }

            .product-summary .title {
                font-size: clamp(2rem, 4vw, 3rem);
                line-height: 1.1;
                margin-bottom: 14px;
                color: #081828;
            }

            .product-meta {
                display: flex;
                flex-wrap: wrap;
                gap: 12px;
                margin-bottom: 18px;
                color: #667085;
                font-size: 14px;
            }

            .product-meta a {
                color: #0167f3;
                font-weight: 600;
            }

            .product-summary .price {
                display: flex;
                align-items: baseline;
                gap: 14px;
                flex-wrap: wrap;
                margin-bottom: 18px;
            }

            .product-summary .price strong {
                color: #081828;
                font-size: 40px;
                line-height: 1;
                font-weight: 800;
            }

            .product-summary .price span {
                color: #98a2b3;
                font-size: 22px;
                text-decoration: line-through;
            }

            .product-summary .info-text {
                color: #667085;
                line-height: 1.85;
                margin-bottom: 26px;
                max-width: 560px;
            }

            .purchase-panel {
                display: flex;
                flex-wrap: wrap;
                gap: 16px;
                align-items: end;
                padding: 22px;
                border-radius: 22px;
                background: #f8fbff;
                border: 1px solid #e4edf8;
            }

            .purchase-panel .form-group {
                margin: 0;
                min-width: 150px;
            }

            .purchase-panel label {
                display: block;
                color: #667085;
                font-size: 13px;
                font-weight: 600;
                margin-bottom: 8px;
            }

            .purchase-panel .form-control {
                height: 52px;
                border-radius: 14px;
                border-color: #d6e3f2;
                box-shadow: none;
            }

            .purchase-panel .btn {
                min-width: 180px;
                height: 52px;
                border-radius: 999px;
                font-weight: 700;
                box-shadow: 0 16px 30px rgba(1, 103, 243, 0.18);
            }

            .stock-note {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                margin-top: 18px;
                padding: 9px 14px;
                border-radius: 999px;
                background: #f3fbf7;
                color: #16794f;
                font-size: 13px;
                font-weight: 600;
            }

            @media (max-width: 991.98px) {
                .product-summary {
                    padding-left: 0;
                    margin-top: 24px;
                }

                .product-gallery-main {
                    min-height: 420px;
                }
            }

            @media (max-width: 767.98px) {
                .product-detail-card {
                    padding: 20px;
                    border-radius: 22px;
                }

                .product-gallery-main {
                    min-height: 320px;
                    padding: 18px;
                }

                .product-gallery-thumbs .img {
                    width: 72px;
                    height: 72px;
                }

                .purchase-panel {
                    padding: 18px;
                }

                .purchase-panel .btn,
                .purchase-panel .form-group {
                    width: 100%;
                }
            }
        </style>
    @endpush

    <section class="product-shell section">
        <div class="container">
            <div class="product-breadcrumbs">
                <ul class="breadcrumb-nav">
                    <li><a href="{{ route('home') }}"><i class="lni lni-home"></i> Home</a></li>
                    <li>/</li>
                    <li><a href="{{ route('list-products.index') }}">Store</a></li>
                    <li>/</li>
                    <li>{{ $product->name }}</li>
                </ul>
            </div>

            <div id="notice" style="display:none;background-color:#0167F3;color:white;padding:10px;border:1px solid #ccc;border-radius:4px;margin-bottom:10px;position:fixed;width:220px;top:20px;right:20px;z-index:9999;"></div>

            <div class="product-detail-card">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6 col-12">
                        <div class="product-images">
                            <main id="gallery">
                                <div class="product-gallery-main">
                                    <img src="{{ $product->image_url }}" id="current" alt="{{ $product->name }}">
                                </div>
                                <div class="product-gallery-thumbs">
                                    <img src="{{ $product->image_url }}" class="img" alt="{{ $product->name }}">
                                    @foreach ($product->images as $image)
                                        <img src="{{ $image->image_url }}" class="img" alt="{{ $product->name }}">
                                    @endforeach
                                </div>
                            </main>
                        </div>
                    </div>

                    <div class="col-lg-6 col-12">
                        <div class="product-summary">
                            <span class="product-chip">ShopGrids Product</span>
                            <h1 class="title">{{ $product->name }}</h1>

                            <div class="product-meta">
                                <span><i class="lni lni-tag"></i> Category:</span>
                                <a href="{{ route('list-products.index', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
                            </div>

                            <div class="price">
                                <strong>{{ Currency::format($product->price) }}</strong>
                                @if ($product->compare_price)
                                    <span>{{ Currency::format($product->compare_price) }}</span>
                                @endif
                            </div>

                            <p class="info-text">{{ $product->description }}</p>

                            <form action="{{ route('cart.store') }}" method="post" id="cart-form">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="purchase-panel">
                                    <div class="form-group quantity">
                                        <label for="quantity">Quantity</label>
                                        <select class="form-control" name="quantity" id="quantity">
                                            @for ($quantity = 1; $quantity <= max(1, min(10, $product->quantity)); $quantity++)
                                                <option value="{{ $quantity }}">{{ $quantity }}</option>
                                            @endfor
                                        </select>
                                    </div>

                                    <div class="button cart-button">
                                        <a class="btn" id="add-to-cart" href="#">Add to Cart</a>
                                    </div>
                                </div>

                                <div class="stock-note">
                                    <i class="lni lni-checkmark-circle"></i>
                                    In stock: {{ $product->quantity }} units
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @push('scripts')
        <script type="text/javascript">
            const current = document.getElementById("current");
            const opacity = 0.6;
            const imgs = document.querySelectorAll(".img");
            imgs.forEach(img => {
                img.addEventListener("click", (e) => {
                    imgs.forEach(img => {
                        img.style.opacity = 1;
                    });
                    current.src = e.target.src;
                    e.target.style.opacity = opacity;
                });
            });
        </script>
        <script src="{{ asset('js/cart.js') }}"></script>
    @endpush
</x-front-layout>
