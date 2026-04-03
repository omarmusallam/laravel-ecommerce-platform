<x-front-layout>
    @php
        $heroStyle = $product4 ? "background-image:url('{$product4->image_url}')" : '';
        $sideBannerStyle = $product5 ? "background-image:url('{$product5->image_url}'); background-size: 70%" : '';
        $promoBannerOneStyle = $product6 ? "background-image:url('{$product6->image_url}'); background-size: 100%" : '';
        $promoBannerTwoStyle = $product7 ? "background-image:url('{$product7->image_url}'); background-size: 100%" : '';
        $specialBannerStyle = $product8 ? "background-image:url('{$product8->image_url}')" : '';
    @endphp

    <section class="hero-area">
        <div class="container">
            <x-alert type="info" />
            <x-alert type="success" />
            <div class="row">
                <div class="col-lg-8 col-12 custom-padding-right">
                    <div class="slider-head">
                        <div class="hero-slider">
                            <div class="single-slider" style="{{ $heroStyle }}">
                                <div class="content">
                                    <h2>{{ $product4?->name ?? 'أفضل الأجهزة الرقمية في مكان واحد' }}</h2>
                                    <p style="color: white">
                                        {{ $product4?->description ?? 'اكتشف تشكيلة احترافية من اللابتوبات والجوالات والشاشات والكاميرات بأسعار واضحة وتجربة شراء سلسة.' }}
                                    </p>
                                    @if ($product4)
                                        <h3>{{ App\Helpers\Currency::format($product4->price) }}</h3>
                                    @endif
                                    <div class="button">
                                        <a href="{{ route('list-products.index') }}" class="btn">تسوق الآن</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="hero-small-banner" style="{{ $sideBannerStyle }}">
                                <div class="content" style="margin-top: 30px">
                                    <h2 style="font-size: 17px" dir="rtl">{{ $product5?->name ?? 'مختارات العملاء' }}</h2>
                                    @if ($product5)
                                        <h3 style="font-size: 17px" dir="rtl">{{ App\Helpers\Currency::format($product5->price) }}</h3>
                                    @endif
                                    <div class="button" style="padding-top: 30px; border-radius: 5px;">
                                        <a class="btn" style="background-color: #000; color: #fff" dir="rtl"
                                            href="{{ route('list-products.index') }}">تسوق الآن</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-6 col-12">
                            <div class="hero-small-banner style2">
                                <div class="content">
                                    <h2 style="font-size: 17px" dir="rtl">عروض مستمرة</h2>
                                    <p style="font-size: 17px" dir="rtl">خصومات مدروسة على الأجهزة والإكسسوارات المختارة مع تحديثات مستمرة للمنتجات الجديدة.</p>
                                    <div class="button">
                                        <a class="btn" href="{{ route('list-products.index') }}">استعرض العروض</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="trending-product section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>منتجات ننصح بها</h2>
                        <p>مجموعة مختارة من الأجهزة والمنتجات الرقمية الأكثر طلبًا، تم تنظيمها لتناسب الاستخدام المنزلي والمهني والاحترافي.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                @forelse ($products as $product)
                    <div class="col-lg-3 col-md-6 col-12">
                        <x-product-card :product="$product" />
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-info mb-0">ستظهر المنتجات هنا بعد إضافة البيانات إلى المتجر.</div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="banner section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-banner" style="{{ $promoBannerOneStyle }}">
                        <div class="content">
                            <h2>{{ $product6?->name ?? 'وصل حديثًا' }}</h2>
                            <div class="button">
                                <a href="{{ route('list-products.index') }}" class="btn">تسوق الآن</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-12">
                    <div class="single-banner custom-responsive-margin" style="{{ $promoBannerTwoStyle }}">
                        <div class="content">
                            <h2>{{ $product7?->name ?? 'أفضل الصفقات' }}</h2>
                            <div class="button">
                                <a href="{{ route('list-products.index') }}" class="btn">تسوق الآن</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="special-offer section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-title">
                        <h2>أحدث المنتجات</h2>
                        <p>اكتشف أحدث ما تمت إضافته إلى المتجر من أجهزة رقمية وإلكترونيات مختارة بعناية وجودة واضحة.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 col-md-12 col-12">
                    <div class="row">
                        @foreach ($products2 as $product)
                            <div class="col-lg-4 col-md-6 col-12">
                                <x-product-card :product="$product" />
                            </div>
                        @endforeach
                    </div>
                    <div class="single-banner right" style="{{ $specialBannerStyle }};margin-top: 30px;">
                        <div class="content">
                            <h2>{{ $product8?->name ?? 'اكتشف المزيد من المنتجات' }}</h2>
                            <p>{{ $product8?->description ?? 'استعرض المزيد من الخيارات العملية والاحترافية المناسبة للعمل والمنزل والاستخدام اليومي.' }}</p>
                            @if ($product8)
                                <div class="price">
                                    <span>{{ App\Helpers\Currency::format($product8->price) }}</span>
                                </div>
                            @endif
                            <div class="button">
                                <a href="{{ $product8 ? route('products.show', $product8->slug) : route('list-products.index') }}"
                                    class="btn">عرض المنتج</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="offer-content">
                        <div class="image">
                            @if ($product3)
                                <img src="{{ $product3->image_url }}" alt="{{ $product3->name }}">
                            @endif
                            @if ($product3?->sale_percent)
                                <span class="sale-tag">-{{ $product3->sale_percent }}%</span>
                            @endif
                        </div>

                        <div class="text">
                            <h2>
                                <a href="{{ $product3 ? route('products.show', $product3->slug) : route('list-products.index') }}">
                                    {{ $product3?->name ?? 'عرض مميز' }}
                                </a>
                            </h2>
                            <ul class="review">
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><i class="lni lni-star-filled"></i></li>
                                <li><span>5.0 تقييم</span></li>
                            </ul>
                            @if ($product3)
                                <div class="price">
                                    <span>{{ App\Helpers\Currency::format($product3->price) }}</span>
                                    <span class="discount-price">{{ App\Helpers\Currency::format($product3->compare_price) }}</span>
                                </div>
                            @endif
                            <p>{{ $product3?->description ?? 'مساحة مخصصة لإبراز أحد أهم المنتجات ذات القيمة العالية في المتجر.' }}</p>

                            <div class="button" style="display: flex; justify-content: center; align-items: center;">
                                <a href="{{ $product3 ? route('products.show', $product3->slug) : route('list-products.index') }}" class="btn"><i
                                        class="lni lni-cart"></i>أضف إلى السلة</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="shipping-info">
        <div class="container">
            <ul>
                <li>
                    <div class="media-icon">
                        <i class="lni lni-delivery"></i>
                    </div>
                    <div class="media-body">
                        <h5>تنفيذ منظم للطلبات</h5>
                        <span>معالجة واضحة وسريعة للمنتجات وتجربة شراء مستقرة.</span>
                    </div>
                </li>
                <li>
                    <div class="media-icon">
                        <i class="lni lni-support"></i>
                    </div>
                    <div class="media-body">
                        <h5>دعم مستمر</h5>
                        <span>مساعدة سريعة عبر القنوات المتاحة في المتجر.</span>
                    </div>
                </li>
                <li>
                    <div class="media-icon">
                        <i class="lni lni-credit-cards"></i>
                    </div>
                    <div class="media-body">
                        <h5>دفع آمن</h5>
                        <span>إعداد جاهز لبوابات دفع إلكترونية موثوقة.</span>
                    </div>
                </li>
                <li>
                    <div class="media-icon">
                        <i class="lni lni-reload"></i>
                    </div>
                    <div class="media-body">
                        <h5>تجربة شراء مرنة</h5>
                        <span>تنقل واضح وواجهة سهلة للبحث والمقارنة.</span>
                    </div>
                </li>
            </ul>
        </div>
    </section>

    @push('scripts')
        <script type="text/javascript">
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
    @endpush
</x-front-layout>
