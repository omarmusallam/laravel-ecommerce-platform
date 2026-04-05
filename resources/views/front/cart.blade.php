<x-front-layout title="{{ __('Cart') }}">
    @push('styles')
        <style>
            .cart-shell {
                background: linear-gradient(180deg, #f8fbff 0%, #ffffff 22%, #f8fafc 100%);
            }

            .cart-hero {
                padding: 24px 0 10px;
            }

            .cart-hero p {
                color: #667085;
                margin-bottom: 0;
            }

            .cart-panel,
            .cart-summary-card {
                background: #fff;
                border: 1px solid #e8eef7;
                border-radius: 24px;
                box-shadow: 0 18px 40px rgba(15, 23, 42, 0.05);
            }

            .cart-panel {
                padding: 10px 22px 22px;
            }

            .cart-list-title {
                border-bottom: 1px solid #edf2f7;
                margin-bottom: 6px;
            }

            .cart-list-title p {
                color: #667085;
                font-weight: 700;
                font-size: 13px;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }

            .cart-single-list {
                border-bottom: 1px solid #edf2f7;
                padding: 18px 0;
            }

            .cart-single-list:last-child {
                border-bottom: 0;
                padding-bottom: 6px;
            }

            .cart-single-list img {
                width: 86px;
                height: 86px;
                object-fit: contain;
                background: #f8fbff;
                border: 1px solid #e6edf7;
                border-radius: 16px;
                padding: 8px;
            }

            .cart-single-list .product-name a {
                color: #081828;
            }

            .cart-single-list .product-des span {
                color: #667085;
            }

            .cart-single-list .item-quantity {
                height: 46px;
                border-radius: 14px;
                border-color: #d6e3f2;
            }

            .cart-single-list .remove-item {
                width: 38px;
                height: 38px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                border-radius: 50%;
                background: #fff3f2;
                color: #e74c3c;
            }

            .cart-summary-card {
                padding: 24px;
                position: sticky;
                top: 24px;
            }

            .cart-summary-card h3 {
                margin-bottom: 18px;
            }

            .cart-summary-list {
                margin: 0 0 20px;
                padding: 0;
                list-style: none;
                display: grid;
                gap: 14px;
            }

            .cart-summary-list li {
                display: flex;
                justify-content: space-between;
                gap: 12px;
                color: #667085;
            }

            .cart-summary-list li.last {
                padding-top: 14px;
                border-top: 1px solid #edf2f7;
                color: #081828;
                font-weight: 700;
            }

            .cart-summary-card .button {
                display: grid;
                gap: 12px;
            }

            .cart-summary-card .btn {
                width: 100%;
                border-radius: 999px;
            }

            .notification-container {
                position: fixed;
                top: 20px;
                right: 20px;
                z-index: 9999;
            }

            .notification {
                padding: 10px;
                margin-bottom: 10px;
                color: #fff;
                font-weight: bold;
                border-radius: 10px;
            }

            .success {
                background-color: #0167F3;
            }

            .error {
                background-color: #f44336;
            }
        </style>
    @endpush

    <div class="shopping-cart section cart-shell">
        <div class="container">
            <div class="cart-hero">
                <h1>{{ __('Cart') }}</h1>
                <p>Review your selected items, adjust quantities, and continue to secure checkout.</p>
            </div>

            <x-alert type="success" />

            <div class="row g-4">
                <div class="col-lg-8">
                    <div class="cart-panel cart-list-head">
                        <!-- Cart List Title -->
                        <div class="cart-list-title">
                            <div class="row">
                                <div class="col-lg-1 col-md-1 col-12"></div>
                                <div class="col-lg-4 col-md-3 col-12">
                                    <p>{{ __('Product Name') }}</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>{{ __('Quantity') }}</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>{{ __('Price') }}</p>
                                </div>
                                <div class="col-lg-2 col-md-2 col-12">
                                    <p>{{ __('Subtotal') }}</p>
                                </div>
                                <div class="col-lg-1 col-md-2 col-12">
                                    <p>{{ __('Remove') }}</p>
                                </div>
                            </div>
                        </div>

                        <div id="notification-container" class="notification-container"></div>
                        @foreach ($cart->get() as $item)
                            <div class="cart-single-list" id="{{ $item->id }}">
                                <div class="row align-items-center">
                                    <div class="col-lg-1 col-md-1 col-12">
                                        <a href="{{ route('products.show', $item->product->slug) }}">
                                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}"></a>
                                    </div>
                                    <div class="col-lg-4 col-md-3 col-12">
                                        <h5 class="product-name"><a href="{{ route('products.show', $item->product->slug) }}">
                                                {{ $item->product->name }}</a></h5>
                                        <p class="product-des">
                                            <span><em>{{ __('Category:') }}</em> {{ $item->product->category->name }}</span>
                                            @if ($item->product->sale_percent)
                                                <span><em>{{ __('Discount:') }}</em> -{{ $item->product->sale_percent }}%</span>
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <div class="count-input">
                                            <input style="width: 100px" type="number" min="1" max="9"
                                                class="form-control item-quantity" data-id="{{ $item->id }}"
                                                value="{{ $item->quantity }}">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <p>{{ Currency::format($item->product->price) }}</p>
                                    </div>
                                    <div class="col-lg-2 col-md-2 col-12">
                                        <p id="item-total-{{ $item->id }}">
                                            {{ Currency::format($item->quantity * $item->product->price) }}</p>
                                    </div>
                                    <div class="col-lg-1 col-md-2 col-12">
                                        <a class="remove-item" data-id="{{ $item->id }}" href="javascript:void(0)"><i
                                                class="lni lni-close"></i></a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="cart-summary-card">
                        <h3>{{ __('Order Summary') }}</h3>
                        <ul class="cart-summary-list">
                            <li>{{ __('Cart Subtotal') }}<span id="cart-subtotal">{{ Currency::format($cart->total()) }}</span></li>
                            <li>{{ __('Shipping') }}<span>{{ __('Free') }}</span></li>
                            <li>{{ __('Tax') }}<span>{{ Currency::format(00.0) }}</span></li>
                            <li class="last">{{ __('You Pay') }}<span id="you-pay">{{ Currency::format($cart->total()) }}</span></li>
                        </ul>
                        <div class="button">
                            <a href="{{ route('checkout') }}" class="btn">{{ __('Checkout') }}</a>
                            <a href="{{ route('list-products.index') }}" class="btn btn-alt">{{ __('Continue Shopping') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const csrf_token = "{{ csrf_token() }}";
        </script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="{{ asset('js/cart.js') }}"></script>
    @endpush
</x-front-layout>
