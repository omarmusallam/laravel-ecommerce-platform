<x-front-layout>
    @push('styles')
        <style>
            .home-shell {
                background:
                    radial-gradient(circle at top right, rgba(1, 103, 243, 0.09), transparent 22rem),
                    linear-gradient(180deg, #f8fbff 0%, #ffffff 28%, #f8fafc 100%);
            }

            .hero-showcase {
                padding: 34px 0 22px;
            }

            .hero-panel {
                position: relative;
                overflow: hidden;
                min-height: 500px;
                border-radius: 28px;
                padding: 40px;
                background: linear-gradient(135deg, #0b1d34 0%, #112844 58%, #1f69d8 100%);
                color: #fff;
                box-shadow: 0 28px 60px rgba(8, 24, 40, 0.18);
            }

            .hero-panel::before {
                content: "";
                position: absolute;
                inset: auto -80px -120px auto;
                width: 340px;
                height: 340px;
                border-radius: 50%;
                background: radial-gradient(circle, rgba(255, 255, 255, 0.22), transparent 68%);
                pointer-events: none;
            }

            .hero-panel::after {
                content: "";
                position: absolute;
                inset: 0;
                background: linear-gradient(90deg, rgba(8, 24, 40, 0.88) 0%, rgba(8, 24, 40, 0.56) 45%, rgba(8, 24, 40, 0.08) 100%);
                pointer-events: none;
            }

            .hero-panel > * {
                position: relative;
                z-index: 1;
            }

            .hero-copy {
                max-width: 470px;
                padding-right: 16px;
            }

            .hero-eyebrow {
                display: inline-flex;
                align-items: center;
                gap: 10px;
                padding: 8px 14px;
                border-radius: 999px;
                font-size: 12px;
                font-weight: 700;
                letter-spacing: 0.08em;
                text-transform: uppercase;
                background: rgba(255, 255, 255, 0.12);
                border: 1px solid rgba(255, 255, 255, 0.18);
                margin-bottom: 18px;
            }

            .hero-copy h1 {
                color: #fff;
                font-size: clamp(2.1rem, 4vw, 3.6rem);
                line-height: 1.04;
                margin-bottom: 14px;
            }

            .hero-copy p {
                color: rgba(255, 255, 255, 0.82);
                font-size: 15px;
                line-height: 1.75;
                margin-bottom: 22px;
                max-width: 430px;
            }

            .hero-price {
                display: flex;
                align-items: center;
                gap: 14px;
                flex-wrap: wrap;
                margin-bottom: 24px;
            }

            .hero-price .current {
                font-size: 34px;
                font-weight: 800;
                line-height: 1;
            }

            .hero-price .compare {
                color: rgba(255, 255, 255, 0.55);
                font-size: 18px;
                text-decoration: line-through;
            }

            .hero-actions {
                display: flex;
                align-items: center;
                gap: 12px;
                flex-wrap: wrap;
                margin-bottom: 0;
            }

            .hero-actions .btn {
                min-height: 48px;
                padding: 0 22px;
                border-radius: 999px;
                font-weight: 700;
                box-shadow: 0 16px 30px rgba(5, 16, 32, 0.14);
            }

            .hero-actions .btn:first-child {
                background: #fff;
                border-color: #fff;
                color: #081828;
            }

            .hero-actions .btn:first-child:hover {
                background: #edf4ff;
                border-color: #edf4ff;
                color: #081828;
            }

            .hero-actions .btn-secondary-soft {
                border: 1px solid rgba(255, 255, 255, 0.22);
                background: rgba(255, 255, 255, 0.1);
                color: #fff;
            }

            .hero-actions .btn-secondary-soft:hover {
                background: rgba(255, 255, 255, 0.18);
                color: #fff;
            }

            .hero-visual {
                display: flex;
                align-items: center;
                justify-content: center;
                min-height: 430px;
            }

            .hero-product-frame {
                width: min(100%, 420px);
                aspect-ratio: 1 / 1;
                border-radius: 28px;
                background: linear-gradient(180deg, rgba(255, 255, 255, 0.22), rgba(255, 255, 255, 0.08));
                border: 1px solid rgba(255, 255, 255, 0.14);
                padding: 28px;
                box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.18);
                backdrop-filter: blur(12px);
            }

            .hero-product-frame img {
                width: 100%;
                height: 100%;
                object-fit: contain;
                object-position: center;
                filter: drop-shadow(0 26px 36px rgba(0, 0, 0, 0.22));
            }

            .hero-side-grid {
                display: grid;
                gap: 24px;
                height: 100%;
            }

            .mini-spotlight,
            .insight-card,
            .home-feature-card,
            .home-feature-copy,
            .latest-feature-card {
                border-radius: 26px;
                overflow: hidden;
                background: #fff;
                box-shadow: 0 22px 50px rgba(15, 23, 42, 0.09);
            }

            .mini-spotlight {
                display: grid;
                grid-template-columns: 138px 1fr;
                min-height: 248px;
            }

            .mini-spotlight-media,
            .home-feature-media,
            .latest-feature-media {
                display: flex;
                align-items: center;
                justify-content: center;
                background: linear-gradient(180deg, #f8fbff 0%, #eef4ff 100%);
                padding: 24px;
            }

            .mini-spotlight-media img,
            .home-feature-media img,
            .latest-feature-media img {
                width: 100%;
                height: 100%;
                object-fit: contain;
            }

            .mini-spotlight-body,
            .insight-card,
            .home-feature-body,
            .home-feature-copy,
            .latest-feature-body {
                padding: 28px;
            }

            .section-chip {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                padding: 7px 12px;
                border-radius: 999px;
                background: #edf4ff;
                color: #0167f3;
                font-size: 11px;
                font-weight: 700;
                text-transform: uppercase;
                letter-spacing: 0.08em;
                margin-bottom: 12px;
            }

            .mini-spotlight-body h3,
            .insight-card h3,
            .home-feature-copy h3,
            .home-feature-body h3,
            .latest-feature-body h3 {
                font-size: 20px;
                line-height: 1.2;
                margin-bottom: 10px;
                color: #081828;
            }
            .mini-spotlight-body p,
            .insight-card p,
            .section-copy p,
            .home-feature-copy p,
            .home-feature-body p,
            .latest-feature-body p {
                color: #667085;
                line-height: 1.7;
                margin-bottom: 0;
            }

            .mini-spotlight-price,
            .home-feature-body .price,
            .latest-feature-body .price {
                display: flex;
                align-items: baseline;
                gap: 10px;
                flex-wrap: wrap;
                margin: 14px 0 18px;
            }

            .mini-spotlight-price {
                color: #0167f3;
                font-size: 22px;
                font-weight: 800;
            }

            .mini-spotlight-body .btn,
            .home-feature-body .btn,
            .latest-feature-body .btn {
                min-height: 46px;
                padding: 0 20px;
                border-radius: 999px;
                background: #0167f3;
                border-color: #0167f3;
                color: #fff;
                font-weight: 700;
                box-shadow: 0 14px 28px rgba(1, 103, 243, 0.18);
            }

            .mini-spotlight-body .btn:hover,
            .home-feature-body .btn:hover,
            .latest-feature-body .btn:hover {
                background: #0052c2;
                border-color: #0052c2;
                color: #fff;
            }

            .mini-spotlight-price span,
            .home-feature-body .price span,
            .latest-feature-body .price span {
                color: #98a2b3;
                font-size: 14px;
                font-weight: 500;
                text-decoration: line-through;
            }

            .home-feature-body .price strong,
            .latest-feature-body .price strong {
                color: #0167f3;
                font-size: 30px;
                line-height: 1;
            }

            .insight-card {
                background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            }

            .section-copy {
                max-width: 650px;
                margin: 0 auto 30px;
                text-align: center;
            }

            .section-copy h2 {
                margin-bottom: 10px;
                color: #081828;
                font-size: clamp(2rem, 3vw, 3.1rem);
            }

            .home-feature-band {
                padding: 8px 0 20px;
            }

            .home-feature-grid {
                display: grid;
                grid-template-columns: 1.1fr 0.9fr;
                gap: 28px;
                align-items: stretch;
            }

            .home-feature-card {
                display: grid;
                grid-template-columns: 1fr 1fr;
                min-height: 320px;
            }

            .home-feature-body {
                display: flex;
                flex-direction: column;
                justify-content: center;
            }

            .home-feature-copy {
                background: linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
                border: 1px solid #e7eef9;
                color: #081828;
            }

            .home-feature-copy .section-chip {
                background: #edf4ff;
                color: #0167f3;
                border: 0;
            }

            .home-feature-copy h3 {
                color: #081828;
            }

            .home-feature-copy p {
                color: #667085;
                margin-bottom: 0;
                max-width: 420px;
            }

            .latest-grid {
                align-items: stretch;
            }

            .latest-feature-card {
                height: 100%;
                margin-top: 0;
                display: flex;
                flex-direction: column;
            }

            .latest-feature-media {
                min-height: 300px;
                background: linear-gradient(180deg, #f1f6ff 0%, #ffffff 100%);
            }

            .latest-feature-body {
                display: flex;
                flex-direction: column;
                gap: 14px;
                flex: 1;
            }

            .latest-feature-body .description {
                color: #667085;
                line-height: 1.75;
                display: -webkit-box;
                -webkit-line-clamp: 4;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            .trust-section {
                padding: 18px 0 56px;
            }

            .trust-grid {
                display: grid;
                grid-template-columns: repeat(4, minmax(0, 1fr));
                gap: 22px;
            }

            .trust-card {
                padding: 24px 20px;
                border-radius: 22px;
                background: #fff;
                border: 1px solid #e9eef7;
                box-shadow: 0 20px 45px rgba(15, 23, 42, 0.05);
                text-align: left;
                min-height: 100%;
            }

            .trust-card .media-icon {
                width: 52px;
                height: 52px;
                border-radius: 16px;
                background: linear-gradient(135deg, #eef5ff 0%, #dce9ff 100%);
                display: inline-flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 16px;
            }

            .trust-card .media-icon i {
                color: #0167f3;
                font-size: 20px;
            }
            .trust-card h5 {
                margin-bottom: 8px;
                color: #081828;
            }

            .trust-card span {
                color: #667085;
                line-height: 1.7;
                font-size: 14px;
                display: block;
            }

            @media (max-width: 1199.98px) {
                .hero-panel {
                    padding: 34px;
                }

                .home-feature-grid {
                    grid-template-columns: 1fr;
                }
            }

            @media (max-width: 991.98px) {
                .hero-panel {
                    min-height: auto;
                }

                .hero-showcase {
                    padding-top: 24px;
                }

                .hero-visual {
                    min-height: 320px;
                    margin-top: 24px;
                }

                .hero-side-grid {
                    margin-top: 24px;
                }

                .mini-spotlight {
                    grid-template-columns: 120px 1fr;
                }

                .trust-grid {
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                }
            }

            @media (max-width: 767.98px) {
                .hero-panel {
                    padding: 24px;
                    border-radius: 22px;
                }

                .hero-actions {
                    flex-direction: column;
                    align-items: stretch;
                }

                .hero-actions .btn {
                    width: 100%;
                }

                .mini-spotlight,
                .home-feature-card {
                    grid-template-columns: 1fr;
                }

                .mini-spotlight-media {
                    min-height: 190px;
                }

                .latest-feature-media {
                    min-height: 240px;
                }

                .trust-grid {
                    grid-template-columns: 1fr;
                }

            }
        </style>
    @endpush

    <div class="home-shell">
        <section class="hero-showcase">
            <div class="container">
                <x-alert type="info" />
                <x-alert type="success" />

                <div class="row g-4 align-items-stretch">
                    <div class="col-xl-8 col-lg-7">
                        <div class="hero-panel">
                            <div class="row align-items-center g-4">
                                <div class="col-lg-6">
                                    <div class="hero-copy">
                                        <span class="hero-eyebrow">
                                            <i class="lni lni-bolt"></i>
                                            ShopGrids Collection
                                        </span>
                                        <h1>{{ $product4?->name ?? 'Performance tech for work, play, and everyday life' }}</h1>
                                        <p>{{ $product4?->description ?? 'Discover premium electronics with clean presentation, calm spacing, and a smoother shopping experience.' }}</p>

                                        @if ($product4)
                                            <div class="hero-price">
                                                <span class="current">{{ App\Helpers\Currency::format($product4->price) }}</span>
                                                @if ($product4->compare_price)
                                                    <span class="compare">{{ App\Helpers\Currency::format($product4->compare_price) }}</span>
                                                @endif
                                            </div>
                                        @endif

                                        <div class="hero-actions">
                                            <a href="{{ $product4 ? route('products.show', $product4->slug) : route('list-products.index') }}" class="btn">View Product</a>
                                            <a href="{{ route('list-products.index') }}" class="btn btn-secondary-soft">Explore Catalog</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="hero-visual">
                                        <div class="hero-product-frame">
                                            @if ($product4)
                                                <img src="{{ $product4->image_url }}" alt="{{ $product4->name }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-5">
                        <div class="hero-side-grid">
                            <article class="mini-spotlight">
                                <div class="mini-spotlight-media">
                                    @if ($product5)
                                        <img src="{{ $product5->image_url }}" alt="{{ $product5->name }}">
                                    @endif
                                </div>
                                <div class="mini-spotlight-body">
                                    <span class="section-chip">Top Pick This Week</span>
                                    <h3>{{ $product5?->name ?? 'Customer Favorite' }}</h3>
                                    <p>One of this week&apos;s standout picks for value and everyday performance.</p>
                                    @if ($product5)
                                        <div class="mini-spotlight-price">
                                            {{ App\Helpers\Currency::format($product5->price) }}
                                            @if ($product5->compare_price)
                                                <span>{{ App\Helpers\Currency::format($product5->compare_price) }}</span>
                                            @endif
                                        </div>
                                    @endif
                                    <a href="{{ $product5 ? route('products.show', $product5->slug) : route('list-products.index') }}" class="btn btn-sm">Shop Now</a>
                                </div>
                            </article>

                            <div class="insight-card">
                                <span class="section-chip">Quiet Luxury</span>
                                <h3>Refined shopping for premium everyday tech</h3>
                                <p>Clean layout, quieter visuals, and a more elegant storefront for browsing with ease.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="trending-product section pt-5">
            <div class="container">
                <div class="section-copy">
                    <h2>Recommended Products</h2>
                    <p>Customer favorites and reliable devices selected for everyday performance.</p>
                </div>

                <div class="row product-card-grid">
                    @forelse ($products as $product)
                        <div class="col-xl-3 col-md-6 col-12 product-card-column">
                            <x-product-card :product="$product" />
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="alert alert-info mb-0">Products will appear here after the catalog is seeded.</div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
        <section class="home-feature-band">
            <div class="container">
                <div class="home-feature-grid">
                    <article class="home-feature-card">
                        <div class="home-feature-media">
                            @if ($product6)
                                <img src="{{ $product6->image_url }}" alt="{{ $product6->name }}">
                            @endif
                        </div>
                        <div class="home-feature-body">
                            <span class="section-chip">New Arrival</span>
                            <h3>{{ $product6?->name ?? 'Fresh gear worth a closer look' }}</h3>
                            <p>{{ $product6?->description ?? 'A recent arrival highlighted with a cleaner, calmer presentation.' }}</p>
                            @if ($product6)
                                <div class="price">
                                    <strong>{{ App\Helpers\Currency::format($product6->price) }}</strong>
                                    @if ($product6->compare_price)
                                        <span>{{ App\Helpers\Currency::format($product6->compare_price) }}</span>
                                    @endif
                                </div>
                            @endif
                            <div>
                                <a href="{{ $product6 ? route('products.show', $product6->slug) : route('list-products.index') }}" class="btn">View Product</a>
                            </div>
                        </div>
                    </article>

                    <aside class="home-feature-copy">
                        <span class="section-chip">ShopGrids Selection</span>
                        <h3>Curated products, presented with clarity</h3>
                        <p>A softer visual rhythm, cleaner cards, and clearer spacing keep the focus on products and pricing.</p>
                    </aside>
                </div>
            </div>
        </section>

        <section class="special-offer section pt-4">
            <div class="container">
                <div class="section-copy">
                    <h2>Latest Additions</h2>
                    <p>The latest products added to the store, highlighted in a cleaner and more balanced layout.</p>
                </div>

                <div class="row product-card-grid latest-grid">
                    <div class="col-xl-8 col-12">
                        <div class="row product-card-grid">
                            @foreach ($products2 as $product)
                                <div class="col-lg-4 col-md-6 col-12 product-card-column">
                                    <x-product-card :product="$product" />
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-xl-4 col-12">
                        <article class="latest-feature-card">
                            <div class="latest-feature-media">
                                @if ($product3)
                                    <img src="{{ $product3->image_url }}" alt="{{ $product3->name }}">
                                @endif
                            </div>
                            <div class="latest-feature-body">
                                <span class="section-chip">Featured Offer</span>
                                <h3>{{ $product3?->name ?? 'A premium device worth highlighting' }}</h3>
                                @if ($product3)
                                    <div class="price">
                                        <strong>{{ App\Helpers\Currency::format($product3->price) }}</strong>
                                        @if ($product3->compare_price)
                                            <span>{{ App\Helpers\Currency::format($product3->compare_price) }}</span>
                                        @endif
                                    </div>
                                @endif
                                <p class="description">{{ $product3?->description ?? 'A featured product with strong performance and a clean path to product details.' }}</p>
                                <div>
                                    <a href="{{ $product3 ? route('products.show', $product3->slug) : route('list-products.index') }}" class="btn">View Product</a>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </div>
        </section>

        <section class="trust-section">
            <div class="container">
                <div class="trust-grid">
                    <article class="trust-card">
                        <div class="media-icon"><i class="lni lni-delivery"></i></div>
                        <h5>Fast Order Handling</h5>
                        <span>A smoother shopping flow that keeps browsing, cart actions, and checkout easier to follow.</span>
                    </article>
                    <article class="trust-card">
                        <div class="media-icon"><i class="lni lni-support"></i></div>
                        <h5>Responsive Support</h5>
                        <span>Helpful store communication for customers who need quick answers before or after purchase.</span>
                    </article>
                    <article class="trust-card">
                        <div class="media-icon"><i class="lni lni-credit-cards"></i></div>
                        <h5>Secure Payment</h5>
                        <span>Trusted payment flow with clearer pricing and a more reassuring checkout experience.</span>
                    </article>
                    <article class="trust-card">
                        <div class="media-icon"><i class="lni lni-reload"></i></div>
                        <h5>Flexible Shopping</h5>
                        <span>Responsive sections and cleaner browsing that feel consistent across desktop, tablet, and mobile.</span>
                    </article>
                </div>
            </div>
        </section>
    </div>
</x-front-layout>
