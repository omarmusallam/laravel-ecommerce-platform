<x-front-layout title="{{ __('About Us') }}">
    @push('styles')
        <style>
            .about-shell {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 24%, #f8fafc 100%);
            }

            .about-hero {
                padding: 24px 0 14px;
            }

            .about-hero p {
                color: #667085;
                max-width: 720px;
                margin-bottom: 0;
            }

            .about-card {
                background: #fff;
                border: 1px solid #e8eef7;
                border-radius: 28px;
                padding: 28px;
                box-shadow: 0 24px 50px rgba(15, 23, 42, 0.06);
            }

            .about-card img {
                width: 100%;
                height: 100%;
                min-height: 420px;
                object-fit: cover;
                border-radius: 22px;
            }

            .about-copy {
                padding-left: 12px;
            }

            .about-chip {
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
                margin-bottom: 16px;
            }

            .about-copy h2 {
                font-size: clamp(2rem, 4vw, 3rem);
                line-height: 1.15;
                margin-bottom: 16px;
            }

            .about-copy p {
                color: #667085;
                line-height: 1.9;
                margin-bottom: 16px;
            }

            @media (max-width: 991.98px) {
                .about-copy {
                    padding-left: 0;
                    margin-top: 24px;
                }

                .about-card img {
                    min-height: 320px;
                }
            }
        </style>
    @endpush

    <section class="about-us section about-shell">
        <div class="container">
            <div class="about-hero">
                <h1>{{ __('About ShopGrids') }}</h1>
                <p>{{ __('A calmer, more refined electronics storefront built around reliable products, clear pricing, and a smoother customer experience.') }}</p>
            </div>

            <div class="about-card">
                <div class="row align-items-center g-4">
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="content-left">
                            <img src="{{ asset('assets/images/hero/slider-bg1.jpg') }}" alt="Digital Hub showroom">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-12">
                        <div class="content-right about-copy">
                            <span class="about-chip">ShopGrids Story</span>
                            <h2>{{ __('Modern electronics for everyday work and life.') }}</h2>
                            <p>{{ __('ShopGrids is an online electronics store focused on dependable devices, clear pricing, and a smooth shopping experience. We curate laptops, smartphones, monitors, accessories, and smart office essentials that balance quality, performance, and long-term value.') }}
                        </p>
                            <p>{{ __('Our catalog is built for customers who want practical technology without unnecessary friction. We focus on trusted product lines, clean product information, and responsive support so each order feels reliable from the first visit to final delivery.') }}
                        </p>
                            <p>{{ __('We continue to improve the storefront, payment flow, and after-sales support to make ShopGrids a stronger destination for modern e-commerce. Our team is ready to help with product questions, order guidance, and any issue that needs a fast, clear answer.') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About Area -->
</x-front-layout>
